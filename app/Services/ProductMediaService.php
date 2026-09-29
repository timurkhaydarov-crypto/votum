<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Symfony\Component\Process\Process;

class ProductMediaService
{
    private const LOCAL_DISK = 'local';

    private const FFMPEG_BINARY = '/opt/homebrew/bin/ffmpeg';

    private const GALLERY_MAX_WIDTH = 1600;

    private const GALLERY_THUMBNAIL_WIDTH = 600;

    private const IMAGE_EXTENSIONS = [
        'jpg',
        'jpeg',
        'png',
        'webp',
    ];

    private const VIDEO_EXTENSIONS = [
        'mp4',
        'webm',
        'mov',
    ];

    public function promoteProductImage(
        string $token,
        string $categorySlug
    ): string {
        return $this->promoteImage(
            $token,
            'image/product/'
            .trim($categorySlug, '/')
        );
    }

    /**
     * Promote an uploaded image to the product gallery.
     *
     * Gallery files use the product image basename as their
     * directory and receive an incremental suffix:
     *
     * kalmar_2.webp
     * kalmar_3.webp
     * kalmar_4.webp
     *
     * The returned value is stored in product_galleries.image_url:
     *
     * kalmar_2
     * kalmar_3
     * kalmar_4
     */
    public function promoteGalleryImage(
        string $token,
        string $galleryDirectory
    ): string {
        $galleryDirectory =
            $this->sanitizeBasename(
                $galleryDirectory
            );

        $directory = public_path(
            'image/gallery/'
            .$galleryDirectory
        );

        File::ensureDirectoryExists(
            $directory
        );

        /*
         * Find the next gallery index.
         *
         * The first gallery image starts with _2 because
         * the base name without an index belongs to the
         * product's main image.
         */
        $index = $this->getNextGalleryIndex(
            $directory,
            $galleryDirectory
        );

        $basename =
            $galleryDirectory
            .'_'
            .$index;

        $this->promoteImageToBasename(
            $token,
            $directory,
            $basename,
            self::GALLERY_MAX_WIDTH
        );

        $sourcePath =
            $directory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        $thumbnailDirectory =
            $directory
            .DIRECTORY_SEPARATOR
            .'thumbnails';

        File::ensureDirectoryExists(
            $thumbnailDirectory
        );

        $thumbnailPath =
            $thumbnailDirectory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        $this->createThumbnail(
            $sourcePath,
            $thumbnailPath,
            self::GALLERY_THUMBNAIL_WIDTH
        );

        return $basename;
    }

    public function promoteFeaturesImage(
        string $token
    ): string {
        return $this->promoteImage(
            $token,
            'image/features'
        );
    }

    public function promoteVideo(
        string $token,
        string $categorySlug
    ): string {
        set_time_limit(0);

        $temporaryUploadService = app(
            TemporaryUploadService::class
        );

        $tempPath =
            $temporaryUploadService->resolve($token);

        if (! $tempPath) {
            throw new RuntimeException(
                'Temporary video upload not found.'
            );
        }

        $extension = strtolower(
            pathinfo(
                $token,
                PATHINFO_EXTENSION
            )
        );

        if (
            ! in_array(
                $extension,
                self::VIDEO_EXTENSIONS,
                true
            )
        ) {
            throw new RuntimeException(
                'Invalid video upload.'
            );
        }

        $sourcePath = Storage::disk(
            self::LOCAL_DISK
        )->path($tempPath);

        $basename = pathinfo(
            $token,
            PATHINFO_FILENAME
        );

        $targetDirectory = public_path(
            'video/product/'
            .trim($categorySlug, '/')
        );

        File::ensureDirectoryExists(
            $targetDirectory
        );

        $webmPath =
            $targetDirectory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webm';

        $mp4Path =
            $targetDirectory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.mp4';

        if (! is_file(self::FFMPEG_BINARY)) {
            throw new RuntimeException(
                'FFmpeg executable not found: '
                .self::FFMPEG_BINARY
            );
        }

        if ($extension === 'webm') {
            if (! copy(
                $sourcePath,
                $webmPath
            )) {
                throw new RuntimeException(
                    'Unable to copy WebM video.'
                );
            }
        } else {
            $webmProcess = new Process([
                self::FFMPEG_BINARY,
                '-y',
                '-i',
                $sourcePath,

                '-c:v',
                'libvpx-vp9',

                '-crf',
                '32',

                '-b:v',
                '0',

                '-c:a',
                'libopus',

                '-b:a',
                '128k',

                $webmPath,
            ]);

            $webmProcess->setTimeout(600);
            $webmProcess->run();

            if (! $webmProcess->isSuccessful()) {
                throw new RuntimeException(
                    'Unable to convert video to WebM: '
                    .$webmProcess->getErrorOutput()
                );
            }
        }

        if ($extension === 'mp4') {
            if (! copy(
                $sourcePath,
                $mp4Path
            )) {
                throw new RuntimeException(
                    'Unable to copy MP4 video.'
                );
            }
        } else {
            $mp4Process = new Process([
                self::FFMPEG_BINARY,
                '-y',
                '-i',
                $sourcePath,

                '-c:v',
                'libx264',

                '-preset',
                'medium',

                '-crf',
                '23',

                '-c:a',
                'aac',

                '-b:a',
                '128k',

                '-movflags',
                '+faststart',

                $mp4Path,
            ]);

            $mp4Process->setTimeout(600);
            $mp4Process->run();

            if (! $mp4Process->isSuccessful()) {
                throw new RuntimeException(
                    'Unable to convert video to MP4: '
                    .$mp4Process->getErrorOutput()
                );
            }
        }

        Storage::disk(
            self::LOCAL_DISK
        )->delete($tempPath);

        return $basename;
    }

