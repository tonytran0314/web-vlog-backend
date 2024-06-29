<?php

use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\api\v1\VlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('vlogs', VlogController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::get('latest-vlogs', [VlogController::class, 'getLatestVlogs']);
    Route::get('feature/{slug}', [CategoryController::class, 'getFeaturedVlogsByCategory']);

    Route::get('/', function() {
        return 'hello';
    })->domain('admin.' . env('APP_URL'));
});
