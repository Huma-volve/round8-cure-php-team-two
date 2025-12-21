<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dashboard\Doctor\DoctorSummary;
use App\Http\Controllers\Dashboard\Doctor\DoctorTimesController;
use App\Http\Controllers\Dashboard\Doctor\Booking\DoctorAppointmentDashboardController;
use App\Http\Controllers\Dashboard\Doctor\DoctorProfileController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:doctor'])
    ->prefix('doctor/dashboard')
    ->name('doctor.')
    ->group(function () {

        Route::get('/', [DoctorSummary::class, 'index'])->name('dashboard');

        Route::get('/set-password', [AuthController::class, 'set_password_page'])->name('set-password.show');
        Route::post('/set-password', [AuthController::class, 'set_password'])->name('set-password.store');

        Route::get('/time', [DoctorTimesController::class, 'index'])->name('times.index');
        Route::get('/time/create', [DoctorTimesController::class, 'create'])->name('times.create');
        Route::post('/time', [DoctorTimesController::class, 'store'])->name('times.store');
        Route::delete('/time/{time}', [DoctorTimesController::class, 'destroy'])->name('times.destroy');
        Route::get('/time/{time}/edit', [DoctorTimesController::class, 'edit'])
            ->name('times.edit');

        Route::put('/time/{time}', [DoctorTimesController::class, 'update'])
            ->name('times.update');

        Route::get('/appointments', [DoctorAppointmentDashboardController::class, 'index'])->name('appointments.index');
        Route::post('/appointments/{appointment}/reschedule', [DoctorAppointmentDashboardController::class, 'reschedule'])->name('appointments.reschedule');
        Route::post('/appointments/{appointment}/cancel', [DoctorAppointmentDashboardController::class, 'cancel'])->name('appointments.cancel');
        Route::post('/appointments/{appointment}/status', [DoctorAppointmentDashboardController::class, 'updateStatus'])->name('appointments.status');

        Route::get('/profile', [DoctorProfileController::class, 'showProfile'])->name('profile.show');

        Route::put('/profile', [DoctorProfileController::class, 'updateProfile'])->name('profile.update');

        Route::get('/reports', [DoctorDashboardController::class, 'index'])->name('dashboard.reports');
    });
