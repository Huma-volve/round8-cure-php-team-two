<?php

use App\Modules\Favorites\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites-toggle/{doctor}', [FavoriteController::class, 'toggle']);
});
