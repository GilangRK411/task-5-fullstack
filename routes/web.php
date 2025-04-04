<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

// Redirect '/' ke dashboard jika login, jika tidak maka ke login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('home') : redirect()->route('login');
})->name('home');

// Menyediakan route login, register, logout (bawaan Laravel)
Auth::routes();

// Middleware untuk user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('articles', ArticleController::class);

    // Dashboard user
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

// Middleware khusus admin
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

