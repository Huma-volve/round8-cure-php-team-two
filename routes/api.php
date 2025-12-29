<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\Chat\Favorite\FavoriteController;
use App\Http\Controllers\Api\Chat\Message\MessageController;
use App\Http\Controllers\Api\Chat\Room\ChatController;
use App\Http\Controllers\Api\Chat\Search\SearchController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\User\PatientController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\NotificationController;
use Illuminate\Support\Facades\Route;
use Termwind\Components\Raw;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/otp/resend', [AuthController::class, 'resendOtp']);
    Route::post('/otp/verify', [AuthController::class, 'verifyOtp']);

    //Google OAuth Routes
    Route::get('/google/redirect', [AuthController::class, 'googleRedirect'])->middleware('web');
    Route::get('/google/callback', [AuthController::class, 'googleCallback'])->middleware('web');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/delete', [AuthController::class, 'deleteAccount']);
});


Route::middleware(('auth:sanctum'))->group(function () {
    Route::get('/patient/profile', [PatientController::class, 'show']);
    Route::put('/patient/profile', [PatientController::class, 'update']);
    Route::put('/patient/profile/password', [PatientController::class, 'updatePassword']);

});


Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index']);

    Route::get('/notifications/unread', [NotificationController::class, 'unread']);

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    Route::delete('/notifications', [NotificationController::class, 'destroyAll']);

});

Route::prefix("v1/reviews")->middleware("auth:sanctum")->group(function () {

    Route::post("/add", [ReviewController::class, "store"]);

    Route::get('/{review}', [ReviewController::class, 'get_review']);

    Route::delete('/delete/{id}', [ReviewController::class, 'destroy_review']);

    Route::put('/{id}/update', [ReviewController::class, 'update']);

    Route::get('/doctor/{doctor_id}', [ReviewController::class, 'get_reviews_to_doctor']);

   Route::get('doctors/top', [ReviewController::class, 'topDoctors']);
});


Route::prefix('v1')->group(function () {

    Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        //============================== Chats =================================//
        Route::prefix('chats')->controller(ChatController::class)->group(function () {
            Route::get('/', 'fetchUserChats');
            Route::post('/', 'createOrFetchChat');
        });
        //============================== End Chats =================================//
        //==============================  Messages =================================//
        Route::controller(MessageController::class)->group(function () {
            Route::post('chat/message', 'sendMessage');
            Route::get('chats/{id}/messages', 'getChatMessages');
            Route::patch('chats/{id}/messages-read-all', 'makeAllMessagesAsRead');
            Route::delete('chat/{id}/messages', 'deleteAllMessages');
            Route::delete('chat/{chatId}/message/{messageId}', 'deleteMessage');
        });
        //============================== End Messages =================================//
        //============================== Favorite Chats =================================//
        Route::prefix('favorites')->controller(FavoriteController::class)->group(function () {
            Route::get('/add/{chatId}', 'addToFavorite');
            Route::delete('/remove/{chatId}', 'removeFromFavorite');
            Route::get('/chats', 'getFavoriteChats');
        });
        //============================== End Favorite Chats =================================//
        //============================== Search Chats =================================//
        Route::prefix('search')->controller(SearchController::class)->group(function () {
            Route::get('/', 'searchChats');
        });
        //============================== End Search Chats =================================//


    });

});


Route::post('v1/contact-us', [ContactController::class, 'store']);
