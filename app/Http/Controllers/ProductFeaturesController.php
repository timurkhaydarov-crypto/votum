<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductFeaturesRequest;
use App\Http\Requests\Product\UpdateProductFeaturesRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductFeatures;
use Illuminate\Http\JsonResponse;

class ProductFeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $features = ProductFeatures::with('gallery')
            ->get();

        return response()->json([
            'features' => $features,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'message' => 'Create product features.',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreProductFeaturesRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $features = $product->features()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'features' => $validated['features'],
            ]
        );

        $features->load('gallery');

        return response()->json([
            'features' => $features->features,
            'gallery' => $features->gallery,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Product $product
    ): JsonResponse {
        $features = $product->features()
            ->with('gallery')
            ->first();

        return response()->json([
            'features' => $features?->features,
            'gallery' => $features?->gallery,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        ProductFeatures $productFeatures
    ): JsonResponse {
        $productFeatures->load('gallery');

        return response()->json([
            'id' => $productFeatures->id,
            'product_id' => $productFeatures->product_id,
            'features' => $productFeatures->features,
            'gallery' => $productFeatures->gallery,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProductFeaturesRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $features = $product->features()->updateOrCreate(
            [
                'product_id' => $product->id,
            ],
            [
                'features' => $validated['features'],
            ]
        );

        $features->load('gallery');

        return response()->json([
            'features' => $features->features,
            'gallery' => $features->gallery,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Product $product
    ): JsonResponse {
        $product->features()->delete();

        return response()->json([
            'message' => 'Product features deleted successfully.',
        ]);
    }
}