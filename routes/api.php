<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

// API login dan register
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

// API routes yang memerlukan otentikasi menggunakan JWT
Route::middleware(['auth:api', 'verify.token.cookie'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('categories', CategoryController::class);
});
