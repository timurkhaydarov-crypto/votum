<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductCompatibleRequest;
use App\Http\Requests\Product\UpdateProductDetailsRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product\Category;
use App\Models\Product\Certificate;
use App\Models\Product\Group;
use App\Models\Product\Product;
use App\Services\Documentation\ProductDocumentFileService;
use App\Services\ProductMediaService;
use App\Services\ProductMenuService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    protected function formatMethod(
        ?object $method
    ): ?string {
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
            if (
                (bool) data_get(
                    $method,
                    $field,
                    false
                )
            ) {
                $active[] = $label;
            }
        }

        return empty($active)
            ? null
            : implode(', ', $active);
    }

    protected function formatApplication(
        ?object $sector
    ): ?string {
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
            if (
                (bool) data_get(
                    $sector,
                    $field,
                    false
                )
            ) {
                $active[] = $label;
            }
        }

        return empty($active)
            ? null
            : implode(', ', $active);
    }

    /**
     * Synchronize product compatibility.
     *
     * Compatibility is logically bidirectional.
     */
    protected function syncCompatibleProducts(
        Product $product,
        array $compatibleProductIds
    ): void {
        $ids = collect($compatibleProductIds)
            ->map(fn ($id) => (int) $id)
            ->filter(
                fn ($id) => $id !== (int) $product->id
            )
            ->unique()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Remove existing relations in both directions.
        |--------------------------------------------------------------------------
        */

        $product
            ->compatibleProducts()
            ->detach();

        $product
            ->compatibleWithProducts()
            ->detach();

        /*
        |--------------------------------------------------------------------------
        | Create the selected relations.
        |--------------------------------------------------------------------------
        */

        if ($ids->isNotEmpty()) {
            $product
                ->compatibleProducts()
                ->attach($ids->all());
        }
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

            'has_features' => $product
                ->features()
                ->exists(),

            'has_specifications' => $product
                ->specifications()
                ->exists(),

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            'category' => $product->category
                ? [
                    'id' => $product->category->id,

                    'slug' => $product->category->slug,

                    'title' => $product->category->category,
                ]
                : null,

            /*
            |--------------------------------------------------------------------------
            | Main group
            |--------------------------------------------------------------------------
            */

            'group' => $product->group
                ? [
                    'id' => $product->group->id,

                    'slug' => $product->group->slug,

                    'title' => $product->group->group,
                ]
                : null,

            /*
            |--------------------------------------------------------------------------
            | Additional groups
            |--------------------------------------------------------------------------
            */

            'groups' => $product
                ->groups
                ->map(
                    fn ($group) => [
                        'id' => $group->id,

                        'slug' => $group->slug,

                        'title' => $group->group,
                    ]
                )
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Certificates
            |--------------------------------------------------------------------------
            */

            'certificates' => $product
                ->certificates
                ->map(
                    fn ($certificate) => [
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
                    ]
                )
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Gallery
            |--------------------------------------------------------------------------
            */

            'gallery' => $product
                ->gallery
                ->map(
                    fn ($gallery) => [
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
                    ]
                )
                ->values()
                ->all(),

            /*
            |--------------------------------------------------------------------------
            | Brand
            |--------------------------------------------------------------------------
            */

            'brand' => $product->brand
                ? [
                    'id' => $product->brand->id,

                    'title' => $product->brand->brand,
                ]
                : null,

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
            | Note
            |--------------------------------------------------------------------------
            */

            'note' => $product->note,

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
        */

        if ($withCompatibleProducts) {
            $compatibleProducts =
                $product
                    ->compatibleProducts
                    ->merge(
                        $product
                            ->compatibleWithProducts
                    )
                    ->unique('id')
                    ->values();

            $allowedCategories =
                Category::query()
                    ->pluck('slug')
                    ->filter()
                    ->values()
                    ->all();

            $compatibleProductsByCategory =
                $compatibleProducts
                    ->filter(
                        fn (
                            Product $compatibleProduct
                        ) => $compatibleProduct
                            ->category !== null
                            && in_array(
                                $compatibleProduct
                                    ->category
                                    ->slug,
                                $allowedCategories,
                                true
                            )
                    )
                    ->groupBy(
                        fn (
                            Product $compatibleProduct
                        ) => $compatibleProduct
                            ->category
                            ->slug
                    )
                    ->map(
                        fn ($products) => $products
                            ->map(
                                fn (
                                    Product $compatibleProduct
                                ) => [
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

                                    'categoryId' => $compatibleProduct
                                        ->category
                                        ->id,

                                    'categorySlug' => $compatibleProduct
                                        ->category
                                        ->slug,

                                    'categoryTitle' => $compatibleProduct
                                        ->category
                                        ->category,

                                    'groupId' => $compatibleProduct
                                        ->group
                                        ?->id,

                                    'groupSlug' => $compatibleProduct
                                        ->group
                                        ?->slug,

                                    'groupTitle' => $compatibleProduct
                                        ->group
                                        ?->group,
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
     * Display a listing of products.
     */
    public function index(): JsonResponse
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
                    fn (Product $product) => $this->serializeProduct(
                        $product
                    )
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
    ): JsonResponse {
        $locale = $request->query(
            'lang',
            'ru'
        );

        return response()->json(
            $menuService->buildMenu(
                $locale
            )
        );
    }

    /**
     * Display products by group.
     *
     * The category and group are independent entities.
     * The group filter is applied only within
     * the selected category.
     */
    public function productsByGroup(
        Category $category,
        Group $group
    ): JsonResponse {
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
                    fn (Product $product) => $this->serializeProduct(
                        $product
                    )
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
    ): JsonResponse {
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
                    fn (Product $product) => $this->serializeProduct(
                        $product
                    )
                )
                ->values()
                ->all()
        );
    }

    /**
     * Return data required for creating a product.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'options' => $this->productFormOptions(),
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(
        StoreProductRequest $request,
        ProductMediaService $mediaService
    ): JsonResponse {
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Category / Group
        |--------------------------------------------------------------------------
        */

        $category = Category::findOrFail(
            $validated['category_id']
        );

        $group = Group::findOrFail(
            $validated['group_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Product image
        |--------------------------------------------------------------------------
        */

        $imageUrl =
            $validated['image_url']
            ?? null;

        if (
            ! empty(
                $validated['image_upload_token']
                ?? null
            )
        ) {
            $imageUrl =
                $mediaService->promoteProductImage(
                    $validated['image_upload_token'],
                    $category->slug
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Product video
        |--------------------------------------------------------------------------
        */

        $videoUrl =
            $validated['video_url']
            ?? null;

        if (
            ! empty(
                $validated['video_upload_token']
                ?? null
            )
        ) {
            $videoUrl =
                $mediaService->promoteVideo(
                    $validated['video_upload_token'],
                    $category->slug
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Create product
        |--------------------------------------------------------------------------
        */

        $product = DB::transaction(
            function () use (
                $validated,
                $imageUrl,
                $videoUrl
            ) {
                $product = Product::create([
                    'article' => $validated['article'],

                    'name' => $validated['name'],

                    'short_description' => $validated['short_description'],

                    'full_description' => $validated['full_description'],

                    'category_id' => $validated['category_id'],

                    'group_id' => $validated['group_id'],

                    'brand_id' => $validated['brand_id'],

                    'unit' => $validated['unit'],

                    'price' => $validated['price'],

                    'quantity' => $validated['quantity'],

                    'status' => $validated['status'],

                    'image_url' => $imageUrl,

                    'video_url' => $videoUrl,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Product / Group
                |--------------------------------------------------------------------------
                |
                | The main product group is also stored
                | in the product_group pivot table.
                |
                */

                $product->groups()->sync([
                    $validated['group_id'],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Method
                |--------------------------------------------------------------------------
                */

                $method =
                    $validated['method']
                    ?? [];

                $product
                    ->method()
                    ->updateOrCreate(
                        [
                            'product_id' => $product->id,
                        ],
                        [
                            'ut_method' => (bool) (
                                $method['ut_method']
                                ?? false
                            ),

                            'et_method' => (bool) (
                                $method['et_method']
                                ?? false
                            ),

                            'mia_method' => (bool) (
                                $method['mia_method']
                                ?? false
                            ),

                            'iet_method' => (bool) (
                                $method['iet_method']
                                ?? false
                            ),

                            'mt_method' => (bool) (
                                $method['mt_method']
                                ?? false
                            ),

                            'vt_method' => (bool) (
                                $method['vt_method']
                                ?? false
                            ),
                        ]
                    );

                /*
                |--------------------------------------------------------------------------
                | Application sectors
                |--------------------------------------------------------------------------
                */

                $sector =
                    $validated['sector']
                    ?? [];

                $product
                    ->sector()
                    ->updateOrCreate(
                        [
                            'product_id' => $product->id,
                        ],
                        [
                            'railway' => (bool) (
                                $sector['railway']
                                ?? false
                            ),

                            'aerospace' => (bool) (
                                $sector['aerospace']
                                ?? false
                            ),

                            'oil' => (bool) (
                                $sector['oil']
                                ?? false
                            ),
                        ]
                    );

                return $product;
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Load product relations
        |--------------------------------------------------------------------------
        */

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
            'compatibleProducts.category',
            'compatibleWithProducts.category',
        ]);

        return response()->json(
            $this->serializeProduct(
                $product,
                true
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Product $product
    ): JsonResponse {
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
     * Return data required for the primary product form.
     */
    protected function productFormOptions(): array
    {
        return [
            'categories' => Category::query()
                ->orderBy('id')
                ->get([
                    'id',
                    'category',
                    'slug',
                ]),

            'groups' => Group::query()
                ->orderBy('id')
                ->get([
                    'id',
                    'group',
                    'slug',
                ]),
        ];
    }

    /**
     * Show the form for editing the specified product.
     *
     * Returns primary product data together with
     * certificates and compatible product options.
     */
    public function edit(
        Product $product
    ): JsonResponse {
        $product->load([
            'method',
            'sector',
            'certificates',
            'compatibleProducts',
            'compatibleWithProducts',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Current certificate IDs
        |--------------------------------------------------------------------------
        |
        | Only relation IDs are returned.
        |
        | Removing a certificate from this list must only remove
        | the corresponding row from product_certificates.
        |
        | The Certificate model and its physical file are shared
        | resources and must never be deleted here.
        |
        */

        $certificateIds = $product
            ->certificates
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Current compatible product IDs
        |--------------------------------------------------------------------------
        |
        | Compatibility can exist in either direction:
        |
        | product_id -> compatible_product_id
        |
        | or
        |
        | compatible_product_id -> product_id
        |
        | Merge both directions for the editor.
        |
        */

        $compatibleProductIds = $product
            ->compatibleProducts
            ->pluck('id')
            ->merge(
                $product
                    ->compatibleWithProducts
                    ->pluck('id')
            )
            ->map(fn ($id) => (int) $id)
            ->filter(
                fn ($id) => $id !== (int) $product->id
            )
            ->unique()
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Certificate options
        |--------------------------------------------------------------------------
        */

        $certificates = Certificate::query()
            ->orderBy('id')
            ->get([
                'id',
                'title',
                'description',
                'image_url',
            ])
            ->map(
                fn ($certificate) => [
                    'id' => $certificate->id,

                    'title' => $certificate->title,

                    'description' => $certificate->description,

                    'image_url' => $certificate->image_url,
                ]
            )
            ->values()
            ->all();

        /*
        |--------------------------------------------------------------------------
        | Compatible product options
        |--------------------------------------------------------------------------
        |
        | The current product itself is excluded.
        |
        */

        $products = Product::query()
            ->where(
                'id',
                '!=',
                $product->id
            )
            ->with([
                'category',
                'group',
            ])
            ->orderBy('id')
            ->get([
                'id',
                'article',
                'name',
                'category_id',
                'group_id',
                'image_url',
            ])
            ->map(
                fn (Product $compatibleProduct) => [
                    'id' => $compatibleProduct->id,

                    'article' => $compatibleProduct->article,

                    'name' => $compatibleProduct->name,

                    'category_id' => $compatibleProduct->category_id,

                    'category' => $compatibleProduct->category
                        ? [
                            'id' => $compatibleProduct->category->id,

                            'slug' => $compatibleProduct->category->slug,

                            'title' => $compatibleProduct->category->category,
                        ]
                        : null,

                    'group_id' => $compatibleProduct->group_id,

                    'group' => $compatibleProduct->group
                        ? [
                            'id' => $compatibleProduct->group->id,

                            'slug' => $compatibleProduct->group->slug,

                            'title' => $compatibleProduct->group->group,
                        ]
                        : null,

                    'image_url' => $compatibleProduct->image_url,
                ]
            )
            ->values()
            ->all();

        return response()->json([
            'product' => [
                'id' => $product->id,

                'article' => $product->article,

                'name' => $product->name,

                'short_description' => $product->short_description,

                'full_description' => $product->full_description,

                'category_id' => $product->category_id,

                'group_id' => $product->group_id,

                'image_url' => $product->image_url,

                'video_url' => $product->video_url,

                /*
                |--------------------------------------------------------------------------
                | Certificates
                |--------------------------------------------------------------------------
                */

                'certificate_ids' => $certificateIds,

                /*
                |--------------------------------------------------------------------------
                | Compatible products
                |--------------------------------------------------------------------------
                */

                'compatible_product_ids' => $compatibleProductIds,

                /*
                |--------------------------------------------------------------------------
                | Method
                |--------------------------------------------------------------------------
                */

                'method' => [
                    'ut_method' => (bool) (
                        $product->method?->ut_method
                        ?? false
                    ),

                    'et_method' => (bool) (
                        $product->method?->et_method
                        ?? false
                    ),

                    'mia_method' => (bool) (
                        $product->method?->mia_method
                        ?? false
                    ),

                    'iet_method' => (bool) (
                        $product->method?->iet_method
                        ?? false
                    ),

                    'mt_method' => (bool) (
                        $product->method?->mt_method
                        ?? false
                    ),

                    'vt_method' => (bool) (
                        $product->method?->vt_method
                        ?? false
                    ),
                ],

                /*
                |--------------------------------------------------------------------------
                | Application sectors
                |--------------------------------------------------------------------------
                */

                'sector' => [
                    'railway' => (bool) (
                        $product->sector?->railway
                        ?? false
                    ),

                    'aerospace' => (bool) (
                        $product->sector?->aerospace
                        ?? false
                    ),

                    'oil' => (bool) (
                        $product->sector?->oil
                        ?? false
                    ),
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | Options
            |--------------------------------------------------------------------------
            */

            'options' => [
                'categories' => Category::query()
                    ->orderBy('id')
                    ->get([
                        'id',
                        'category',
                        'slug',
                    ]),

                'groups' => Group::query()
                    ->orderBy('id')
                    ->get([
                        'id',
                        'group',
                        'slug',
                    ]),

                'certificates' => $certificates,

                'products' => $products,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProductRequest $request,
        Product $product,
        ProductMediaService $mediaService
    ): JsonResponse {
        $validated =
            $request->validated();

        /*
        |--------------------------------------------------------------------------
        | Category / Group
        |--------------------------------------------------------------------------
        */

        $category = Category::findOrFail(
            $validated['category_id']
        );

        $group = Group::findOrFail(
            $validated['group_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Product image
        |--------------------------------------------------------------------------
        */

        $imageUrl =
            array_key_exists(
                'image_url',
                $validated
            )
                ? $validated['image_url']
                : $product->image_url;

        if (
            ! empty(
                $validated[
                    'image_upload_token'
                ] ?? null
            )
        ) {
            $imageUrl =
                $mediaService->promoteProductImage(
                    $validated[
                        'image_upload_token'
                    ],
                    $category->slug
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Product video
        |--------------------------------------------------------------------------
        */

        $videoUrl =
            array_key_exists(
                'video_url',
                $validated
            )
                ? $validated['video_url']
                : $product->video_url;

        if (
            ! empty(
                $validated[
                    'video_upload_token'
                ] ?? null
            )
        ) {
            $videoUrl =
                $mediaService->promoteVideo(
                    $validated[
                        'video_upload_token'
                    ],
                    $category->slug
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Update product
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $validated,
                $product,
                $imageUrl,
                $videoUrl
            ) {
                $product->update([
                    'article' => $validated['article'],

                    'name' => $validated['name'],

                    'short_description' => $validated['short_description'],

                    'full_description' => $validated['full_description'],

                    'category_id' => $validated['category_id'],

                    'group_id' => $validated['group_id'],

                    'brand_id' => $validated['brand_id'],

                    'unit' => $validated['unit'],

                    'price' => $validated['price'],

                    'quantity' => $validated['quantity'],

                    'status' => $validated['status'],

                    'image_url' => $imageUrl,

                    'video_url' => $videoUrl,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Product / Group
                |--------------------------------------------------------------------------
                */

                $product->groups()->sync([
                    $validated['group_id'],
                ]);

                /*
                |--------------------------------------------------------------------------
                | Certificates
                |--------------------------------------------------------------------------
                |
                | IMPORTANT:
                |
                | This changes only the product_certificates pivot.
                |
                | It does NOT delete:
                | - Certificate records
                | - Certificate files
                | - Certificates linked to other products
                |
                */

                if (
                    array_key_exists(
                        'certificate_ids',
                        $validated
                    )
                ) {
                    $product
                        ->certificates()
                        ->sync(
                            $validated['certificate_ids']
                            ?? []
                        );
                }

                /*
                |--------------------------------------------------------------------------
                | Compatible products
                |--------------------------------------------------------------------------
                */

                if (
                    array_key_exists(
                        'compatible_product_ids',
                        $validated
                    )
                ) {
                    $this->syncCompatibleProducts(
                        $product,
                        $validated[
                            'compatible_product_ids'
                        ] ?? []
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Method
                |--------------------------------------------------------------------------
                */

                $method =
                    $validated['method']
                    ?? [];

                $product
                    ->method()
                    ->updateOrCreate(
                        [
                            'product_id' => $product->id,
                        ],
                        [
                            'ut_method' => (bool) (
                                $method['ut_method']
                                ?? false
                            ),

                            'et_method' => (bool) (
                                $method['et_method']
                                ?? false
                            ),

                            'mia_method' => (bool) (
                                $method['mia_method']
                                ?? false
                            ),

                            'iet_method' => (bool) (
                                $method['iet_method']
                                ?? false
                            ),

                            'mt_method' => (bool) (
                                $method['mt_method']
                                ?? false
                            ),

                            'vt_method' => (bool) (
                                $method['vt_method']
                                ?? false
                            ),
                        ]
                    );

                /*
                |--------------------------------------------------------------------------
                | Application sectors
                |--------------------------------------------------------------------------
                */

                $sector =
                    $validated['sector']
                    ?? [];

                $product
                    ->sector()
                    ->updateOrCreate(
                        [
                            'product_id' => $product->id,
                        ],
                        [
                            'railway' => (bool) (
                                $sector['railway']
                                ?? false
                            ),

                            'aerospace' => (bool) (
                                $sector['aerospace']
                                ?? false
                            ),

                            'oil' => (bool) (
                                $sector['oil']
                                ?? false
                            ),
                        ]
                    );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Load product relations
        |--------------------------------------------------------------------------
        */

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
     * Remove the specified resource in storage.
     */
    public function destroy(
        Product $product
    ): JsonResponse {
        DB::transaction(
            function () use ($product) {
                $product
                    ->compatibleProducts()
                    ->detach();

                $product
                    ->compatibleWithProducts()
                    ->detach();

                $product
                    ->groups()
                    ->detach();

                app(ProductDocumentFileService::class)
                    ->deleteProduct($product);

                $product->delete();
            }
        );

        return response()->json([
            'message' => 'Product deleted successfully.',
        ]);
    }

    /**
     * Return categories.
     */
    public function categories(): JsonResponse
    {
        return response()->json(
            Category::query()
                ->orderBy('id')
                ->get([
                    'id',
                    'category',
                    'slug',
                    'image_url',
                    'description',
                ])
        );
    }

    /**
     * Return groups.
     */
    public function groups(): JsonResponse
    {
        return response()->json(
            Group::query()
                ->orderBy('id')
                ->get([
                    'id',
                    'group',
                    'slug',
                    'image_url',
                    'description',
                ])
        );
    }

    public function updateDetails(
        UpdateProductDetailsRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $product->update([
            'full_description' => $validated['full_description'],
        ]);

        return response()->json([
            'success' => true,
            'full_description' => $product->full_description,
        ]);
    }

    public function updateCompatible(
        UpdateProductCompatibleRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $compatibleProductIds = collect(
            $validated['compatible_product_ids'] ?? []
        )
            ->map(fn ($id) => (int) $id)
            ->reject(fn ($id) => $id === (int) $product->id)
            ->unique()
            ->values();

        $product->compatibleProducts()->sync(
            $compatibleProductIds->all()
        );

        return response()->json([
            'success' => true,
            'compatible_product_ids' => $compatibleProductIds->all(),
        ]);
    }
}
