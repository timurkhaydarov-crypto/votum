<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductAppImagesRequest;
use App\Http\Requests\Product\StoreProductAppRequest;
use App\Http\Requests\Product\UpdateProductAppImageOrderRequest;
use App\Http\Requests\Product\UpdateProductAppRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductApp;
use App\Models\Product\ProductAppImage;
use App\Services\ProductMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductAppController extends Controller
{
    public function index(Product $product): JsonResponse
    {
        return response()->json([
            'product_apps' => $product->productApps()
                ->with('images')
                ->get()
                ->sortBy('version', SORT_NATURAL)
                ->values()
                ->map(fn (ProductApp $productApp) => $this->serialize($productApp))
                ->all(),
        ]);
    }

    public function show(
        Product $product,
        ProductApp $productApp
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);
        $productApp->load('images');

        return response()->json([
            'product_app' => $this->serialize($productApp),
        ]);
    }

    public function store(
        StoreProductAppRequest $request,
        Product $product,
        ProductMediaService $mediaService
    ): JsonResponse {
        $validated = $request->validated();
        $promotedPaths = [];

        try {
            $productApp = DB::transaction(function () use (
                $product,
                $validated,
                $mediaService,
                &$promotedPaths
            ): ProductApp {
                $productApp = $product->productApps()->create([
                    'name' => $validated['name'],
                    'version' => $validated['version'],
                    'image' => $validated['image'] ?? null,
                    'short_description' => $validated['short_description'],
                    'full_description' => $validated['full_description'],
                ]);

                foreach ($validated['image_tokens'] ?? [] as $sortOrder => $token) {
                    $imagePath = $mediaService->promoteProductAppImage(
                        $token,
                        $productApp->id
                    );
                    $promotedPaths[] = $imagePath;

                    $productApp->images()->create([
                        'image_url' => $imagePath,
                        'sort_order' => $sortOrder,
                    ]);
                }

                return $productApp->load('images');
            });
        } catch (\Throwable $exception) {
            foreach ($promotedPaths as $imagePath) {
                $mediaService->deleteProductAppImage($imagePath);
            }

            throw $exception;
        }

        return response()->json([
            'product_app' => $this->serialize($productApp),
        ], 201);
    }

    public function update(
        UpdateProductAppRequest $request,
        Product $product,
        ProductApp $productApp
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);
        $productApp->update($request->validated());
        $productApp->load('images');

        return response()->json([
            'product_app' => $this->serialize($productApp),
        ]);
    }

    public function destroy(
        Product $product,
        ProductApp $productApp
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);

        DB::transaction(fn () => $productApp->delete());

        return response()->json([
            'message' => 'Product app deleted successfully.',
        ]);
    }

    public function storeImages(
        StoreProductAppImagesRequest $request,
        Product $product,
        ProductApp $productApp,
        ProductMediaService $mediaService
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);
        $promotedPaths = [];

        try {
            $images = DB::transaction(function () use (
                $request,
                $productApp,
                $mediaService,
                &$promotedPaths
            ) {
                $maxSortOrder = $productApp->images()->max('sort_order');
                $nextSortOrder = $maxSortOrder === null
                    ? 0
                    : $maxSortOrder + 1;

                foreach ($request->validated('tokens') as $index => $token) {
                    $imagePath = $mediaService->promoteProductAppImage(
                        $token,
                        $productApp->id
                    );
                    $promotedPaths[] = $imagePath;

                    $productApp->images()->create([
                        'image_url' => $imagePath,
                        'sort_order' => $nextSortOrder + $index,
                    ]);
                }

                return $productApp->images()->get();
            });
        } catch (\Throwable $exception) {
            foreach ($promotedPaths as $imagePath) {
                $mediaService->deleteProductAppImage($imagePath);
            }

            throw $exception;
        }

        return response()->json([
            'images' => $images->map(
                fn (ProductAppImage $image) => $this->serializeImage($image)
            )->all(),
        ], 201);
    }

    public function destroyImage(
        Product $product,
        ProductApp $productApp,
        ProductAppImage $productAppImage
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);
        $this->ensureImageBelongsToApp($productApp, $productAppImage);

        DB::transaction(fn () => $productAppImage->delete());

        return response()->json([
            'message' => 'Product app image deleted successfully.',
        ]);
    }

    public function updateImageOrder(
        UpdateProductAppImageOrderRequest $request,
        Product $product,
        ProductApp $productApp
    ): JsonResponse {
        $this->ensureBelongsToProduct($product, $productApp);

        $ids = $request->validated('image_ids');
        $images = $productApp->images()
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        abort_unless($images->count() === count($ids), 404);

        DB::transaction(function () use ($ids, $images): void {
            foreach ($ids as $sortOrder => $id) {
                $images->get($id)->update([
                    'sort_order' => $sortOrder,
                ]);
            }
        });

        return response()->json([
            'images' => $productApp->images()
                ->get()
                ->map(fn (ProductAppImage $image) => $this->serializeImage($image))
                ->all(),
        ]);
    }

    private function ensureBelongsToProduct(
        Product $product,
        ProductApp $productApp
    ): void {
        abort_unless($productApp->product_id === $product->id, 404);
    }

    private function ensureImageBelongsToApp(
        ProductApp $productApp,
        ProductAppImage $image
    ): void {
        abort_unless($image->product_app_id === $productApp->id, 404);
    }

    private function serialize(ProductApp $productApp): array
    {
        return [
            'id' => $productApp->id,
            'name' => $productApp->name,
            'version' => $productApp->version,
            'image' => $productApp->image
                ? '/image/'.$productApp->image
                : null,
            'short_description' => $productApp->short_description,
            'full_description' => $productApp->full_description,
            'images' => $productApp->images
                ->map(fn (ProductAppImage $image) => $this->serializeImage($image))
                ->values()
                ->all(),
        ];
    }

    private function serializeImage(ProductAppImage $image): array
    {
        $imageName = pathinfo($image->image_url, PATHINFO_FILENAME);
        $directory = dirname($image->image_url);
        $thumbnailPath = $directory.'/thumbnails/'.$imageName.'.webp';
        $resolvedImagePath = str_ends_with($image->image_url, '.webp')
            ? $image->image_url
            : $image->image_url.'.webp';

        return [
            'id' => $image->id,
            'image_url' => '/image/'.$resolvedImagePath,
            'thumbnail' => is_file(public_path('image/'.$thumbnailPath))
                ? '/image/'.$thumbnailPath
                : '/image/'.$resolvedImagePath,
            'sort_order' => $image->sort_order,
        ];
    }
}
