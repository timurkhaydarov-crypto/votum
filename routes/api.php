<?php

use App\Http\Controllers\ContactsController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\OperatingHourController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\SocialMediaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('contacts')->group(function () {
    Route::apiResource('phones', PhoneController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('emails', EmailController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('operating-hours', OperatingHourController::class)
        ->only(['index', 'store', 'update', 'destroy']);
    Route::apiResource('social-media', SocialMediaController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::get('/departments', [ContactsController::class, 'departments']);
});
