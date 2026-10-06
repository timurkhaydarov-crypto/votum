<?php

namespace App\Http\Controllers;

use App\Jobs\SendRequestTelegramNotification;
use App\Mail\RequestSubmittedMail;
use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Request\Request as RequestModel;
use App\Models\Request\RequestItem;
use Illuminate\Support\Facades\App;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RequestController extends Controller
{
    /**
     * Create request.
     *
     * Request can be created:
     *
     * 1. From cart:
     *    - Request
     *    - RequestItems
     *    - cart is cleared
     *
     * 2. From contact/service form:
     *    - Request only
     *    - no RequestItems
     */
    public function store(Request $request): JsonResponse
    {
        $locale = $request->header('X-App-Locale');
        App::setLocale(in_array($locale, ['en', 'ru'], true)
            ? $locale
            : config('app.locale'));

        if (filled($request->input('website'))) {
            return response()->json([
                'request' => null,
            ], Response::HTTP_ACCEPTED);
        }

        $request->merge([
            'name' => is_string($request->input('name'))
                ? trim($request->input('name'))
                : $request->input('name'),
            'phone' => is_string($request->input('phone'))
                ? trim($request->input('phone'))
                : $request->input('phone'),
            'email' => is_string($request->input('email'))
                ? strtolower(trim($request->input('email')))
                : $request->input('email'),
            'comment' => is_string($request->input('comment'))
                ? trim($request->input('comment'))
                : $request->input('comment'),
            'subject' => is_string($request->input('subject'))
                ? trim($request->input('subject'))
                : $request->input('subject'),
        ]);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'min:2',
                'max:100',
            ],

            'phone' => [
                'bail',
                'required',
                'string',
                'max:32',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\\D/u', '', $value);

                    if (
                        ! preg_match('/^\\+?[0-9().\\s-]+$/u', $value)
                        || strlen($digits) < 7
                        || strlen($digits) > 15
                    ) {
                        $fail(__('validation.phone'));
                    }
                },
            ],

            'email' => [
                'bail',
                'required',
                'string',
                'email:rfc',
                'max:254',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'context' => [
                'nullable',
                'string',
                'in:cart,contact,service',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:150',
            ],
        ]);

        $context = $validated['context'] ?? 'contact';

        /*
         * Cart request.
         */
        if ($context === 'cart') {
            return $this->createCartRequest(
                $request,
                $validated
            );
        }

        /*
         * Contact/service request.
         */
        return $this->createContactRequest(
            $request,
            $validated
        );
    }

    /**
     * Create request from current session cart.
     */
    private function createCartRequest(
        Request $request,
        array $validated
    ): JsonResponse {
        /*
         * Get current cart from session.
         */
        $cartId = $request->session()->get('cart_id');

        if (! $cartId) {
            return response()->json([
                'message' => 'Your cart is empty.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /*
         * Load cart and products.
         */
        $cart = Cart::query()
            ->with([
                'items.product',
            ])
            ->find($cartId);

        if (! $cart) {
            return response()->json([
                'message' => 'Your cart is empty.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /*
         * Make sure cart contains products.
         */
        if ($cart->items->isEmpty()) {
            return response()->json([
                'message' => 'Your cart is empty.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /*
         * Make sure all products still exist.
         */
        $invalidItem = $cart->items->first(
            fn (CartItem $item) => ! $item->product
        );

        if ($invalidItem) {
            return response()->json([
                'message' => 'One or more products in the cart are no longer available.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $createdRequest = DB::transaction(
            function () use (
                $request,
                $cart,
                $validated
            ) {
                /*
                 * Create request.
                 */
                $requestModel = RequestModel::query()->create([
                    'number' => $this->generateRequestNumber(),

                    'session_id' => $request->session()->getId(),

                    'subject' => $validated['subject'] ?? null,

                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'] ?? null,
                    'comment' => $validated['comment'] ?? null,

                    'status' => 'pending',

                    'context' => 'cart',
                ]);

                /*
                 * Create RequestItems from CartItems.
                 *
                 * Product information is taken from the database,
                 * not from the frontend.
                 */
                foreach ($cart->items as $cartItem) {
                    $product = $cartItem->product;

                    RequestItem::query()->create([
                        'request_id' => $requestModel->id,

                        'product_id' => $product->id,

                        /*
                         * Snapshot product data.
                         */
                        'article' => $product->article,
                        'product_name' => $product->name,

                        'quantity' => (int) $cartItem->quantity,
                    ]);
                }

                /*
                 * Clear cart only after RequestItems
                 * have been successfully created.
                 */
                $cart->items()->delete();

                /*
                 * Save latest request in session.
                 */
                $request->session()->put(
                    'last_request_id',
                    $requestModel->id
                );

                return $requestModel;
            }
        );

        $this->queueRequestEmails($createdRequest);

        return response()->json([
            'message' => 'Request created successfully.',

            'request' => [
                'id' => $createdRequest->id,
                'number' => $createdRequest->number,
                'subject' => $createdRequest->subject,
                'status' => $createdRequest->status,
                'context' => $createdRequest->context,
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Create contact/service request.
     *
     * No RequestItems are created.
     */
    private function createContactRequest(
        Request $request,
        array $validated
    ): JsonResponse {
        $createdRequest = RequestModel::query()->create([
            'number' => $this->generateRequestNumber(),

            'session_id' => $request->session()->getId(),

            'subject' => $validated['subject'] ?? null,

            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'comment' => $validated['comment'] ?? null,

            'status' => 'pending',

            'context' => $validated['context'] ?? 'contact',
        ]);

        $this->queueRequestEmails($createdRequest);

        /*
         * Save latest request in session.
         */
        $request->session()->put(
            'last_request_id',
            $createdRequest->id
        );

        return response()->json([
            'message' => 'Request created successfully.',

            'request' => [
                'id' => $createdRequest->id,
                'number' => $createdRequest->number,
                'subject' => $createdRequest->subject,
                'status' => $createdRequest->status,
                'context' => $createdRequest->context,
            ],
        ], Response::HTTP_CREATED);
    }

    /**
     * Queue request notifications for the company and requester.
     */
    private function queueRequestEmails(
        RequestModel $requestModel
    ): void {
        $requestModel->loadMissing('items');

        $telegramToken = config('services.telegram.bot_token');
        $telegramChatIds = array_filter(array_map(
            'trim',
            explode(',', (string) config('services.telegram.chat_ids', ''))
        ));

        if ($telegramToken && $telegramChatIds) {
            foreach ($telegramChatIds as $chatId) {
                SendRequestTelegramNotification::dispatch(
                    $requestModel,
                    $chatId
                );
            }
        }

        $recipients = collect([
            config('mail.company_address'),
            ...explode(
                ',',
                (string) config('mail.manager_addresses', '')
            ),
        ])
            ->map(fn ($address) => trim((string) $address))
            ->filter(fn ($address) => $address !== '')
            ->filter(fn ($address) => filter_var($address, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();

        if ($recipients->isEmpty()) {
            Log::error('Company request email recipients are not configured.', [
                'request_id' => $requestModel->id,
            ]);
        }

        foreach ($recipients as $recipient) {
            try {
                $mail = new RequestSubmittedMail(
                    $requestModel,
                    true
                );

                if ($requestModel->email) {
                    $mail->replyTo(
                        $requestModel->email,
                        $requestModel->name
                    );
                }

                Mail::to($recipient)->queue($mail);
            } catch (Throwable $exception) {
                Log::error('Could not queue company request email.', [
                    'request_id' => $requestModel->id,
                    'recipient' => $recipient,
                    'exception' => $exception::class,
                ]);
            }
        }

        if (! filter_var($requestModel->email, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        try {
            Mail::to($requestModel->email)->queue(
                new RequestSubmittedMail(
                    $requestModel,
                    false
                )
            );
        } catch (Throwable $exception) {
            Log::error('Could not queue requester confirmation email.', [
                'request_id' => $requestModel->id,
                'exception' => $exception::class,
            ]);
        }
    }

    /**
     * Show request.
     *
     * Guest users can only access requests
     * created in their current session.
     */
    public function show(
        Request $request,
        RequestModel $requestModel
    ): JsonResponse {
        /*
         * Security check.
         */
        if (
            $requestModel->session_id
            !== $request->session()->getId()
        ) {
            return response()->json([
                'message' => 'Request not found.',
            ], Response::HTTP_NOT_FOUND);
        }

        $requestModel->load([
            'items.product',
        ]);

        return response()->json([
            'request' => [
                'id' => $requestModel->id,
                'number' => $requestModel->number,

                'subject' => $requestModel->subject,

                'name' => $requestModel->name,
                'phone' => $requestModel->phone,
                'email' => $requestModel->email,
                'comment' => $requestModel->comment,

                'status' => $requestModel->status,
                'context' => $requestModel->context,

                'created_at' => $requestModel->created_at,

                'items' => $requestModel->items
                    ->map(function (RequestItem $item) {
                        return [
                            'id' => $item->id,
                            'product_id' => $item->product_id,

                            'article' => $item->article,
                            'product_name' => $item->product_name,

                            'quantity' => (int) $item->quantity,
                        ];
                    })
                    ->values()
                    ->all(),
            ],
        ]);
    }

    /**
     * Generate human-readable request number.
     *
     * Example:
     *
     * REQ-20260828-A7K4M2
     */
    private function generateRequestNumber(): string
    {
        do {
            $number = sprintf(
                'REQ-%s-%s',
                now()->format('Ymd'),
                Str::upper(Str::random(6))
            );
        } while (
            RequestModel::query()
                ->where('number', $number)
                ->exists()
        );

        return $number;
    }
}

