<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\VlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;

Route::prefix('v1')->group(function () {
    Route::apiResource('vlogs', VlogController::class);
    Route::apiResource('categories', CategoryController::class);


    Route::get('latest-vlogs', [VlogController::class, 'getLatestVlogs']);
    Route::get('feature/{slug}', [CategoryController::class, 'getFeaturedVlogsByCategory']);

    Route::get('/video/{filename}', [VlogController::class, 'video'])->name('video');
    Route::get('/thumbnail/{filename}', [VlogController::class, 'thumbnail'])->name('thumbnail');

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('list/category', [CategoryController::class, 'list']);
        Route::post('/validate-token', [AuthController::class, 'validateToken']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
