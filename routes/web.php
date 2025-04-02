<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('articles.index') : redirect()->route('login');
})->name('home');

Auth::routes(); // Menambahkan route auth untuk login, register, dan logout.

Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);
});

// Menampilkan halaman login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');

// Halaman dashboard user
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

// Admin Dashboard Route
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

