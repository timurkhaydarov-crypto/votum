<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Product;
use App\Models\Product\Group;
use App\Models\Product\Category;
use App\Services\ProductMenuService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected function formatMethod(?object $method): ?string
    {
        if (!$method) {
            return null;
        }

        $map = [
            'ut_method' => 'UT',
            'et_method' => 'ET',
            'mia_method' => 'MIA',
            'iet_method' => 'IET',
            'mt_method' => 'MT',
            'vt_method' => 'VT',
        ];

        $active = [];
        foreach ($map as $field => $label) {
            if ((bool) data_get($method, $field, false)) {
                $active[] = $label;
            }
        }

        return empty($active) ? null : implode(', ', $active);
    }

    protected function formatApplication(?object $sector): ?string
    {
        if (!$sector) {
            return null;
        }

        $map = [
            'railway' => 'Railway',
            'aerospace' => 'Aerospace',
            'oil' => 'Oil & Gas',
        ];

        $active = [];
        foreach ($map as $field => $label) {
            if ((bool) data_get($sector, $field, false)) {
                $active[] = $label;
            }
        }

        return empty($active) ? null : implode(', ', $active);
    }

    protected function serializeProduct(Product $product): array
    {
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
            'certificates' => $product->certificates->map(fn ($certificate) => [
                'id' => $certificate->id,
                'thumbnail' => '/image/certificates/thumbnails/' . $certificate->image_url . '.webp',
                'src' => '/image/certificates/' . $certificate->image_url . '.webp',
                'alt' => $certificate->image_url,
                'title' => $certificate->title,
                'description' => $certificate->description,
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
            'method' => $this->formatMethod($product->method),
            'frequency' => data_get($product->note, 'frequency'),
            'display' => data_get($product->note, 'display'),
            'application' => $this->formatApplication($product->sector),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with(['brand', 'category', 'group', 'groups', 'certificates', 'method', 'sector'])->get();

        return response()->json(
            $products->map(fn (Product $product) => $this->serializeProduct($product))->values()->all()
        );
    }

    public function menu(ProductMenuService $menuService, Request $request)
    {
        $locale = $request->query('lang', 'ru');

        return response()->json($menuService->buildMenu($locale));
    }
    
    public function productsByGroup(Category $category, Group $group)
    {
        $products = Product::with(['brand', 'category', 'group', 'groups', 'method', 'sector'])
            ->where('category_id', $category->id)
            ->where(function ($query) use ($group) {
                $query
                    ->where('group_id', $group->id)
                    ->orWhereHas('groups', fn ($q) => $q->where('groups.id', $group->id));
            })
            ->get();

        return response()->json(
            $products->map(fn (Product $product) => $this->serializeProduct($product))->values()->all()
        );
    }

    public function productsByCategory(Category $category)
    {
        $products = Product::with(['brand', 'category', 'group', 'groups', 'method', 'sector'])
            ->where('category_id', $category->id)
            ->get();

        return response()->json(
            $products->map(fn (Product $product) => $this->serializeProduct($product))->values()->all()
        );
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
        $product->load(['brand', 'category', 'group', 'groups', 'certificates', 'method', 'sector']);
        
        return response()->json($this->serializeProduct($product));
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
