<?php

use App\Http\Controllers\Dashboard\Doctor\Chat\ChatController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NotificationController;
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


require __DIR__ . '/doctors.php';
require __DIR__ . '/admin.php';

Route::middleware(['auth:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/unreadnotifications', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::get('/markAsReadnotifications/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/markAllAsReadnotifications/{id}', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/destroyAll', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

    Route::get("/patientdetails/{id}",[DoctorController::class,"patientdetails"]);

});

// ================================= Doctor Chat =================================================//
Route::controller(ChatController::class)->group(function () {
    Route::get('/chats', 'index')->name('chats.index');
    Route::get('/chats/{id}', 'showChatMessages')->name('chat.messages.show');
});

// ================================= End Doctor Chat =================================================//
