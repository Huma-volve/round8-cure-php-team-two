<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\Chat\Favorite\FavoriteController;
use App\Http\Controllers\Api\Chat\Message\MessageController;
use App\Http\Controllers\Api\Chat\Room\ChatController;
use App\Http\Controllers\Api\Chat\Search\SearchController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('otp/send', [AuthController::class, 'sendOtp']);
    Route::post('otp/verify', [AuthController::class, 'verifyOtp']);

    //Google OAuth Routes
    Route::get('google/redirect', [AuthController::class, 'googleRedirect'])->middleware('web');
    Route::get('google/callback', [AuthController::class, 'googleCallback'])->middleware('web');
});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::post('auth/delete', [AuthController::class, 'deleteAccount']);
});


Route::post("reviews/add", [ReviewController::class, "store"]);
Route::get('reviews/{review}', [ReviewController::class, 'get_review']);
Route::delete('/reviews/delete/{id}', [ReviewController::class, 'destroy_review']);
Route::put('/reviews/{id}/update', [ReviewController::class, 'update']);

Route::get('/doctors/{doctor_id}/reviews', [ReviewController::class, 'get_reviews_to_doctor']);

Route::prefix('v1')->group(function () {

    Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        //============================== Chats =================================//
        Route::prefix('chats')->controller(ChatController::class)->group(function () {
            Route::get('/', 'fetchUserChats');
            Route::post('/', 'createOrFetchChat');
            Route::get('/{id}', 'fetchChatMessages');
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
            Route::get('/remove/{chatId}', 'removeFromFavorite');
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
