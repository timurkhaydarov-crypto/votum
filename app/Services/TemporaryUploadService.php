<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class TemporaryUploadService
{
    protected const DISK = 'local';

    protected const DIRECTORY = 'uploads/tmp';

    /**
     * Store an uploaded file temporarily.
     */
    public function store(
        UploadedFile $file
    ): array {
        $uuid = (string) Str::uuid();

        $extension = strtolower(
            $file->extension()
        );

        if ($extension === '') {
            throw new RuntimeException(
                'Unable to determine uploaded file extension.'
            );
        }

        $token = $uuid.'.'.$extension;

        $path = Storage::disk(
            self::DISK
        )->putFileAs(
            self::DIRECTORY,
            $file,
            $token
        );

        if (! $path) {
            throw new RuntimeException(
                'Unable to store uploaded file.'
            );
        }

        return [
            'token' => $token,

            'path' => $path,

            'original_name' =>
                $file->getClientOriginalName(),

            'mime_type' =>
                $file->getMimeType(),

            'size' =>
                $file->getSize(),
        ];
    }

    /**
     * Resolve a temporary upload token.
     */
    public function resolve(
        string $token
    ): ?string {
        if (! $this->isValidToken($token)) {
            return null;
        }

        $path = self::DIRECTORY.'/'.$token;

        return Storage::disk(
            self::DISK
        )->exists($path)
            ? $path
            : null;
    }

    /**
     * Delete a temporary upload.
     */
    public function delete(
        string $token
    ): bool {
        $path = $this->resolve($token);

        if (! $path) {
            return false;
        }

        return Storage::disk(
            self::DISK
        )->delete($path);
    }

    /**
     * Determine whether the token has a valid format.
     */
    protected function isValidToken(
        string $token
    ): bool {
        return (bool) preg_match(
            '/^[a-f0-9-]{36}\.[a-z0-9]+$/i',
            $token
        );
    }
}