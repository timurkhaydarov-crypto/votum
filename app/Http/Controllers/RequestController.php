<?php

namespace App\Http\Controllers;

use App\Models\Cart\Cart;
use App\Models\Cart\CartItem;
use App\Models\Request\Request as RequestModel;
use App\Models\Request\RequestItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

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
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:50',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'comment' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'context' => [
                'nullable',
                'string',
                'in:cart,contact,service',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:255',
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

