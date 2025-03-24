<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MockApiController;
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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/mock-apis/create', [MockApiController::class, 'create'])->name('mock-apis.create');
    Route::post('/mock-apis/generate', [MockApiController::class, 'generate'])->name('mock-apis.generate');
});
