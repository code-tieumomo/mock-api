<?php

use App\Http\Controllers\MockApiController;
use App\Http\Middleware\CaptureMockApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/{providerId}/{prefix}', [MockApiController::class, 'apiIndex'])
    ->middleware(CaptureMockApiRequest::class . ':LIST');