<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

Route::get('/', [AuthController::class, 'index']);

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::post('/login', LoginController::class);
        
    Route::get('/register', [AuthController::class, 'register'])->middleware(['auth', AdminMiddleware::class]);
    Route::post('/register', RegisterController::class);
    
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/logout', LogoutController::class)->middleware('auth');
});