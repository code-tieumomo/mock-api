<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MockApiController;
use App\Models\MockApi;
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

    Route::get('/mock-apis/create', [MockApiController::class, 'create'])
        ->name('mock-apis.create')
        ->can('create', MockApi::class);
    Route::post('/mock-apis/generate', [MockApiController::class, 'generate'])
        ->name('mock-apis.generate')
        ->can('create', MockApi::class);
    Route::get('/mock-apis/{mockApi}/publish', [MockApiController::class, 'publish'])
        ->name('mock-apis.publish')
        ->can('publish', 'mockApi');
    Route::post('/mock-apis/{mockApi}/publish', [MockApiController::class, 'publishApi'])
        ->name('mock-apis.publish.store')
        ->can('publish', 'mockApi');
    Route::post('/mock-apis/{mockApi}/regenerate', [MockApiController::class, 'regenerate'])
        ->name('mock-apis.regenerate')
        ->can('update', 'mockApi');
    Route::put('/mock-apis/{mockApi}/reset', [MockApiController::class, 'reset'])
        ->name('mock-apis.reset')
        ->can('update', 'mockApi');
    Route::put('/mock-apis/{mockApi}/archive', [MockApiController::class, 'archive'])
        ->name('mock-apis.archive')
        ->can('delete', 'mockApi');
    Route::delete('/mock-apis/{mockApi}/delete', [MockApiController::class, 'delete'])
        ->name('mock-apis.delete')
        ->can('delete', 'mockApi');
    Route::get('/mock-apis/{mockApi}', [MockApiController::class, 'show'])
        ->name('mock-apis.show')
        ->can('view', 'mockApi');
    Route::put('/mock-apis/{mockApi}', [MockApiController::class, 'update'])
        ->name('mock-apis.update')
        ->can('update', 'mockApi');
});
