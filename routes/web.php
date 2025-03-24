<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::prefix('/auth')->group(function () {
        Route::get('/{provider}/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');
        Route::get('/{provider}/callback', [AuthController::class, 'callback'])->name('auth.callback');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
