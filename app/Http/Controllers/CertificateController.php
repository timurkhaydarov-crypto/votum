<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\CertificateRequest;
use App\Models\Product\Certificate;
use App\Models\Product\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class CertificateController extends Controller
{
    /**
     * List all certificates.
     *
     * Supports searching in both RU and EN titles.
     */
    public function index(Request $request): JsonResponse
    {
        $search = trim(
            (string) $request->query('search', '')
        );

        $certificates = Certificate::query()
            ->when(
                $search !== '',
                function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->whereRaw(
                                "title->>'ru' ILIKE ?",
                                ["%{$search}%"]
                            )
                            ->orWhereRaw(
                                "title->>'en' ILIKE ?",
                                ["%{$search}%"]
                            );
                    });
                }
            )
            ->withCount('products')
            ->orderBy('id')
            ->get();

        return response()->json(
            $certificates
                ->map(
                    fn (Certificate $certificate) => $this->serializeCertificate(
                        $certificate
                    )
                )
                ->values()
                ->all()
        );
    }

    /**
     * Return certificates attached to a product.
     */
    public function productCertificates(
        Product $product
    ): JsonResponse {
        $certificates = $product
            ->certificates()
            ->withCount('products')
            ->orderBy('id')
            ->get();

        return response()->json(
            $certificates
                ->map(
                    fn (Certificate $certificate) => $this->serializeCertificate(
                        $certificate
                    )
                )
                ->values()
                ->all()
        );
    }

    /**
     * Attach certificate to product.
     */
    public function attach(
        Product $product,
        Certificate $certificate
    ): JsonResponse {
        $product
            ->certificates()
            ->syncWithoutDetaching([
                $certificate->id,
            ]);

        return response()->json([
            'message' => 'Certificate attached successfully.',

            'certificate' => $this->serializeCertificate(
                $certificate->fresh()
            ),
        ]);
    }

    /**
     * Detach certificate from product.
     *
     * The certificate itself remains in the global list.
     */
    public function detach(
        Product $product,
        Certificate $certificate
    ): JsonResponse {
        $product
            ->certificates()
            ->detach([
                $certificate->id,
            ]);

        return response()->json([
            'message' => 'Certificate detached successfully.',
        ]);
    }

    /**
     * Store a new certificate and attach it
     * automatically to the current product.
     */
    public function store(
        CertificateRequest $request,
        Product $product
    ): JsonResponse {
        $validated = $request->validated();

        $certificate = DB::transaction(
            function () use (
                $validated,
                $request,
                $product
            ) {
                $imageName = $this->storeImage(
                    $request->file('image')
                );

                $certificate = Certificate::create([
                    'title' => $validated['title'],

                    'description' => $validated['description']
                        ?? null,

                    'image_url' => $imageName,
                ]);

                $product
                    ->certificates()
                    ->syncWithoutDetaching([
                        $certificate->id,
                    ]);

                return $certificate;
            }
        );

        $certificate->loadCount('products');

        return response()->json(
            [
                'message' => 'Certificate created successfully.',

                'certificate' => $this->serializeCertificate(
                    $certificate
                ),
            ],
            201
        );
    }

    /**
     * Update an existing certificate.
     *
     * Image is optional.
     */
    public function update(
        CertificateRequest $request,
        Certificate $certificate
    ): JsonResponse {
        $validated = $request->validated();

        DB::transaction(
            function () use (
                $validated,
                $request,
                $certificate
            ) {
                $oldImageName =
                    $certificate->image_url;

                $newImageName = null;

                if (
                    $request->hasFile('image')
                ) {
                    $newImageName =
                        $this->storeImage(
                            $request->file('image')
                        );
                }

                $certificate->update([
                    'title' => $validated['title'],

                    'description' => $validated['description']
                        ?? null,

                    'image_url' => $newImageName
                        ?? $oldImageName,
                ]);

                /*
                 * Remove old image only after the
                 * database update has succeeded.
                 */
                if (
                    $newImageName &&
                    $oldImageName &&
                    $newImageName !==
                        $oldImageName
                ) {
                    $this->deleteImage(
                        $oldImageName
                    );
                }
            }
        );

        $certificate
            ->refresh()
            ->loadCount('products');

        return response()->json([
            'message' => 'Certificate updated successfully.',

            'certificate' => $this->serializeCertificate(
                $certificate
            ),
        ]);
    }

    /**
     * Delete certificate globally.
     *
     * The certificate is removed from:
     * - certificates
     * - product_certificates
     * - certificate image
     * - certificate thumbnail
     */
    public function destroy(
        Certificate $certificate
    ): JsonResponse {
        DB::transaction(
            function () use ($certificate) {
                $imageName =
                    $certificate->image_url;

                /*
                 * Explicitly detach first.
                 * This also works regardless of
                 * foreign-key cascade configuration.
                 */
                $certificate
                    ->products()
                    ->detach();

                $certificate->delete();

                if ($imageName) {
                    $this->deleteImage(
                        $imageName
                    );
                }
            }
        );

        return response()->json([
            'message' => 'Certificate deleted successfully.',
        ]);
    }

    /**
     * Store certificate image as WebP.
     *
     * Returns only the generated filename.
     */
    protected function storeImage(
        $file
    ): string {
        if (! $file) {
            throw new \InvalidArgumentException(
                'Certificate image is required.'
            );
        }

        $baseName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $baseName = Str::slug(
            $baseName
        );

        if ($baseName === '') {
            $baseName = 'certificate';
        }

        $imageName =
            $baseName
            .'-'
            .Str::lower(
                Str::random(7)
            );

        $directory =
            public_path(
                'image/certificates'
            );

        $thumbnailDirectory =
            public_path(
                'image/certificates/thumbnails'
            );

        File::ensureDirectoryExists(
            $directory
        );

        File::ensureDirectoryExists(
            $thumbnailDirectory
        );

        $manager =
            new ImageManager(
                new Driver
            );

        $image =
            $manager->read(
                $file->getRealPath()
            );

        $image->toWebp(
            90
        )->save(
            $directory
            .DIRECTORY_SEPARATOR
            .$imageName
            .'.webp'
        );

        /*
         * Thumbnail.
         *
         * The original aspect ratio is preserved.
         */
        $thumbnail =
            $manager->read(
                $file->getRealPath()
            );

        $thumbnail
            ->scaleDown(
                width: 600
            )
            ->toWebp(
                85
            )
            ->save(
                $thumbnailDirectory
                .DIRECTORY_SEPARATOR
                .$imageName
                .'.webp'
            );

        return $imageName;
    }

    /**
     * Delete certificate image and thumbnail.
     */
    protected function deleteImage(
        ?string $imageName
    ): void {
        if (! $imageName) {
            return;
        }

        $imagePath =
            public_path(
                'image/certificates/'
                .$imageName
                .'.webp'
            );

        $thumbnailPath =
            public_path(
                'image/certificates/thumbnails/'
                .$imageName
                .'.webp'
            );

        if (
            File::exists(
                $imagePath
            )
        ) {
            File::delete(
                $imagePath
            );
        }

        if (
            File::exists(
                $thumbnailPath
            )
        ) {
            File::delete(
                $thumbnailPath
            );
        }
    }

    /**
     * Serialize certificate for API.
     */
    protected function serializeCertificate(
        Certificate $certificate
    ): array {
        return [
            'id' => $certificate->id,

            'title' => $certificate->title,

            'description' => $certificate->description,

            'image_url' => $certificate->image_url,

            'image' => $certificate->image_url
                    ? '/image/certificates/'
                        .$certificate->image_url
                        .'.webp'
                    : null,

            'thumbnail' => $certificate->image_url
                    ? '/image/certificates/thumbnails/'
                        .$certificate->image_url
                        .'.webp'
                    : null,

            'products_count' => $certificate->products_count
                ?? null,
        ];
    }
}
