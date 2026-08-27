<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductSpecificationRequest;
use App\Http\Requests\UpdateProductSpecificationRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductSpecification;
use Illuminate\Http\JsonResponse;

class ProductSpecificationController extends Controller
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
    public function store(StoreProductSpecificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        $specifications = $product->specifications()
            ->get(['id', 'name', 'value']);

        return response()->json([
            'specifications' => $specifications,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductSpecification $productSpecification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductSpecificationRequest $request, ProductSpecification $productSpecification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSpecification $productSpecification)
    {
        //
    }
}
