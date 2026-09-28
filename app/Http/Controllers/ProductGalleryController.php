<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductGalleryRequest;
use App\Http\Requests\Product\UpdateProductGalleryRequest;
use App\Models\Product\Product;
use App\Models\Product\ProductGallery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductGalleryController extends Controller
{
    private const MAX_FILE_SIZE = 102400;

    /**
     * Store a newly created product gallery item.
     */
    public function store(
        StoreProductGalleryRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        /** @var UploadedFile|null $file */
        $file = $request->file('image');

        if (! $file instanceof UploadedFile) {
            return response()->json([
                'message' => 'Image file is required.',
            ], 422);
        }

        if (! $product->image_url) {
            return response()->json([
                'message' =>
                    'Product image_url is required for gallery.',
            ], 422);
        }

        $gallery = null;
        $absolutePath = null;

        try {
            $gallery = DB::transaction(
                function () use (
                    $product,
                    $validated,
                    $file,
                    &$absolutePath
                ) {
                    $imageName = $this->resolveProductImageName(
                        $product->image_url
                    );

                    $directory = public_path(
                        "image/gallery/{$imageName}"
                    );

                    if (
                        ! is_dir($directory) &&
                        ! mkdir($directory, 0755, true) &&
                        ! is_dir($directory)
                    ) {
                        abort(
                            500,
                            'Unable to create product gallery directory.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Find first free gallery slot
                    |--------------------------------------------------------------------------
                    */

                    $slot = $this->findFreeSlot(
                        $product,
                        $imageName
                    );

                    $filename =
                        "{$imageName}_{$slot}.webp";

                    $absolutePath =
                        $directory .
                        DIRECTORY_SEPARATOR .
                        $filename;

                    /*
                    |--------------------------------------------------------------------------
                    | Convert image to WebP
                    |--------------------------------------------------------------------------
                    */

                    $webpData = $this->convertToWebp(
                        $file
                    );

                    if (
                        file_put_contents(
                            $absolutePath,
                            $webpData
                        ) === false
                    ) {
                        abort(
                            500,
                            'Unable to save product gallery image.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Save gallery record
                    |--------------------------------------------------------------------------
                    */

                    return $product->gallery()->create([
                        'title' => [
                            'ru' =>
                                $validated['title']['ru'] ?? null,

                            'en' =>
                                $validated['title']['en'] ?? null,
                        ],

                        'image_url' =>
                            $filename,

                        'description' => [
                            'ru' =>
                                $validated['description']['ru'] ?? null,

                            'en' =>
                                $validated['description']['en'] ?? null,
                        ],
                    ]);
                }
            );
        } catch (\Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | Remove uploaded file if database transaction failed
            |--------------------------------------------------------------------------
            */

            if (
                $absolutePath &&
                is_file($absolutePath)
            ) {
                @unlink($absolutePath);
            }

            throw $exception;
        }

        return response()->json([
            'gallery' =>
                $gallery->fresh(),
        ], 201);
    }

    /**
     * Update an existing product gallery item.
     */
    public function update(
        UpdateProductGalleryRequest $request,
        Product $product,
        ProductGallery $productGallery
    ): JsonResponse {
        /*
        |--------------------------------------------------------------------------
        | Make sure the gallery item belongs to this product
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $productGallery->product_id === $product->id,
            404
        );

        $validated = $request->validated();

        $data = [];

        if (
            array_key_exists(
                'title',
                $validated
            )
        ) {
            $data['title'] = [
                'ru' =>
                    $validated['title']['ru'] ?? null,

                'en' =>
                    $validated['title']['en'] ?? null,
            ];
        }

        if (
            array_key_exists(
                'description',
                $validated
            )
        ) {
            $data['description'] = [
                'ru' =>
                    $validated['description']['ru'] ?? null,

                'en' =>
                    $validated['description']['en'] ?? null,
            ];
        }

        $productGallery->update($data);

        return response()->json([
            'gallery' =>
                $productGallery->fresh(),
        ]);
    }

    /**
     * Remove the specified product gallery item.
     */
    public function destroy(
        Product $product,
        ProductGallery $productGallery
    ): JsonResponse {
        /*
        |--------------------------------------------------------------------------
        | Make sure the gallery item belongs to this product
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $productGallery->product_id === $product->id,
            404
        );

        $imageName = $this->resolveProductImageName(
            $product->image_url
        );

        $filename =
            $productGallery->image_url;

        $absolutePath = public_path(
            "image/gallery/{$imageName}/{$filename}"
        );

        /*
        |--------------------------------------------------------------------------
        | Delete database record
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $productGallery
        ) {
            $productGallery->delete();
        });

        /*
        |--------------------------------------------------------------------------
        | Delete physical image
        |--------------------------------------------------------------------------
        */

        if (
            is_file($absolutePath)
        ) {
            @unlink($absolutePath);
        }

        return response()->json([
            'message' =>
                'Product gallery item deleted successfully.',
        ]);
    }

    /**
     * Resolve the base image name from Product::$image_url.
     *
     * Example:
     *
     * chameleon_16-64.webp
     *
     * becomes:
     *
     * chameleon_16-64
     */
    private function resolveProductImageName(
        string $imageUrl
    ): string {
        $imageName = pathinfo(
            basename($imageUrl),
            PATHINFO_FILENAME
        );

        $imageName = preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '-',
            $imageName
        );

        $imageName = trim(
            $imageName,
            '-_'
        );

        if (! $imageName) {
            abort(
                422,
                'Unable to determine product image name.'
            );
        }

        return $imageName;
    }

    /**
     * Find the first free gallery slot.
     *
     * Example:
     *
     * _1
     * _2
     * _3
     * _4
     *
     * If _2 is deleted, the next upload will reuse _2.
     */
    private function findFreeSlot(
        Product $product,
        string $imageName
    ): int {
        $usedSlots = [];

        $gallery = $product->gallery()
            ->get([
                'image_url',
            ]);

        foreach ($gallery as $item) {
            if (! $item->image_url) {
                continue;
            }

            if (
                preg_match(
                    '/_(\d+)\.webp$/i',
                    $item->image_url,
                    $matches
                )
            ) {
                $usedSlots[] =
                    (int) $matches[1];
            }
        }

        $directory = public_path(
            "image/gallery/{$imageName}"
        );

        $slot = 1;

        while (true) {
            /*
            |--------------------------------------------------------------------------
            | Slot already exists in database
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $slot,
                    $usedSlots,
                    true
                )
            ) {
                $slot++;

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Slot exists physically
            |--------------------------------------------------------------------------
            */

            $filename =
                "{$imageName}_{$slot}.webp";

            $absolutePath =
                $directory .
                DIRECTORY_SEPARATOR .
                $filename;

            if (
                is_file($absolutePath)
            ) {
                $slot++;

                continue;
            }

            return $slot;
        }
    }

    /**
     * Convert uploaded image to WebP.
     */
    private function convertToWebp(
        UploadedFile $file
    ): string {
        /*
        |--------------------------------------------------------------------------
        | Check uploaded file size
        |--------------------------------------------------------------------------
        */

        if (
            $file->getSize() >
            self::MAX_FILE_SIZE
        ) {
            abort(
                422,
                'The image size must not exceed 100 KB.'
            );
        }

        $contents = file_get_contents(
            $file->getRealPath()
        );

        if ($contents === false) {
            abort(
                422,
                'Unable to read uploaded image.'
            );
        }

        $source = imagecreatefromstring(
            $contents
        );

        if (! $source) {
            abort(
                422,
                'Unable to process uploaded image.'
            );
        }

        imagesavealpha(
            $source,
            true
        );

        $sourceWidth =
            imagesx($source);

        $sourceHeight =
            imagesy($source);

        /*
        |--------------------------------------------------------------------------
        | Initial resize
        |--------------------------------------------------------------------------
        */

        $maxDimension = 1600;

        if (
            max(
                $sourceWidth,
                $sourceHeight
            ) > $maxDimension
        ) {
            $scale =
                $maxDimension /
                max(
                    $sourceWidth,
                    $sourceHeight
                );

            $targetWidth = max(
                1,
                (int) round(
                    $sourceWidth * $scale
                )
            );

            $targetHeight = max(
                1,
                (int) round(
                    $sourceHeight * $scale
                )
            );

            $canvas =
                $this->createTransparentCanvas(
                    $targetWidth,
                    $targetHeight
                );

            imagecopyresampled(
                $canvas,
                $source,
                0,
                0,
                0,
                0,
                $targetWidth,
                $targetHeight,
                $sourceWidth,
                $sourceHeight
            );

            imagedestroy(
                $source
            );

            $source = $canvas;

            $sourceWidth =
                $targetWidth;

            $sourceHeight =
                $targetHeight;
        }

        /*
        |--------------------------------------------------------------------------
        | Try different WebP qualities
        |--------------------------------------------------------------------------
        */

        foreach (
            [
                82,
                75,
                68,
                60,
                52,
                45,
                40,
            ] as $quality
        ) {
            $webpData =
                $this->encodeWebp(
                    $source,
                    $quality
                );

            if (
                strlen($webpData) <=
                self::MAX_FILE_SIZE
            ) {
                imagedestroy(
                    $source
                );

                return $webpData;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Additional resize
        |--------------------------------------------------------------------------
        */

        for (
            $attempt = 0;
            $attempt < 5;
            $attempt++
        ) {
            $newWidth = max(
                320,
                (int) round(
                    $sourceWidth * 0.80
                )
            );

            $newHeight = max(
                320,
                (int) round(
                    $sourceHeight * 0.80
                )
            );

            $canvas =
                $this->createTransparentCanvas(
                    $newWidth,
                    $newHeight
                );

            imagecopyresampled(
                $canvas,
                $source,
                0,
                0,
                0,
                0,
                $newWidth,
                $newHeight,
                $sourceWidth,
                $sourceHeight
            );

            imagedestroy(
                $source
            );

            $source = $canvas;

            $sourceWidth =
                $newWidth;

            $sourceHeight =
                $newHeight;

            foreach (
                [
                    65,
                    55,
                    45,
                    40,
                ] as $quality
            ) {
                $webpData =
                    $this->encodeWebp(
                        $source,
                        $quality
                    );

                if (
                    strlen($webpData) <=
                    self::MAX_FILE_SIZE
                ) {
                    imagedestroy(
                        $source
                    );

                    return $webpData;
                }
            }
        }

        imagedestroy(
            $source
        );

        abort(
            422,
            'Unable to convert the image to WebP under 100 KB.'
        );
    }

    /**
     * Create transparent canvas.
     */
    private function createTransparentCanvas(
        int $width,
        int $height
    ) {
        $canvas =
            imagecreatetruecolor(
                $width,
                $height
            );

        imagealphablending(
            $canvas,
            false
        );

        imagesavealpha(
            $canvas,
            true
        );

        $transparent =
            imagecolorallocatealpha(
                $canvas,
                0,
                0,
                0,
                127
            );

        imagefill(
            $canvas,
            0,
            0,
            $transparent
        );

        return $canvas;
    }

    /**
     * Encode GD image as WebP.
     */
    private function encodeWebp(
        $image,
        int $quality
    ): string {
        ob_start();

        imagewebp(
            $image,
            null,
            $quality
        );

        $data =
            ob_get_clean();

        if ($data === false) {
            abort(
                422,
                'Unable to encode image as WebP.'
            );
        }

        return $data;
    }
}