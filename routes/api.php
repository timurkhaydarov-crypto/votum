<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DocumentationAccessController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FeaturesGalleryController;
use App\Http\Controllers\OperatingHourController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductCompatibilityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDocumentController;
use App\Http\Controllers\ProductDocumentFileController;
use App\Http\Controllers\ProductFeaturesController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductSpecificationController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user('sanctum');

    return $user ?? response('null', 200, ['Content-Type' => 'application/json']);
});

/*
|--------------------------------------------------------------------------
| Contacts
|--------------------------------------------------------------------------
*/

Route::prefix('contacts')->group(function () {
    Route::apiResource('phones', PhoneController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

    Route::apiResource('emails', EmailController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

    Route::apiResource('operating-hours', OperatingHourController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

    Route::apiResource('social-media', SocialMediaController::class)
        ->only([
            'index',
            'store',
            'update',
            'destroy',
        ]);

    Route::get(
        '/departments',
        [ContactsController::class, 'departments']
    );
});

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

Route::prefix('products')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Public catalog
    |--------------------------------------------------------------------------
    */

    Route::get(
        'menu',
        [ProductController::class, 'menu']
    );

    Route::get(
        'categories',
        [ProductController::class, 'categories']
    );

    Route::get(
        'groups',
        [ProductController::class, 'groups']
    );
    Route::get(
        'category/{category:slug}/group/{group:slug}',
        [ProductController::class, 'productsByGroup']
    )->withoutScopedBindings();

    Route::get(
        'category/{category:slug}',
        [ProductController::class, 'productsByCategory']
    );

    Route::get(
        'item',
        [ProductController::class, 'index']
    );
    Route::get(
        'item/{product}/compatibilities',
        [ProductCompatibilityController::class, 'index']
     );

    /*
    |--------------------------------------------------------------------------
    | Product management
    |--------------------------------------------------------------------------
    |
    | Только admin / manager.
    |
    */

    Route::middleware([
        'auth:sanctum',
        'manager',
    ])->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Product CRUD
        |--------------------------------------------------------------------------
        */

        Route::get(
            'item/create',
            [ProductController::class, 'create']
        );

        Route::get(
            'item/{product}/edit',
            [ProductController::class, 'edit']
        );

        Route::post(
            'item',
            [ProductController::class, 'store']
        );

        Route::put(
            'item/{product}',
            [ProductController::class, 'update']
        );

        Route::patch(
            'item/{product}',
            [ProductController::class, 'update']
        );

        Route::patch(
            'item/{product}/status',
            [ProductController::class, 'updateStatus']
        );

        Route::delete(
            'item/{product}',
            [ProductController::class, 'destroy']
        );

        Route::put(
            'item/{product}/details',
            [ProductController::class, 'updateDetails']
        );

        Route::put(
            'item/{product}/compatible',
            [ProductController::class, 'updateCompatible']
        );
        
        /*
        |--------------------------------------------------------------------------
        | Product compatibility management
        |--------------------------------------------------------------------------
        */
        Route::post(
            'item/{product}/compatibilities/{compatibleProduct}',
            [ ProductCompatibilityController::class, 'attach']
        );
        
        Route::delete(
            'item/{product}/compatibilities/{compatibleProduct}',
            [ ProductCompatibilityController::class, 'detach']
        );

        /*
        |--------------------------------------------------------------------------
        | Product certificates management
        |--------------------------------------------------------------------------
        */

        Route::get(
            'certificates',
            [CertificateController::class, 'index']
        );

        Route::get(
            'item/{product}/certificates',
            [CertificateController::class, 'productCertificates']
        );

        Route::post(
            'item/{product}/certificates/{certificate}',
            [CertificateController::class, 'attach']
        );

        Route::delete(
            'item/{product}/certificates/{certificate}',
            [CertificateController::class, 'detach']
        );

        Route::post(
            'item/{product}/certificates',
            [CertificateController::class, 'store']
        );

        Route::put('certificates/{certificate}', [CertificateController::class, 'update']);
        Route::delete('certificates/{certificate}', [CertificateController::class, 'destroy']);

        /*
        |--------------------------------------------------------------------------
        | Product gallery management
        |--------------------------------------------------------------------------
        */

        Route::post(
            'item/{product}/gallery',
            [ProductGalleryController::class, 'store']
        );

        Route::put(
            'item/{product}/gallery/{productGallery}',
            [ProductGalleryController::class, 'update']
        );

        Route::delete(
            'item/{product}/gallery/{productGallery}',
            [ProductGalleryController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Product features management
        |--------------------------------------------------------------------------
        */

        Route::post(
            'item/{product}/features',
            [ProductFeaturesController::class, 'store']
        );

        Route::put(
            'item/{product}/features',
            [ProductFeaturesController::class, 'update']
        );

        Route::delete(
            'item/{product}/features',
            [ProductFeaturesController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Product features gallery management
        |--------------------------------------------------------------------------
        */

        Route::post(
            'item/{product}/features/gallery',
            [FeaturesGalleryController::class, 'store']
        );

        Route::put(
            'item/{product}/features/gallery/{featuresGallery}',
            [FeaturesGalleryController::class, 'update']
        );

        Route::delete(
            'item/{product}/features/gallery/{featuresGallery}',
            [FeaturesGalleryController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Product specifications management
        |--------------------------------------------------------------------------
        */

        Route::get(
            'item/{product}/specifications',
            [ProductSpecificationController::class, 'index']
        );

        Route::post(
            'item/{product}/specifications',
            [ProductSpecificationController::class, 'store']
        );

        Route::get(
            'item/{product}/specifications/{productSpecification}',
            [ProductSpecificationController::class, 'show']
        );

        Route::put(
            'item/{product}/specifications/{productSpecification}',
            [ProductSpecificationController::class, 'update']
        );

        Route::delete(
            'item/{product}/specifications/{productSpecification}',
            [ProductSpecificationController::class, 'destroy']
        );
    });

    /*
    |--------------------------------------------------------------------------
    | Public product details
    |--------------------------------------------------------------------------
    */

    Route::get(
        'item/{product}',
        [ProductController::class, 'show']
    );

    Route::get(
        '{product}/features',
        [ProductFeaturesController::class, 'show']
    );

    Route::get(
        '{product}/specifications',
        [ProductSpecificationController::class, 'index']
    );
});

/*
|--------------------------------------------------------------------------
| Documentation management
|--------------------------------------------------------------------------
|
| Только admin / manager.
|
*/

Route::post(
    'documentation/access',
    [
        DocumentationAccessController::class,
        'access',
    ]
);

Route::get(
    'documentation/files/{productDocumentFile}/open',
    [
        ProductDocumentFileController::class,
        'open',
    ]
);

Route::prefix('documentation')
    ->middleware([
        'auth:sanctum',
        'manager',
    ])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Documentation users
        |--------------------------------------------------------------------------
        */

        Route::get(
            'users',
            [
                DocumentationAccessController::class,
                'users',
            ]
        );

        Route::get(
            'users/{user}/accesses',
            [
                DocumentationAccessController::class,
                'showAccesses',
            ]
        );

        Route::post(
            'users/{user}/key',
            [
                DocumentationAccessController::class,
                'rotateKey',
            ]
        );

        Route::delete(
            'users/{user}/key',
            [
                DocumentationAccessController::class,
                'revokeKey',
            ]
        );

        Route::post(
            'users/{user}/products/{product}',
            [
                DocumentationAccessController::class,
                'grantProduct',
            ]
        );

        Route::delete(
            'users/{user}/products/{product}',
            [
                DocumentationAccessController::class,
                'revokeProduct',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Product documents
        |--------------------------------------------------------------------------
        */

        Route::get(
            'products/{product}/documents',
            [
                ProductDocumentController::class,
                'index',
            ]
        );

        Route::post(
            'products/{product}/documents',
            [
                ProductDocumentController::class,
                'store',
            ]
        );

        Route::get(
            'products/{product}/documents/{productDocument}',
            [
                ProductDocumentController::class,
                'show',
            ]
        );

        Route::put(
            'products/{product}/documents/{productDocument}',
            [
                ProductDocumentController::class,
                'update',
            ]
        );

        Route::delete(
            'products/{product}/documents/{productDocument}',
            [
                ProductDocumentController::class,
                'destroy',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Product document files
        |--------------------------------------------------------------------------
        */

        Route::post(
            'documents/{productDocument}/files',
            [
                ProductDocumentFileController::class,
                'store',
            ]
        );

        Route::delete(
            'documents/{productDocument}/files/{productDocumentFile}',
            [
                ProductDocumentFileController::class,
                'destroy',
            ]
        );
    });

/*
|--------------------------------------------------------------------------
| Cart
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->group(function () {
    Route::get(
        '/',
        [CartController::class, 'index']
    );

    Route::post(
        '/items',
        [CartController::class, 'store']
    );

    Route::patch(
        '/items/{product}',
        [CartController::class, 'update']
    );

    Route::delete(
        '/items/{product}',
        [CartController::class, 'destroy']
    );

    Route::delete(
        '/',
        [CartController::class, 'clear']
    );
});

/*
|--------------------------------------------------------------------------
| Dealers
|--------------------------------------------------------------------------
*/

Route::get(
    '/dealers',
    [DealerController::class, 'index']
);

Route::get(
    '/dealers/{dealer}',
    [DealerController::class, 'show']
);

/*
|--------------------------------------------------------------------------
| Requests
|--------------------------------------------------------------------------
*/

Route::post(
    '/requests',
    [RequestController::class, 'store']
)->middleware('throttle:5,10');

Route::get(
    '/requests/{request}',
    [RequestController::class, 'show']
);

/*
|--------------------------------------------------------------------------
| Uploads
|--------------------------------------------------------------------------
*/

Route::prefix('uploads')
    ->middleware([
        'auth:sanctum',
        'manager',
    ])
    ->group(function () {

        Route::post(
            '/',
            [UploadController::class, 'store']
        );

        Route::delete(
            '/{token}',
            [UploadController::class, 'destroy']
        );
    });
