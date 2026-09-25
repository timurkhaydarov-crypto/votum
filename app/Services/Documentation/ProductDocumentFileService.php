<?php

namespace App\Services\Documentation;

use App\Models\Product\ProductDocument;
use App\Models\Product\ProductDocumentFile;
use App\Models\Product\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductDocumentFileService
{
    public function store(
        ProductDocument $document,
        UploadedFile $file,
        string $locale
    ): ProductDocumentFile {
        $existing = $document->files()
            ->where('locale', $locale)
            ->first();

        if ($existing) {
            $this->deleteFile($existing);
        }

        $directory = sprintf(
            'documentation/products/%d/%d',
            $document->product_id,
            $document->id
        );

        $fileName = sprintf(
            '%s.pdf',
            (string) Str::uuid()
        );

        $filePath = Storage::disk('local')->putFileAs(
            $directory,
            $file,
            $fileName
        );

        if (! $filePath) {
            throw new \RuntimeException(
                'Unable to store documentation file.'
            );
        }

        return $document->files()->create([
            'locale' => $locale,
            'original_name' => $file->getClientOriginalName(),
            'file_name' => $fileName,
            'file_path' => $filePath,
            'mime_type' => $file->getMimeType()
                ?: 'application/pdf',
            'file_size' => $file->getSize() ?: 0,
        ]);
    }

    public function deleteFile(
        ProductDocumentFile $documentFile
    ): void {
        if (
            $documentFile->file_path &&
            Storage::disk('local')->exists(
                $documentFile->file_path
            )
        ) {
            Storage::disk('local')->delete(
                $documentFile->file_path
            );
        }

        $documentFile->delete();
    }

    public function deleteDocument(
        ProductDocument $document
    ): void {
        $document->loadMissing('files');

        foreach ($document->files as $file) {
            $this->deleteFile($file);
        }

        $document->delete();
    }

    public function deleteProduct(
        Product $product
    ): void {
        $product->load([
            'documents.files',
        ]);

        foreach ($product->documents as $document) {
            foreach ($document->files as $file) {
                if (
                    $file->file_path &&
                    Storage::disk('local')->exists(
                        $file->file_path
                    )
                ) {
                    Storage::disk('local')->delete(
                        $file->file_path
                    );
                }
            }
        }
    }
}