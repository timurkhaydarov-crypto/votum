<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product\Product;
use App\Models\Product\ProductDocument;
use App\Models\Product\ProductDocumentFile;
use App\Services\Documentation\DocumentationKeyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentationPortalController extends Controller
{
    public function enter(
        string $key,
        Request $request,
        DocumentationKeyService $service
    ): JsonResponse {
        $user = $service->resolveUser($key);

        abort_unless(
            $user,
            404
        );

        $request->session()->regenerate();

        $request->session()->put([
            'documentation_user_id' =>
                $user->id,

            'documentation_key_hash' =>
                $user->documentation_key_hash,
        ]);

        return $this->products($request);
    }

    public function products(
        Request $request
    ): JsonResponse {
        /** @var \App\Models\User $user */
        $user = $request->attributes->get(
            'documentation_user'
        );

        if (! $user) {
            $user = User::findOrFail(
                $request->session()->get(
                    'documentation_user_id'
                )
            );
        }

        $products = $user->documentationProducts()
            ->wherePivot('is_active', true)
            ->where(function ($query) {
                $query
                    ->whereNull(
                        'documentation_accesses.starts_at'
                    )
                    ->orWhere(
                        'documentation_accesses.starts_at',
                        '<=',
                        now()
                    );
            })
            ->where(function ($query) {
                $query
                    ->whereNull(
                        'documentation_accesses.expires_at'
                    )
                    ->orWhere(
                        'documentation_accesses.expires_at',
                        '>=',
                        now()
                    );
            })
            ->withCount([
                'documents as documents_count' => function (
                    $query
                ) {
                    $query->where(
                        'is_active',
                        true
                    );
                },
            ])
            ->orderBy('article')
            ->get();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'products' => $products,
        ]);
    }

    public function documents(
        Request $request,
        Product $product
    ): JsonResponse {
        $user = $request->attributes->get(
            'documentation_user'
        );

        $access = $user->documentationAccesses()
            ->where('product_id', $product->id)
            ->where('is_active', true)
            ->first();

        abort_unless(
            $access?->isValid(),
            403
        );

        $access->update([
            'last_accessed_at' => now(),
        ]);

        $documents = $product->documents()
            ->where('is_active', true)
            ->with([
                'files:id,product_document_id,locale,original_name,file_size',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(function (
                ProductDocument $document
            ) use ($product) {
                return [
                    'id' => $document->id,
                    'type' => $document->type,
                    'title' => $document->title,
                    'description' =>
                        $document->description,
                    'sort_order' =>
                        $document->sort_order,
                    'files' => $document->files
                        ->map(
                            function (
                                ProductDocumentFile $file
                            ) use ($product, $document) {
                                return [
                                    'id' => $file->id,
                                    'locale' =>
                                        $file->locale,
                                    'original_name' =>
                                        $file->original_name,
                                    'file_size' =>
                                        $file->file_size,
                                    'url' => sprintf(
                                        '/documentation/products/%d/documents/%d/files/%d',
                                        $product->id,
                                        $document->id,
                                        $file->id
                                    ),
                                ];
                            }
                        )
                        ->values()
                        ->all(),
                ];
            })
            ->values()
            ->all();

        return response()->json([
            'product' => [
                'id' => $product->id,
                'article' => $product->article,
                'name' => $product->name,
            ],
            'documents' => $documents,
        ]);
    }

    public function file(
        Request $request,
        Product $product,
        ProductDocument $productDocument,
        ProductDocumentFile $productDocumentFile
    ) {
        $this->ensureDocumentBelongsToProduct(
            $product,
            $productDocument,
            $productDocumentFile
        );

        $user = $request->attributes->get(
            'documentation_user'
        );

        $access = $user->documentationAccesses()
            ->where('product_id', $product->id)
            ->where('is_active', true)
            ->first();

        abort_unless(
            $access?->isValid(),
            403
        );

        $access->update([
            'last_accessed_at' => now(),
        ]);

        abort_unless(
            Storage::disk('local')->exists(
                $productDocumentFile->file_path
            ),
            404
        );

        return response()->file(
            Storage::disk('local')->path(
                $productDocumentFile->file_path
            ),
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="'
                    .addslashes(
                        $productDocumentFile->original_name
                    )
                    .'"',
            ]
        );
    }

    private function ensureDocumentBelongsToProduct(
        Product $product,
        ProductDocument $document,
        ProductDocumentFile $file
    ): void {
        abort_unless(
            $document->product_id === $product->id,
            404
        );

        abort_unless(
            $file->product_document_id === $document->id,
            404
        );
    }
}