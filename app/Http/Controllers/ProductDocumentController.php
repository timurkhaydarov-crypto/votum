<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentation\StoreProductDocumentRequest;
use App\Http\Requests\Documentation\UpdateProductDocumentRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductDocument;
use App\Services\Documentation\ProductDocumentFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductDocumentController extends Controller
{
    /**
     * Return product documents for manager.
     */
    public function index(
        Request $request,
        Product $product
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            $request->user()
        );

        $documents = $product
            ->documents()
            ->with([
                'files:id,product_document_id,locale,original_name,file_size',
            ])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return response()->json([
            'product' => [
                'id' => $product->id,
                'article' => $product->article,
                'name' => $product->name,
            ],

            'documents' => $documents,
        ]);
    }

    /**
     * Create a product document.
     */
    public function store(
        StoreProductDocumentRequest $request,
        Product $product
    ): JsonResponse {
        $document = $product
            ->documents()
            ->create(
                $request->validated()
            );

        $document->load('files');

        return response()->json(
            $document,
            201
        );
    }

    /**
     * Show one product document.
     */
    public function show(
        Request $request,
        Product $product,
        ProductDocument $productDocument
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            $request->user()
        );

        $this->ensureBelongsToProduct(
            $product,
            $productDocument
        );

        return response()->json(
            $productDocument->load('files')
        );
    }

    /**
     * Update product document.
     */
    public function update(
        UpdateProductDocumentRequest $request,
        Product $product,
        ProductDocument $productDocument
    ): JsonResponse {
        $this->ensureBelongsToProduct(
            $product,
            $productDocument
        );

        $productDocument->update(
            $request->validated()
        );

        return response()->json(
            $productDocument->load('files')
        );
    }

    /**
     * Delete product document and its PDF files.
     */
    public function destroy(
        Request $request,
        Product $product,
        ProductDocument $productDocument,
        ProductDocumentFileService $service
    ): JsonResponse {
        $this->ensureCanManageDocumentation(
            $request->user()
        );

        $this->ensureBelongsToProduct(
            $product,
            $productDocument
        );

        $service->deleteDocument(
            $productDocument
        );

        return response()->json([
            'message' =>
                'Product document deleted successfully.',
        ]);
    }

    private function ensureBelongsToProduct(
        Product $product,
        ProductDocument $document
    ): void {
        abort_unless(
            $document->product_id === $product->id,
            404
        );
    }

    private function ensureCanManageDocumentation(
        ?\App\Models\User $user
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
}