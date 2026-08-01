<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerMiddleware;
use App\Http\Controllers\ContactsController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('contacts')->group(function () {
    
    Route::get('/phones', [ContactsController::class, 'phones']);
    Route::post('/phones', [ContactsController::class, 'addPhone']);
    Route::put('/phones/{phone}', [ContactsController::class, 'updatePhone']);
    Route::delete('/phones/{phone}', [ContactsController::class, 'deletePhone']);

    Route::get('/emails', [ContactsController::class, 'emails']);
    Route::post('/emails', [ContactsController::class, 'addEmail']);
    Route::put('/emails/{email}', [ContactsController::class, 'updateEmail']);
    Route::delete('/emails/{email}', [ContactsController::class, 'deleteEmail']);
    
    Route::get('/operating-hours', [ContactsController::class, 'operatingHours']);
    Route::post('/operating-hours', [ContactsController::class, 'addOperatingHours']);
    Route::put('/operating-hours/{operating_hour}', [ContactsController::class, 'updateOperatingHours']);
    Route::delete('/operating-hours/{operating_hour}', [ContactsController::class, 'deleteOperatingHours']);

    Route::get('/social-media', [ContactsController::class, 'socialMedia']);
    Route::get('/departments', [ContactsController::class, 'departments']);
});