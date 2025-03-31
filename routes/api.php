<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:api, verify.token'])->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);

    // Routes yang memerlukan token JWT
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('categories', CategoryController::class);
});
