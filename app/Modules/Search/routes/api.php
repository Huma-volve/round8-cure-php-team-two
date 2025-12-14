<?php

use App\Modules\Search\Controllers\SearchController;

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('search')->group(function () {
       Route::post('/', [SearchController::class, 'search']);
       Route::get('/history', [SearchController::class, 'history']);
       Route::post('/history/clear', [SearchController::class, 'clearHistory']);
       Route::get('/all-doctors', [SearchController::class, 'allDoctors']);
    });
});
