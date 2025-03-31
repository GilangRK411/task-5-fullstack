<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;

// Authentication Routes
Auth::routes();

// Halaman Utama (Redirect ke Artikel atau Login)
Route::get('/', function () {
    return auth()->check() ? redirect()->route('articles.index') : redirect()->route('login');
})->name('home');

// Group Route dengan Middleware Auth
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
});

// Home Route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Admin Dashboard Route with Auth & Admin Middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
