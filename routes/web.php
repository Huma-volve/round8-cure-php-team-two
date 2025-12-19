<?php

use App\Http\Controllers\Dashboard\Doctor\Chat\ChatController;
use App\Http\Controllers\Dashboard\Doctor\Chat\FavoriteChatController;
use App\Http\Controllers\Dashboard\Doctor\Chat\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layouts.dashboard.app');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Admin Dashboard Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/doctor/create', [App\Http\Controllers\AdminController::class, 'createDoctor'])->name('doctor.create');
    Route::get('/doctor', [App\Http\Controllers\AdminController::class, 'listDoctors'])->name('doctor.index');
    Route::delete('/doctor/destroy/{doctor}', [App\Http\Controllers\AdminController::class, 'deleteDoctor'])->name('doctor.destroy');
    Route::post('/doctor/store', [App\Http\Controllers\AdminController::class, 'storeDoctor'])->name('doctor.store');
});

// Doctor Dashboard Routes
Route::middleware(['auth:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [App\Http\Controllers\DoctorController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\DoctorController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/appointment/{id}', [App\Http\Controllers\DoctorController::class, 'updateAppointmentStatus'])->name('appointment.update');

});

//Route::middleware(['auth', 'role:doctor'])->group(function () {
//    Route::get('/doctor/dashboard', [DoctorDashboardController::class, 'index'])
//        ->name('doctor.dashboard');
//});


Route::prefix('chat')->middleware('auth:doctor')->name('doctor.chat.')->group(function () {
    Route::get('/', [ChatController::class, 'index'])->name('index');
    Route::get('/{id}/messages', [ChatController::class, 'showChatMessages'])->name('messages.show');
    Route::post('/{id}/message', [MessageController::class, 'store'])->name('messages.store');

    // Favorites
    Route::post('/favorite/add', [FavoriteChatController::class, 'AddToFavorite'])->name('favorite.add');
    Route::post('/favorite/remove', [FavoriteChatController::class, 'removeFromFavorite'])->name('favorite.remove');
});