<?php

use App\Http\Controllers\Dashboard\Doctor\Booking\DoctorAppointmentDashboardController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:doctor'])->prefix('doctor/dashboard')->name('doctor.')->group(function () {
    Route::get('/appointments', [DoctorAppointmentDashboardController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{appointment}/cancel', [DoctorAppointmentDashboardController::class, 'cancel'])->name('appointments.cancel');
    Route::post('/appointments/{appointment}/reschedule', [DoctorAppointmentDashboardController::class, 'reschedule'])->name('appointments.reschedule');
    Route::post('/appointments/{appointment}/status', [DoctorAppointmentDashboardController::class, 'updateStatus'])->name('appointments.status');

    Route::get('/profile', [App\Http\Controllers\DoctorController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\DoctorController::class, 'updateProfile'])->name('profile.update');

    Route::get('/reports', [DoctorDashboardController::class, 'index'])->name('dashboard.reports');

});
