<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product\Category;
use App\Models\Product\Group;
use App\Models\Product\Product;
use App\Services\ProductMenuService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected function formatMethod(?object $method): ?string
    {
        if (! $method) {
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

        return empty($active)
            ? null
            : implode(', ', $active);
    }

    protected function formatApplication(?object $sector): ?string
    {
        if (! $sector) {
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

        return empty($active)
            ? null
            : implode(', ', $active);
    }

    protected function serializeProduct(
        Product $product,
        bool $withCompatibleProducts = false
    ): array {
        $data = [
            'id' => $product->id,

            'article' => $product->article,

            'name' => $product->name,

            'short_description' => $product->short_description,

            'full_description' => $product->full_description,

            'has_features' => $product->features()->exists(),
            'has_specifications' => $product->specifications()->exists(),

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            'category' => $product->category ? [
                'id' => $product->category->id,
                'slug' => $product->category->slug,
                'title' => $product->category->category,
            ] : null,

            /*
            |--------------------------------------------------------------------------
            | Main group
            |--------------------------------------------------------------------------
            */

            'group' => $product->group ? [
                'id' => $product->group->id,
                'slug' => $product->group->slug,
                'title' => $product->group->group,
            ] : null,

            /*
            |--------------------------------------------------------------------------
            | Additional groups
            |--------------------------------------------------------------------------
            */

            'groups' => $product->groups
                ->map(fn ($group) => [
                    'id' => $group->id,
                    'slug' => $group->slug,
                    'title' => $group->group,
                ])
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Certificates
            |--------------------------------------------------------------------------
            */

            'certificates' => $product->certificates
                ->map(fn ($certificate) => [
                    'id' => $certificate->id,

                    'thumbnail' => '/image/certificates/thumbnails/'
                        .$certificate->image_url
                        .'.webp',

                    'src' => '/image/certificates/'
                        .$certificate->image_url
                        .'.webp',

                    'alt' => $certificate->image_url,

                    'title' => $certificate->title,

                    'description' => $certificate->description,
                ])
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            'gallery' => $product->gallery
                ->map(fn ($gallery) => [
                    'id' => $gallery->id,

                    'thumbnail' => '/image/gallery/'
                        .$product->image_url
                        .'/thumbnails/'
                        .$gallery->image_url
                        .'.webp',

                    'image_url' => '/image/gallery/'
                        .$product->image_url
                        .'/'
                        .$gallery->image_url
                        .'.webp',

                    'title' => $gallery->title,

                    'description' => $gallery->description,
                ])
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Brand
            |--------------------------------------------------------------------------
            */

            'brand' => $product->brand ? [
                'id' => $product->brand->id,
                'title' => $product->brand->brand,
            ] : null,

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */

            'image_url' => $product->image_url,

            'video_url' => $product->video_url,

            /*
            |--------------------------------------------------------------------------
            | PDF
            |--------------------------------------------------------------------------
            */

            'pdf_url' => [
                'en' => file_exists(
                    public_path(
                        'document/specification/en/'
                        .$product->image_url
                        .'.pdf'
                    )
                ),

                'ru' => file_exists(
                    public_path(
                        'document/specification/ru/'
                        .$product->image_url
                        .'.pdf'
                    )
                ),
            ],

            /*
            |--------------------------------------------------------------------------
            | Product data
            |--------------------------------------------------------------------------
            */

            'price' => $product->price,

            'quantity' => $product->quantity,

            'status' => $product->status,

            /*
            |--------------------------------------------------------------------------
            | Method
            |--------------------------------------------------------------------------
            */

            'method' => $this->formatMethod(
                $product->method
            ),

            /*
            |--------------------------------------------------------------------------
            | Note data
            |--------------------------------------------------------------------------
            */

            'frequency' => data_get(
                $product->note,
                'frequency'
            ),

            'display' => data_get(
                $product->note,
                'display'
            ),

            /*
            |--------------------------------------------------------------------------
            | Application
            |--------------------------------------------------------------------------
            */

            'application' => $this->formatApplication(
                $product->sector
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | Compatible products
        |--------------------------------------------------------------------------
        |
        | Добавляем совместимые товары только
        | на странице конкретного товара.
        |
        | compatibleProducts:
        | текущий товар -> совместимые товары
        |
        | compatibleWithProducts:
        | другие товары -> текущий товар
        |
        | Объединяем обе стороны.
        |
        */

        if ($withCompatibleProducts) {
            $compatibleProducts = $product
                ->compatibleProducts
                ->merge(
                    $product->compatibleWithProducts
                )
                ->unique('id')
                ->values();

            /*
            |--------------------------------------------------------------------------
            | Categories from database
            |--------------------------------------------------------------------------
            |
            | Раньше здесь был захардкоженный список:
            |
            | industrial-ndt
            | flaw-detectors
            | scanning-devices
            | transducers
            | reference-standards
            |
            | Теперь список категорий берётся из БД.
            |
            */

            $allowedCategories = Category::query()
                ->pluck('slug')
                ->filter()
                ->values()
                ->all();

            /*
            |--------------------------------------------------------------------------
            | Group compatible products by category
            |--------------------------------------------------------------------------
            */

            $compatibleProductsByCategory = $compatibleProducts
                ->filter(
                    fn (Product $compatibleProduct) => $compatibleProduct->category !== null
                        && in_array(
                            $compatibleProduct->category->slug,
                            $allowedCategories,
                            true
                        )
                )
                ->groupBy(
                    fn (Product $compatibleProduct) => $compatibleProduct->category->slug
                )
                ->map(
                    fn ($products) => $products
                        ->map(
                            fn (Product $compatibleProduct) => [
                                'id' => $compatibleProduct->id,

                                'article' => $compatibleProduct->article,

                                'name' => $compatibleProduct->name,

                                'shortDescription' => $compatibleProduct->short_description,

                                'fullDescription' => $compatibleProduct->full_description,

                                'imageUrl' => $compatibleProduct->image_url,

                                'videoUrl' => $compatibleProduct->video_url,

                                'price' => $compatibleProduct->price,

                                'quantity' => $compatibleProduct->quantity,

                                'status' => $compatibleProduct->status,

                                'method' => $this->formatMethod(
                                    $compatibleProduct->method
                                ),

                                'application' => $this->formatApplication(
                                    $compatibleProduct->sector
                                ),

                                'categoryId' => $compatibleProduct->category->id,

                                'categorySlug' => $compatibleProduct->category->slug,

                                'categoryTitle' => $compatibleProduct->category->category,

                                'groupId' => $compatibleProduct->group?->id,

                                'groupSlug' => $compatibleProduct->group?->slug,

                                'groupTitle' => $compatibleProduct->group?->group,
                            ]
                        )
                        ->values()
                        ->all()
                )
                ->all();

            $data['compatible_products'] =
                $compatibleProductsByCategory;
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with([
            'brand',
            'category',
            'group',
            'groups',
            'certificates',
            'gallery',
            'method',
            'sector',
            'features',
        ])->get();

        return response()->json(
            $products
                ->map(
                    fn (Product $product) => $this->serializeProduct($product)
                )
                ->values()
                ->all()
        );
    }

    /**
     * Product menu.
     */
    public function menu(
        ProductMenuService $menuService,
        Request $request
    ) {
        $locale = $request->query(
            'lang',
            'ru'
        );

        return response()->json(
            $menuService->buildMenu($locale)
        );
    }

    /**
     * Display products by group.
     */
    public function productsByGroup(
        Category $category,
        Group $group
    ) {
        $products = Product::with([
            'brand',
            'category',
            'group',
            'groups',
            'method',
            'sector',
            'features',
        ])
            ->where(
                'category_id',
                $category->id
            )
            ->where(
                function ($query) use ($group) {
                    $query
                        ->where(
                            'group_id',
                            $group->id
                        )
                        ->orWhereHas(
                            'groups',
                            fn ($q) => $q->where(
                                'groups.id',
                                $group->id
                            )
                        );
                }
            )
            ->get();

        return response()->json(
            $products
                ->map(
                    fn (Product $product) => $this->serializeProduct($product)
                )
                ->values()
                ->all()
        );
    }

    /**
     * Display products by category.
     */
    public function productsByCategory(
        Category $category
    ) {
        $products = Product::with([
            'brand',
            'category',
            'group',
            'groups',
            'method',
            'sector',
            'features',
        ])
            ->where(
                'category_id',
                $category->id
            )
            ->get();

        return response()->json(
            $products
                ->map(
                    fn (Product $product) => $this->serializeProduct($product)
                )
                ->values()
                ->all()
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
    public function store(
        StoreProductRequest $request
    ) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'brand',
            'category',
            'group',
            'groups',
            'certificates',
            'gallery',
            'method',
            'sector',
            'features',

            /*
            |--------------------------------------------------------------------------
            | Compatible products
            |--------------------------------------------------------------------------
            */

            'compatibleProducts.category',
            'compatibleWithProducts.category',
        ]);

        return response()->json(
            $this->serializeProduct(
                $product,
                true
            )
        );
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
    public function update(
        UpdateProductRequest $request,
        Product $product
    ) {
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
