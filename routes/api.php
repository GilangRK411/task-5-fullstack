<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

// Rute untuk register dan login
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']); // Rute login hanya untuk API

// Middleware untuk autentikasi dan validasi token
Route::middleware(['auth:api', 'verify.token'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']); // Logout API route
    Route::apiResource('articles', ArticleController::class);  // Resource articles
    Route::apiResource('categories', CategoryController::class); // Resource categories
});
