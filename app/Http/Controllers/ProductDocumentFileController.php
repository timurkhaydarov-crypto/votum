<?php

namespace App\Http\Controllers;

use App\Models\Product\ProductDocumentFile;
use App\Services\Documentation\DocumentationKeyService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductDocumentFileController extends Controller
{
    /**
     * Store a documentation PDF file.
     *
     * Manager-only action.
     */
    public function store(
        Request $request,
        \App\Models\Product\ProductDocument $productDocument,
        \App\Services\Documentation\ProductDocumentFileService $service
    ): \Illuminate\Http\JsonResponse {
        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:pdf',
                'max:51200',
            ],

            'locale' => [
                'required',
                'string',
                'in:ru,en',
            ],
        ]);

        $file = $service->store(
            $productDocument,
            $validated['file'],
            $validated['locale']
        );

        return response()->json(
            $file,
            201
        );
    }

    /**
     * Delete a documentation PDF file.
     *
     * Manager-only action.
     */
    public function destroy(
        Request $request,
        \App\Models\Product\ProductDocumentFile $productDocumentFile,
        \App\Services\Documentation\ProductDocumentFileService $service
    ): \Illuminate\Http\JsonResponse {
        $service->deleteFile(
            $productDocumentFile
        );

        return response()->json([
            'message' =>
                'Documentation file deleted successfully.',
        ]);
    }

    /**
     * Open protected documentation PDF.
     *
     * The ordinary user does not need to be authenticated.
     * Access is granted by X-Documentation-Key.
     */
    public function open(
        Request $request,
        ProductDocumentFile $productDocumentFile,
        DocumentationKeyService $service,
    ): Response {
        /*
        |--------------------------------------------------------------------------
        | Documentation key
        |--------------------------------------------------------------------------
        */

        $key = trim(
            (string) $request->header(
                'X-Documentation-Key'
            )
        );

        if ($key === '') {
            abort(
                401,
                'Ключ доступа не предоставлен.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve user by documentation key
        |--------------------------------------------------------------------------
        */

        $user = $service->resolveUser($key);

        if (! $user) {
            abort(
                401,
                'Неверный ключ доступа.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Load document and product
        |--------------------------------------------------------------------------
        */

        $document = $productDocumentFile
            ->document()
            ->with('product')
            ->first();

        if (
            ! $document ||
            ! $document->product
        ) {
            abort(
                404,
                'Документ не найден.'
            );
        }

        $product = $document->product;

        /*
        |--------------------------------------------------------------------------
        | Check access to this product
        |--------------------------------------------------------------------------
        */

        $access = $user
            ->documentationAccesses()
            ->where(
                'product_id',
                $product->id
            )
            ->first();

        if (
            ! $access ||
            ! $access->isValid()
        ) {
            abort(
                403,
                'Ключ не предоставляет доступ к документации этого продукта.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Check physical PDF
        |--------------------------------------------------------------------------
        */

        $disk = Storage::disk('local');

        if (
            ! $productDocumentFile->file_path ||
            ! $disk->exists(
                $productDocumentFile->file_path
            )
        ) {
            abort(
                404,
                'Файл документации не найден.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update last access time
        |--------------------------------------------------------------------------
        */

        $access->forceFill([
            'last_accessed_at' => now(),
        ])->save();

        /*
        |--------------------------------------------------------------------------
        | Return PDF
        |--------------------------------------------------------------------------
        */

        $fileName = addslashes(
            $productDocumentFile->original_name
                ?: $productDocumentFile->file_name
        );

        return response(
            $disk->get(
                $productDocumentFile->file_path
            ),
            200,
            [
                'Content-Type' =>
                    'application/pdf',

                'Content-Disposition' =>
                    'inline; filename="' .
                    $fileName .
                    '"',

                'Content-Length' =>
                    $disk->size(
                        $productDocumentFile->file_path
                    ),

                'Cache-Control' =>
                    'private, no-store, no-cache, must-revalidate',

                'Pragma' =>
                    'no-cache',

                'X-Content-Type-Options' =>
                    'nosniff',
            ]
        );
    }
}