    protected function promoteImage(
        string $token,
        string $directory,
        ?int $maxWidth = null
    ): string {
        $temporaryUploadService = app(
            TemporaryUploadService::class
        );

        $tempPath =
            $temporaryUploadService->resolve($token);

        if (! $tempPath) {
            throw new RuntimeException(
                'Temporary image upload not found.'
            );
        }

        $extension = strtolower(
            pathinfo(
                $token,
                PATHINFO_EXTENSION
            )
        );

        if (
            ! in_array(
                $extension,
                self::IMAGE_EXTENSIONS,
                true
            )
        ) {
            throw new RuntimeException(
                'Invalid image upload.'
            );
        }

        $sourcePath = Storage::disk(
            self::LOCAL_DISK
        )->path($tempPath);

        $basename = pathinfo(
            $token,
            PATHINFO_FILENAME
        );

        $directory = trim(
            $directory,
            '/'
        );

        $targetDirectory = public_path(
            $directory
        );

        File::ensureDirectoryExists(
            $targetDirectory
        );

        $targetPath =
            $targetDirectory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        $this->convertToWebp(
            $sourcePath,
            $targetPath,
            $maxWidth
        );

        Storage::disk(
            self::LOCAL_DISK
        )->delete($tempPath);

        return $basename;
    }

    /**
     * Promote an image using an explicitly provided basename.
     *
     * This is used by the gallery because the gallery filename
     * must follow the product naming convention rather than
     * the temporary upload UUID.
     */
    protected function promoteImageToBasename(
        string $token,
        string $directory,
        string $basename,
        ?int $maxWidth = null
    ): string {
        $temporaryUploadService = app(
            TemporaryUploadService::class
        );

        $tempPath =
            $temporaryUploadService->resolve($token);

        if (! $tempPath) {
            throw new RuntimeException(
                'Temporary image upload not found.'
            );
        }

        $extension = strtolower(
            pathinfo(
                $token,
                PATHINFO_EXTENSION
            )
        );

        if (
            ! in_array(
                $extension,
                self::IMAGE_EXTENSIONS,
                true
            )
        ) {
            throw new RuntimeException(
                'Invalid image upload.'
            );
        }

        $sourcePath = Storage::disk(
            self::LOCAL_DISK
        )->path($tempPath);

        File::ensureDirectoryExists(
            $directory
        );

        $targetPath =
            $directory
            .DIRECTORY_SEPARATOR
            .$basename
            .'.webp';

        try {
            $this->convertToWebp(
                $sourcePath,
                $targetPath,
                $maxWidth
            );
        } catch (\Throwable $exception) {
            /*
             * Do not consume the temporary upload if
             * image conversion failed.
             */
            throw $exception;
        }

        /*
         * The temporary upload has now been successfully
         * promoted and can be removed.
         */
        Storage::disk(
            self::LOCAL_DISK
        )->delete($tempPath);

        return $basename;
    }

