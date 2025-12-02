<?php

use App\Http\Controllers\Api\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::post("reviews/add", [ReviewController::class, "store"]);
Route::get('reviews/{review}', [ReviewController::class, 'get_review']);
Route::delete('/reviews/delete/{id}', [ReviewController::class, 'destroy_review']);
Route::put('/reviews/{id}/update', [ReviewController::class, 'update']);

Route::get('/doctors/{doctor_id}/reviews', [ReviewController::class, 'get_reviews_to_doctor']);

