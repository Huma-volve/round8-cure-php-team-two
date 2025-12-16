<?php

use App\Http\Controllers\Dashboard\Admin\Booking\AdminBookingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->prefix('admin/dashboard')->name('admin.')->group(function () {
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{appointment}', [AdminBookingController::class, 'show'])->name('bookings.show');
    });
