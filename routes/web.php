<?php

use Illuminate\Support\Facades\Route;
 
Route::get('/', function () {
    return view('index');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', function () {
        return view('index');
    });
    Route::get('/register', function () {
        return view('index');
    });
    Route::get('/forgot-password', function () {
        return view('index');
    });
});