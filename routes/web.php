<?php

use App\Http\Controllers\admin\AdminDashboardController;
use App\Http\Controllers\Dashboard\Doctor\Chat\ChatController;

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Doctor\DoctorDashboardController;

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
require __DIR__ . '/doctors.php';
require __DIR__ . '/admin.php';


Route::middleware(['auth:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/unreadnotifications', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::post('/markAsReadnotifications/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/markAllAsReadnotifications', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/destroyAll', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    Route::get('/all', [NotificationController::class, 'All'])->name('notifications.all');


    Route::get("/patientdetails/{id}",[DoctorController::class,"patientdetails"]) ->name('patientdetails');

});


// ================================= Doctor Chat =================================================//
Route::controller(ChatController::class)->group(function () {
    Route::get('/chats', 'index')->name('chats.index');
    Route::get('/chats/{id}', 'showChatMessages')->name('chat.messages.show');
});

// ================================= End Doctor Chat =================================================//


