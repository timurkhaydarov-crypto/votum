<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DocumentationPortalController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureDocumentationAccess;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index']);

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])
        ->middleware('guest')
        ->name('login');

    Route::post('/login', LoginController::class);

    Route::get('/register', [AuthController::class, 'register'])
        ->middleware(['auth', AdminMiddleware::class]);

    Route::post('/register', RegisterController::class);

    Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::post('/logout', LogoutController::class)
        ->middleware('auth');
});

Route::prefix('documentation')
    ->group(function () {
        /*
        |--------------------------------------------------------------------------
        | Enter by personal documentation key
        |--------------------------------------------------------------------------
        */

        Route::get(
            '{key}',
            [
                DocumentationPortalController::class,
                'enter',
            ]
        )->middleware('throttle:10,1');

        /*
        |--------------------------------------------------------------------------
        | Authenticated documentation session
        |--------------------------------------------------------------------------
        */

        Route::get(
            '',
            [
                DocumentationPortalController::class,
                'products',
            ]
        )->middleware(
            EnsureDocumentationAccess::class
        );

        Route::get(
            'products/{product}/documents',
            [
                DocumentationPortalController::class,
                'documents',
            ]
        )->middleware(
            EnsureDocumentationAccess::class
        );

        Route::get(
            'products/{product}/documents/{productDocument}/files/{productDocumentFile}',
            [
                DocumentationPortalController::class,
                'file',
            ]
        )->middleware(
            EnsureDocumentationAccess::class
        );
    });
Route::get('/{any?}', [AuthController::class, 'index'])
    ->where('any', '.*');
