<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OperatingHourController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\SocialMediaController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\ProductFeaturesController;
use App\Http\Controllers\ProductSpecificationController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
    | Catalog menu
    |--------------------------------------------------------------------------
    */

    Route::get(
        'menu',
        [ProductController::class, 'menu']
    );

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */

    Route::get(
        'categories',
        [ProductController::class, 'categories']
    );

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    */

    Route::get(
        'groups',
        [ProductController::class, 'groups']
    );

    /*
    |--------------------------------------------------------------------------
    | Products by category and group
    |--------------------------------------------------------------------------
    */

    Route::get(
        'category/{category:slug}/group/{group:slug}',
        [ProductController::class, 'productsByGroup']
    )->withoutScopedBindings();

    /*
    |--------------------------------------------------------------------------
    | Products by category
    |--------------------------------------------------------------------------
    */

    Route::get(
        'category/{category:slug}',
        [ProductController::class, 'productsByCategory']
    );

    /*
    |--------------------------------------------------------------------------
    | Product resource
    |--------------------------------------------------------------------------
    */

    Route::apiResource('item', ProductController::class)
        ->parameters([
            'item' => 'product',
        ])
        ->only([
            'index',
            'show',
            'store',
            'update',
            'destroy',
        ]);

    /*
    |--------------------------------------------------------------------------
    | Product features
    |--------------------------------------------------------------------------
    */

    Route::get(
        '{product}/features',
        [ProductFeaturesController::class, 'show']
    );
    Route::get(
        '{product}/specifications',
        [ProductSpecificationController::class, 'show']
    );
});