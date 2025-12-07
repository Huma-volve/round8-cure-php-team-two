<?php


use App\Modules\Booking\Controllers\BookingController;

Route::prefix('appointments')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
         Route::post('/book', [BookingController::class, 'book']);
         Route::get('/my-bookings', [BookingController::class, 'myBookings']);
         Route::post('/{id}/cancel', [BookingController::class, 'cancel']);
         Route::post('/{id}/reschedule', [BookingController::class, 'reschedule']);
    });
});


