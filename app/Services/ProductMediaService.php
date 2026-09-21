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

    /**
     * Main product image.
     *
     * Result:
     * public/image/product/{categorySlug}/{basename}.webp
     */
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
     * Product gallery image.
     *
     * Result:
     * public/image/gallery/{productImageBasename}/{basename}.webp
     */
    public function promoteGalleryImage(
        string $token,
        string $productImageBasename
    ): string {
        $basename = $this->promoteImage(
            $token,
            'image/gallery/'
            .trim($productImageBasename, '/')
        );

        $sourcePath = public_path(
            'image/gallery/'
            .$productImageBasename
            .'/'
            .$basename
            .'.webp'
        );

        $thumbnailDirectory = public_path(
            'image/gallery/'
            .$productImageBasename
            .'/thumbnails'
        );

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
            480
        );

        return $basename;
    }

    /**
     * Features image.
     *
     * Result:
     * public/image/features/{basename}.webp
     */
    public function promoteFeaturesImage(
        string $token
    ): string {
        return $this->promoteImage(
            $token,
            'image/features'
        );
    }

    /**
     * Main product video.
     *
     * Creates both:
     *
     * public/video/product/{categorySlug}/{basename}.webm
     * public/video/product/{categorySlug}/{basename}.mp4
     *
     * Source handling:
     *
     * MP4:
     *   - WebM: FFmpeg conversion
     *   - MP4: original file copied without conversion
     *
     * WebM:
     *   - WebM: original file copied without conversion
     *   - MP4: FFmpeg conversion
     *
     * MOV:
     *   - WebM: FFmpeg conversion
     *   - MP4: FFmpeg conversion
     *
     * Returns only basename without extension.
     */
    public function promoteVideo(
        string $token,
        string $categorySlug
    ): string {
        /*
         * Video conversion may take longer than PHP's
         * default execution time.
         */
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

        /*
         * The database stores only basename:
         *
         * UUID
         *
         * without .mp4 / .webm / .mov
         */
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

        /*
         * Make sure FFmpeg exists.
         */
        if (! is_file(self::FFMPEG_BINARY)) {
            throw new RuntimeException(
                'FFmpeg executable not found: '
                .self::FFMPEG_BINARY
            );
        }

        /*
         * =====================================================
         * WEBM
         * =====================================================
         *
         * If source is already WebM:
         * simply copy it.
         *
         * MP4 / MOV:
         * convert to WebM using VP9 + Opus.
         */
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

        /*
         * =====================================================
         * MP4
         * =====================================================
         *
         * If source is already MP4:
         * simply copy the original file.
         *
         * WebM / MOV:
         * convert to H.264 + AAC.
         */
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

        /*
         * Remove temporary upload after both files
         * have been created successfully.
         */
        Storage::disk(
            self::LOCAL_DISK
        )->delete($tempPath);

        /*
         * Store only basename in DB.
         */
        return $basename;
    }

    /**
     * Promote temporary image to public WebP.
     */
    protected function promoteImage(
        string $token,
        string $directory
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
            $targetPath
        );

        Storage::disk(
            self::LOCAL_DISK
        )->delete($tempPath);

        return $basename;
    }

    /**
     * Convert image to WebP.
     */
    protected function convertToWebp(
        string $sourcePath,
        string $targetPath
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
            IMAGETYPE_JPEG =>
                imagecreatefromjpeg(
                    $sourcePath
                ),

            IMAGETYPE_PNG =>
                imagecreatefrompng(
                    $sourcePath
                ),

            IMAGETYPE_WEBP =>
                imagecreatefromwebp(
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

    /**
     * Create gallery thumbnail.
     */
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