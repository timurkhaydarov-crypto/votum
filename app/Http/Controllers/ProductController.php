<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Product;
use App\Services\ProductMenuService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['brand', 'category', 'group', 'groups'])->get();

        return response()->json(
            $products->map(function (Product $product) {
                return [
                    'id' => $product->id,
                    'article' => $product->article,
                    'name' => $product->name,
                    'short_description' => $product->short_description,
                    'full_description' => $product->full_description,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'slug' => $product->category->slug,
                        'title' => $product->category->category,
                    ] : null,
                    'group' => $product->group ? [
                        'id' => $product->group->id,
                        'slug' => $product->group->slug,
                        'title' => $product->group->group,
                    ] : null,
                    'groups' => $product->groups->map(fn ($group) => [
                        'id' => $group->id,
                        'slug' => $group->slug,
                        'title' => $group->group,
                    ])->values()->all(),
                    'brand' => $product->brand ? [
                        'id' => $product->brand->id,
                        'title' => $product->brand->brand,
                    ] : null,
                    'image_url' => $product->image_url,
                    'video_url' => $product->video_url,
                    'price' => $product->price,
                    'quantity' => $product->quantity,
                    'status' => $product->status,
                ];
            })->values()->all()
        );
    }

    public function menu(ProductMenuService $menuService, Request $request)
    {
        $locale = $request->query('lang', 'ru');

        return response()->json($menuService->buildMenu($locale));
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
    public function store(StoreProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