    /**
     * Determine the next gallery index.
     *
     * Example:
     *
     * kalmar.webp
     * kalmar_2.webp
     * kalmar_3.webp
     *
     * returns 4.
     */
    protected function getNextGalleryIndex(
        string $directory,
        string $galleryDirectory
    ): int {
        $maxIndex = 1;

        if (! is_dir($directory)) {
            return 2;
        }

        $files = File::files(
            $directory
        );

        foreach ($files as $file) {
            $filename = $file->getFilename();

            if (
                ! preg_match(
                    '/^'
                    .preg_quote(
                        $galleryDirectory,
                        '/'
                    )
                    .'_(\d+)\.webp$/i',
                    $filename,
                    $matches
                )
            ) {
                continue;
            }

            $index = (int) $matches[1];

            if ($index > $maxIndex) {
                $maxIndex = $index;
            }
        }

        return max(
            2,
            $maxIndex + 1
        );
    }

    protected function sanitizeBasename(
        string $basename
    ): string {
        $basename = pathinfo(
            basename($basename),
            PATHINFO_FILENAME
        );

        $basename = preg_replace(
            '/[^A-Za-z0-9_-]+/',
            '-',
            $basename
        );

        $basename = trim(
            $basename,
            '-_'
        );

        if (! $basename) {
            throw new RuntimeException(
                'Unable to determine image basename.'
            );
        }

        return $basename;
    }

    protected function convertToWebp(
        string $sourcePath,
        string $targetPath,
        ?int $maxWidth = null
    ): void {
        if (! function_exists('imagewebp')) {
            throw new RuntimeException(
                'PHP GD extension with WebP support is required.'
            );
        }

        $imageInfo = getimagesize(
            $sourcePath
        );

        if (! $imageInfo) {
            throw new RuntimeException(
                'Invalid image file.'
            );
        }

        $source = match ($imageInfo[2]) {
            IMAGETYPE_JPEG => imagecreatefromjpeg(
                $sourcePath
            ),

            IMAGETYPE_PNG => imagecreatefrompng(
                $sourcePath
            ),

            IMAGETYPE_WEBP => imagecreatefromwebp(
                $sourcePath
            ),

            default => false,
        };

        if (! $source) {
            throw new RuntimeException(
                'Unsupported image format.'
            );
        }

        if (
            function_exists(
                'imagepalettetotruecolor'
            )
        ) {
            imagepalettetotruecolor(
                $source
            );
        }

        imagealphablending(
            $source,
            true
        );

        imagesavealpha(
            $source,
            true
        );

        $sourceWidth = imagesx(
            $source
        );

        $sourceHeight = imagesy(
            $source
        );

        /*
         * Resize only when the source image is wider
         * than the requested maximum width.
         *
         * Small images are never upscaled.
         */
        if (
            $maxWidth !== null
            && $sourceWidth > $maxWidth
        ) {
            $targetWidth = $maxWidth;

            $targetHeight = (int) round(
                $sourceHeight
                * (
                    $targetWidth
                    / $sourceWidth
                )
            );

            $resized = imagecreatetruecolor(
                $targetWidth,
                $targetHeight
            );

            imagealphablending(
                $resized,
                false
            );

            imagesavealpha(
                $resized,
                true
            );

            imagecopyresampled(
                $resized,
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

            $source = $resized;
        }

        if (
            ! imagewebp(
                $source,
                $targetPath,
                90
            )
        ) {
            imagedestroy(
                $source
            );

            throw new RuntimeException(
                'Unable to convert image to WebP.'
            );
        }

        imagedestroy(
            $source
        );
    }

    protected function createThumbnail(
        string $sourcePath,
        string $targetPath,
        int $maxWidth
    ): void {
        $source = imagecreatefromwebp(
            $sourcePath
        );

        if (! $source) {
            throw new RuntimeException(
                'Unable to create thumbnail source.'
            );
        }

        $sourceWidth = imagesx(
            $source
        );

        $sourceHeight = imagesy(
            $source
        );

        if ($sourceWidth <= $maxWidth) {
            copy(
                $sourcePath,
                $targetPath
            );

            imagedestroy(
                $source
            );

            return;
        }

        $targetWidth = $maxWidth;

        $targetHeight = (int) round(
            $sourceHeight
            * (
                $targetWidth
                / $sourceWidth
            )
        );

        $thumbnail = imagecreatetruecolor(
            $targetWidth,
            $targetHeight
        );

        imagealphablending(
            $thumbnail,
            false
        );

        imagesavealpha(
            $thumbnail,
            true
        );

        imagecopyresampled(
            $thumbnail,
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

        imagewebp(
            $thumbnail,
            $targetPath,
            90
        );

        imagedestroy(
            $thumbnail
        );

        imagedestroy(
            $source
        );
    }
}

