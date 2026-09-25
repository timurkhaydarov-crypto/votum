<?php

namespace App\Http\Controllers;

use App\Models\Documentation\DocumentationAccess;
use App\Models\Product\Product;
use App\Models\User;
use App\Services\Documentation\DocumentationKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DocumentationAccessController extends Controller
{
    /**
     * Return all users with role "user".
     */
    public function users(): JsonResponse
    {
        $this->ensureCanManageDocumentation(
            request()->user()
        );

        $users = User::query()
            ->where('role', 'user')
            ->select([
                'id',
                'name',
                'email',
                'documentation_key_hash',
            ])
            ->withCount('documentationAccesses')
            ->orderBy('name')
            ->get()
            ->map(
                function (User $user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'has_documentation_key' => filled(
                            $user->documentation_key_hash
                        ),
                        'documentation_count' =>
                            $user->documentation_accesses_count,
                    ];
                }
            )
            ->values();

        return response()->json([
            'users' => $users,
        ]);
    }

    /**
     * Return documentation accesses for one user.
     */
    public function showAccesses(
        User $user
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            request()->user()
        );

        $this->ensureClientUser($user);

        $accesses = $user
            ->documentationAccesses()
            ->with([
                'product:id,article,name,image_url',
            ])
            ->orderBy('id')
            ->get()
            ->map(
                function (
                    DocumentationAccess $access
                ) {
                    return [
                        'id' => $access->id,
                        'product' => $access->product,
                        'starts_at' => $access->starts_at,
                        'expires_at' => $access->expires_at,
                        'is_active' => $access->is_active,
                        'is_valid' => $access->isValid(),
                        'last_accessed_at' =>
                            $access->last_accessed_at,
                    ];
                }
            )
            ->values();

        return response()->json([
            'user' => $this->serializeUser($user),
            'accesses' => $accesses,
        ]);
    }

    /**
     * Generate a new documentation key.
     *
     * The previous key becomes invalid immediately.
     */
    public function rotateKey(
        User $user,
        DocumentationKeyService $service
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            request()->user()
        );

        $this->ensureClientUser($user);

        $key = $service->rotate($user);

        return response()->json([
            'message' =>
                'Documentation key generated successfully.',

            'user' => $this->serializeUser($user),

            'key' => $key,
        ]);
    }

    /**
     * Revoke the user's documentation key.
     */
    public function revokeKey(
        User $user,
        DocumentationKeyService $service
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            request()->user()
        );

        $this->ensureClientUser($user);

        $service->revoke($user);

        return response()->json([
            'message' =>
                'Documentation key revoked successfully.',

            'user' => $this->serializeUser($user),
        ]);
    }

    /**
     * Grant or update access to one product.
     */
    public function grantProduct(
        Request $request,
        User $user,
        Product $product
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            $request->user()
        );

        $this->ensureClientUser($user);

        $validated = $request->validate([
            'starts_at' => [
                'nullable',
                'date',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],

            'is_active' => [
                'sometimes',
                'boolean',
            ],
        ]);

        $access = DocumentationAccess::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            [
                'starts_at' =>
                    $validated['starts_at'] ?? null,

                'expires_at' =>
                    $validated['expires_at'] ?? null,

                'is_active' =>
                    $validated['is_active'] ?? true,
            ]
        );

        return response()->json(
            $this->serializeAccess(
                $access->load([
                    'product:id,article,name,image_url',
                ])
            )
        );
    }

    /**
     * Revoke access to one product.
     */
    public function revokeProduct(
        Request $request,
        User $user,
        Product $product
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            $request->user()
        );

        $this->ensureClientUser($user);

        DocumentationAccess::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->delete();

        return response()->json([
            'message' =>
                'Documentation product access revoked.',
        ]);
    }

    /**
     * Validate a documentation key and return
     * the documents available for one product.
     *
     * This endpoint is public.
     * Authentication is not required.
     */
    public function access(
        Request $request,
        DocumentationKeyService $service
    ): JsonResponse {
        $validated = $request->validate([
            'key' => [
                'required',
                'string',
                'max:255',
            ],

            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
        ]);

        $user = $service->resolveUser(
            $validated['key']
        );

        if (! $user) {
            return response()->json([
                'message' =>
                    'Неверный ключ доступа.',
            ], 401);
        }

        $access = $user
            ->documentationAccesses()
            ->where(
                'product_id',
                $validated['product_id']
            )
            ->first();

        if (! $access || ! $access->isValid()) {
            return response()->json([
                'message' =>
                    'Ключ не предоставляет доступ к документации этого продукта.',
            ], 403);
        }

        $product = Product::query()
            ->whereKey($validated['product_id'])
            ->with([
                'documents' => function ($query) {
                    $query
                        ->where('is_active', true)
                        ->with([
                            'files:id,product_document_id,locale,original_name,file_size',
                        ])
                        ->orderBy('sort_order')
                        ->orderBy('id');
                },
            ])
            ->firstOrFail();

        $access->forceFill([
            'last_accessed_at' => now(),
        ])->save();

        return response()->json([
            'authorized' => true,

            'product' => [
                'id' => $product->id,
                'article' => $product->article,
                'name' => $product->name,
            ],

            'documents' => $product->documents,
        ]);
    }

    /**
     * Serialize user without exposing the key hash.
     */
    private function serializeUser(
        User $user
    ): array {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'has_documentation_key' => filled(
                $user->documentation_key_hash
            ),
        ];
    }

    /**
     * Serialize documentation access.
     */
    private function serializeAccess(
        DocumentationAccess $access
    ): array {
        return [
            'id' => $access->id,
            'product' => $access->product,
            'starts_at' => $access->starts_at,
            'expires_at' => $access->expires_at,
            'is_active' => $access->is_active,
            'is_valid' => $access->isValid(),
            'last_accessed_at' =>
                $access->last_accessed_at,
        ];
    }

    /**
     * Only admin and manager may manage documentation.
     */
    private function ensureCanManageDocumentation(
        ?User $user
    ): void {
        abort_unless(
            in_array(
                $user?->role,
                ['admin', 'manager'],
                true
            ),
            403
        );
    }

    /**
     * Documentation access can only belong to role "user".
     */
    private function ensureClientUser(
        User $user
    ): void {
        abort_unless(
            $user->role === 'user',
            404
        );
    }
}