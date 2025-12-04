<?php


use App\Modules\Booking\Controllers\BookingController;

//Route::middleware('auth:sanctum')->group(function () {
    Route::post('appointments/book', [BookingController::class, 'book']);
//});
