<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductGalleryRequest;
use App\Http\Requests\Product\UpdateProductGalleryRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductGallery;
use App\Services\ProductMediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ProductGalleryController extends Controller
{
    public function index(Product $product): JsonResponse
    {
        return response()->json([
            'gallery' => $product
                ->gallery()
                ->latest('id')
                ->get()
                ->map(
                    fn (ProductGallery $gallery) =>
                        $this->serializeGallery($gallery)
                )
                ->values()
                ->all(),
        ]);
    }

    public function store(
        StoreProductGalleryRequest $request,
        Product $product,
        ProductMediaService $mediaService
    ): JsonResponse {
        $validated = $request->validated();

        /*
         * Gallery has its own stable directory.
         *
         * It must never depend on product.image_url.
         */
        $galleryDirectory =
            $this->resolveGalleryDirectory($product);

        $basename = null;

        try {
            $basename = $mediaService->promoteGalleryImage(
                $validated['token'],
                $galleryDirectory
            );

            $gallery = DB::transaction(
                function () use (
                    $product,
                    $validated,
                    $basename
                ): ProductGallery {
                    return $product->gallery()->create([
                        'title' => [
                            'ru' =>
                                $validated['title']['ru'],
                            'en' =>
                                $validated['title']['en'],
                        ],

                        'image_url' => $basename,

                        'description' => [
                            'ru' =>
                                $validated['description']['ru']
                                ?? null,
                            'en' =>
                                $validated['description']['en']
                                ?? null,
                        ],
                    ]);
                }
            );
        } catch (\Throwable $exception) {
            if ($basename) {
                $this->deleteGalleryFiles(
                    $galleryDirectory,
                    $basename
                );
            }

            throw $exception;
        }

        return response()->json([
            'gallery' =>
                $this->serializeGallery($gallery),
        ], 201);
    }

    public function update(
        UpdateProductGalleryRequest $request,
        Product $product,
        ProductGallery $productGallery
    ): JsonResponse {
        $this->ensureGalleryBelongsToProduct(
            $product,
            $productGallery
        );

        $validated = $request->validated();

        $data = [];

        if (array_key_exists('title', $validated)) {
            $data['title'] = [
                'ru' =>
                    $validated['title']['ru'],
                'en' =>
                    $validated['title']['en'],
            ];
        }

        if (array_key_exists('description', $validated)) {
            $data['description'] = [
                'ru' =>
                    $validated['description']['ru']
                    ?? null,
                'en' =>
                    $validated['description']['en']
                    ?? null,
            ];
        }

        $productGallery->update($data);

        return response()->json([
            'gallery' =>
                $this->serializeGallery(
                    $productGallery->fresh()
                ),
        ]);
    }

    public function destroy(
        Product $product,
        ProductGallery $productGallery
    ): JsonResponse {
        $this->ensureGalleryBelongsToProduct(
            $product,
            $productGallery
        );

        /*
         * Only remove the database relation.
         *
         * Physical files are intentionally preserved.
         */
        $productGallery->delete();

        return response()->json([
            'message' =>
                'Product gallery item removed successfully.',
        ]);
    }

    /**
     * Resolve the stable gallery directory for a product.
     *
     * New gallery files are completely independent from
     * the current product.image_url.
     */
    private function resolveGalleryDirectory(
        Product $product
    ): string {
        /*
         * Existing gallery:
         *
         * Reuse its existing physical directory so that
         * adding another image does not create a new directory
         * for an already existing gallery.
         */
        $existingGallery = $product
            ->gallery()
            ->latest('id')
            ->first();

        if ($existingGallery) {
            $imageName = pathinfo(
                basename($existingGallery->image_url),
                PATHINFO_FILENAME
            );

            $directory = preg_replace(
                '/_\d+$/',
                '',
                $imageName
            );

            if ($directory) {
                return $directory;
            }
        }

        /*
         * First gallery image:
         *
         * Create a stable directory based only on the product ID.
         *
         * This value never changes when product.image_url changes.
         */
        return 'product-'.$product->id;
    }

    private function serializeGallery(
        ProductGallery $gallery
    ): array {
        $galleryImageName = pathinfo(
            basename($gallery->image_url),
            PATHINFO_FILENAME
        );

        /*
         * The directory is derived exclusively from the
         * gallery image name.
         *
         * Example:
         *
         * product-76_2
         *      ↓
         * product-76
         */
        $galleryDirectory = preg_replace(
            '/_\d+$/',
            '',
            $galleryImageName
        );

        if (! $galleryDirectory) {
            $galleryDirectory = $galleryImageName;
        }

        return [
            'id' => $gallery->id,

            'thumbnail' =>
                '/image/gallery/'
                .$galleryDirectory
                .'/thumbnails/'
                .$galleryImageName
                .'.webp',

            'image_url' =>
                '/image/gallery/'
                .$galleryDirectory
                .'/'
                .$galleryImageName
                .'.webp',

            'title' =>
                $gallery->title,

            'description' =>
                $gallery->description,
        ];
    }

    private function ensureGalleryBelongsToProduct(
        Product $product,
        ProductGallery $productGallery
    ): void {
        abort_unless(
            $productGallery->product_id === $product->id,
            404
        );
    }

    private function deleteGalleryFiles(
        string $galleryDirectory,
        string $basename
    ): void {
        $directory = public_path(
            'image/gallery/'
            .$galleryDirectory
        );

        $originalPath =
            $directory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        $thumbnailPath =
            $directory
            .DIRECTORY_SEPARATOR
            .'thumbnails'
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        if (is_file($originalPath)) {
            @unlink($originalPath);
        }

        if (is_file($thumbnailPath)) {
            @unlink($thumbnailPath);
        }
    }
}
