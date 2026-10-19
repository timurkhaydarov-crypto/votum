<?php

namespace Tests\Unit;

use App\Services\ProductMediaService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ProductAppImageFileCleanupTest extends TestCase
{
    public function test_deletes_only_the_requested_app_image_and_thumbnail(): void
    {
        do {
            $productAppId = random_int(1_000_000_000, 2_000_000_000);
            $otherProductAppId = $productAppId + 1;
            $directory = public_path('image/product-apps/'.$productAppId);
            $otherDirectory = public_path(
                'image/product-apps/'.$otherProductAppId
            );
        } while (File::isDirectory($directory) || File::isDirectory($otherDirectory));

        File::ensureDirectoryExists($directory.'/thumbnails');
        File::ensureDirectoryExists($otherDirectory.'/thumbnails');

        $image = $directory.'/shared-name.webp';
        $thumbnail = $directory.'/thumbnails/shared-name.webp';
        $otherImage = $otherDirectory.'/shared-name.webp';
        $otherThumbnail = $otherDirectory.'/thumbnails/shared-name.webp';

        file_put_contents($image, 'image');
        file_put_contents($thumbnail, 'thumbnail');
        file_put_contents($otherImage, 'other image');
        file_put_contents($otherThumbnail, 'other thumbnail');

        try {
            (new ProductMediaService)->deleteProductAppImage(
                'product-apps/'.$productAppId.'/shared-name'
            );

            $this->assertFileDoesNotExist($image);
            $this->assertFileDoesNotExist($thumbnail);
            $this->assertFileExists($otherImage);
            $this->assertFileExists($otherThumbnail);
        } finally {
            File::deleteDirectory($directory);
            File::deleteDirectory($otherDirectory);
        }
    }
}
