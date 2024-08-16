<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\VlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('vlogs', VlogController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::get('list/category', [CategoryController::class, 'list']);

    Route::get('latest-vlogs', [VlogController::class, 'getLatestVlogs']);
    Route::get('feature/{slug}', [CategoryController::class, 'getFeaturedVlogsByCategory']);

    Route::get('/video/{filename}', [VlogController::class, 'video']);
    Route::get('/thumbnail/{filename}', [VlogController::class, 'thumbnail']);

    Route::get('/', function() {
        return 'hello';
    })->domain('admin.' . env('APP_URL'));
});
