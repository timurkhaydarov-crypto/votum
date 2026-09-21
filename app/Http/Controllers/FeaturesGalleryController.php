<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreFeaturesGalleryRequest;
use App\Http\Requests\Product\UpdateFeaturesGalleryRequest;
use App\Models\Product\FeaturesGallery;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeaturesGalleryController extends Controller
{
    private const MAX_ITEMS = 4;

    private const MAX_FILE_SIZE = 102400;

    /**
     * Store a newly created gallery item.
     */
    public function store(
        StoreFeaturesGalleryRequest $request,
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
                    'Product image_url is required for feature gallery.',
            ], 422);
        }

        $featuresGallery = null;
        $absolutePath = null;

        try {
            $featuresGallery = DB::transaction(
                function () use (
                    $product,
                    $validated,
                    $file,
                    &$absolutePath
                ) {
                    $features = $product->features()
                        ->lockForUpdate()
                        ->first();

                    if (! $features) {
                        abort(
                            422,
                            'Product features not found.'
                        );
                    }

                    if (
                        $features->gallery()->count() >=
                        self::MAX_ITEMS
                    ) {
                        abort(
                            422,
                            'A product can have no more than 4 feature images.'
                        );
                    }

                    $imageName =
                        $this->resolveProductImageName(
                            $product->image_url
                        );

                    $slot =
                        $this->findFreeSlot(
                            $features,
                            $imageName
                        );

                    if ($slot === null) {
                        abort(
                            422,
                            'No free feature gallery slot is available.'
                        );
                    }

                    $filename =
                        "{$imageName}_{$slot}.webp";

                    $directory =
                        public_path(
                            "image/features/{$imageName}"
                        );

                    if (
                        ! is_dir($directory) &&
                        ! mkdir(
                            $directory,
                            0755,
                            true
                        ) &&
                        ! is_dir($directory)
                    ) {
                        abort(
                            500,
                            'Unable to create feature gallery directory.'
                        );
                    }

                    $absolutePath =
                        $directory .
                        DIRECTORY_SEPARATOR .
                        $filename;

                    $webpData =
                        $this->convertToWebp(
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
                            'Unable to save feature gallery image.'
                        );
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | В БД сохраняем только имя файла
                    |--------------------------------------------------------------------------
                    */

                    return $features->gallery()->create([
                        'title' => [
                            'ru' =>
                                $validated['title']['ru'] ?? null,

                            'en' =>
                                $validated['title']['en'] ?? null,
                        ],

                        'image_url' =>
                            $filename,
                    ]);
                }
            );
        } catch (\Throwable $exception) {
            if (
                $absolutePath &&
                is_file($absolutePath)
            ) {
                @unlink($absolutePath);
            }

            throw $exception;
        }

        return response()->json([
            'gallery' => $featuresGallery,
        ], 201);
    }

    /**
     * Update the title of an existing gallery item.
     */
    public function update(
        UpdateFeaturesGalleryRequest $request,
        Product $product,
        FeaturesGallery $featuresGallery
    ): JsonResponse {
        $features = $product->features()
            ->firstOrFail();

        abort_unless(
            $featuresGallery->features_id ===
                $features->id,
            404
        );

        $validated =
            $request->validated();

        $featuresGallery->update([
            'title' => [
                'ru' =>
                    $validated['title']['ru'] ?? null,

                'en' =>
                    $validated['title']['en'] ?? null,
            ],
        ]);

        return response()->json([
            'gallery' =>
                $featuresGallery->fresh(),
        ]);
    }

    /**
     * Remove the specified gallery item.
     */
    public function destroy(
        Product $product,
        FeaturesGallery $featuresGallery
    ): JsonResponse {
        $features = $product->features()
            ->firstOrFail();

        abort_unless(
            $featuresGallery->features_id ===
                $features->id,
            404
        );

        $imageName =
            $this->resolveProductImageName(
                $product->image_url
            );

        $filename =
            $featuresGallery->image_url;

        $absolutePath =
            public_path(
                "image/features/{$imageName}/{$filename}"
            );

        DB::transaction(function () use (
            $featuresGallery
        ) {
            $featuresGallery->delete();
        });

        if (
            is_file($absolutePath)
        ) {
            @unlink($absolutePath);
        }

        return response()->json([
            'message' =>
                'Features gallery item deleted successfully.',
        ]);
    }

    /**
     * Resolve the base image name from Product::$image_url.
     */
    private function resolveProductImageName(
        string $imageUrl
    ): string {
        $imageName =
            pathinfo(
                basename($imageUrl),
                PATHINFO_FILENAME
            );

        $imageName =
            preg_replace(
                '/[^A-Za-z0-9_-]+/',
                '-',
                $imageName
            );

        $imageName =
            trim(
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
     * Find the first free gallery slot from 1 to 4.
     */
    private function findFreeSlot(
        $features,
        string $imageName
    ): ?int {
        $usedSlots = [];

        $gallery =
            $features->gallery()
                ->get([
                    'image_url',
                ]);

        foreach ($gallery as $item) {
            if (! $item->image_url) {
                continue;
            }

            if (
                preg_match(
                    '/_' .
                    '([1-4])' .
                    '\.webp$/i',
                    $item->image_url,
                    $matches
                )
            ) {
                $usedSlots[] =
                    (int) $matches[1];
            }
        }

        $directory =
            public_path(
                "image/features/{$imageName}"
            );

        for (
            $slot = 1;
            $slot <= self::MAX_ITEMS;
            $slot++
        ) {
            if (
                in_array(
                    $slot,
                    $usedSlots,
                    true
                )
            ) {
                continue;
            }

            $filename =
                "{$imageName}_{$slot}.webp";

            $absolutePath =
                $directory .
                DIRECTORY_SEPARATOR .
                $filename;

            if (
                is_file($absolutePath)
            ) {
                continue;
            }

            return $slot;
        }

        return null;
    }

    /**
     * Convert uploaded image to WebP.
     */
    private function convertToWebp(
        UploadedFile $file
    ): string {
        if (
            $file->getSize() >
            self::MAX_FILE_SIZE
        ) {
            abort(
                422,
                'The image size must not exceed 100 KB.'
            );
        }

        $contents =
            file_get_contents(
                $file->getRealPath()
            );

        if ($contents === false) {
            abort(
                422,
                'Unable to read uploaded image.'
            );
        }

        $source =
            imagecreatefromstring(
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

            $targetWidth =
                max(
                    1,
                    (int) round(
                        $sourceWidth * $scale
                    )
                );

            $targetHeight =
                max(
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

            imagedestroy($source);

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
                imagedestroy($source);

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
            $newWidth =
                max(
                    320,
                    (int) round(
                        $sourceWidth * 0.80
                    )
                );

            $newHeight =
                max(
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

            imagedestroy($source);

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
                    imagedestroy($source);

                    return $webpData;
                }
            }
        }

        imagedestroy($source);

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