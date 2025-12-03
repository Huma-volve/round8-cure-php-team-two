<?php

use App\Modules\Home\Controllers\DoctorDetailsController;
use App\Modules\Home\Controllers\DoctorsNearYouController;
use App\Modules\Home\Controllers\SpecialtiesController;
use Illuminate\Support\Facades\Route;

Route::prefix('home')->group(function () {
    Route::get('/specialties', [SpecialtiesController::class, 'index']);
    Route::get('/all-near-you-doctors', [DoctorsNearYouController::class, 'allDoctors']);
    Route::post('/doctors_near_you', [DoctorsNearYouController::class, 'doctorsNearYou']);
});

Route::get('/doctors/{id}', [DoctorDetailsController::class, 'show']);
