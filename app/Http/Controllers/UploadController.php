<?php

namespace App\Http\Controllers;

use App\Http\Requests\Upload\StoreUploadRequest;
use App\Services\TemporaryUploadService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UploadController extends Controller
{
    /**
     * Store an uploaded file temporarily.
     */
    public function store(
        StoreUploadRequest $request,
        TemporaryUploadService $uploadService
    ): JsonResponse {
        $upload = $uploadService->store(
            $request->file('file')
        );

        return response()->json(
            [
                'upload' => [
                    'token' =>
                        $upload['token'],

                    'type' =>
                        $request->string('type')->toString(),

                    'original_name' =>
                        $upload['original_name'],

                    'mime_type' =>
                        $upload['mime_type'],

                    'size' =>
                        $upload['size'],
                ],
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Delete a temporary uploaded file.
     */
    public function destroy(
        string $token,
        TemporaryUploadService $uploadService
    ): JsonResponse {
        $deleted = $uploadService->delete(
            $token
        );

        if (! $deleted) {
            return response()->json(
                [
                    'message' =>
                        'Temporary upload not found.',
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'message' =>
                'Temporary upload deleted successfully.',
        ]);
    }
}