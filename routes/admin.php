<?php

use App\Http\Controllers\Dashboard\Admin\Booking\AdminBookingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin'])->prefix('admin/dashboard')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{appointment}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::get('/doctor/create', [App\Http\Controllers\AdminController::class, 'createDoctor'])->name('doctor.create');
    Route::get('/doctor', [App\Http\Controllers\AdminController::class, 'listDoctors'])->name('doctor.index');
    Route::delete('/doctor/destroy/{doctor}', [App\Http\Controllers\AdminController::class, 'deleteDoctor'])->name('doctor.destroy');
    Route::post('/doctor/store', [App\Http\Controllers\AdminController::class, 'storeDoctor'])->name('doctor.store');
});
