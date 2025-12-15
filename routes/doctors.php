<?php

use App\Http\Controllers\Dashboard\Doctor\Booking\DoctorAppointmentDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:doctor'])->prefix('doctor/dashboard')->group(function () {
    Route::get('/appointments', [DoctorAppointmentDashboardController::class, 'index'])->name('doctor.appointments');
    Route::post('/appointments/{appointment}/cancel', [DoctorAppointmentDashboardController::class, 'cancel'])->name('doctor.appointments.cancel');
    Route::post('/appointments/{appointment}/reschedule', [DoctorAppointmentDashboardController::class, 'reschedule'])->name('doctor.appointments.reschedule');
    Route::post('/appointments/{appointment}/status', [DoctorAppointmentDashboardController::class, 'updateStatus'])->name('doctor.appointments.status');
});
