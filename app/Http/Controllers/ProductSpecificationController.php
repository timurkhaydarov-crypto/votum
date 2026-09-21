<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductSpecificationRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Http\JsonResponse;

class ProductSpecificationController extends Controller
{
    /**
     * Display all specifications for the product.
     */
    public function index(Product $product): JsonResponse
    {
        $specifications = $product->specifications()
            ->get([
                'id',
                'name',
                'value',
            ]);

        return response()->json([
            'specifications' => $specifications,
        ]);
    }

    /**
     * Store a newly created specification.
     */
    public function store(
        ProductSpecificationRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $specification = $product->specifications()->create([
            'name' => [
                'ru' => $validated['name']['ru'],
                'en' => $validated['name']['en'],
            ],

            'value' => [
                'ru' => $validated['value']['ru'],
                'en' => $validated['value']['en'],
            ],
        ]);

        return response()->json([
            'specification' => $specification,
        ], 201);
    }

    /**
     * Display the specified specification.
     */
    public function show(
        Product $product,
        ProductSpecification $productSpecification
    ): JsonResponse {
        $this->ensureBelongsToProduct(
            $product,
            $productSpecification
        );

        return response()->json([
            'specification' => $productSpecification,
        ]);
    }

    /**
     * Update the specified specification.
     */
    public function update(
        ProductSpecificationRequest $request,
        Product $product,
        ProductSpecification $productSpecification
    ): JsonResponse {
        $this->ensureBelongsToProduct(
            $product,
            $productSpecification
        );

        $validated = $request->validated();

        $productSpecification->update([
            'name' => [
                'ru' => $validated['name']['ru'],
                'en' => $validated['name']['en'],
            ],

            'value' => [
                'ru' => $validated['value']['ru'],
                'en' => $validated['value']['en'],
            ],
        ]);

        return response()->json([
            'specification' => $productSpecification->fresh(),
        ]);
    }

    /**
     * Remove the specified specification.
     */
    public function destroy(
        Product $product,
        ProductSpecification $productSpecification
    ): JsonResponse {
        $this->ensureBelongsToProduct(
            $product,
            $productSpecification
        );

        $productSpecification->delete();

        return response()->json([
            'message' =>
                'Product specification deleted successfully.',
        ]);
    }

    /**
     * Ensure that the specification belongs to the given product.
     */
    private function ensureBelongsToProduct(
        Product $product,
        ProductSpecification $productSpecification
    ): void {
        abort_unless(
            $productSpecification->product_id === $product->id,
            404
        );
    }
}