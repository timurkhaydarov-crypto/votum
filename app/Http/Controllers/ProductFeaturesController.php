<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductFeaturesRequest;
use App\Http\Requests\UpdateProductFeaturesRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductFeatures;
use Illuminate\Http\JsonResponse;

class ProductFeaturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductFeaturesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
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
    public function edit(ProductFeatures $productFeatures)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductFeaturesRequest $request, ProductFeatures $productFeatures)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductFeatures $productFeatures)
    {
        //
    }
}
