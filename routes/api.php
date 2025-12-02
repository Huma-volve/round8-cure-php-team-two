<?php

use App\Http\Controllers\Api\Chat\Favorite\FavoriteController;
use App\Http\Controllers\Api\Chat\Message\MessageController;
use App\Http\Controllers\Api\Chat\Room\ChatController;
use App\Http\Controllers\Api\Chat\Search\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::prefix('v1')->group(function () {

    Route::prefix('user')->middleware('auth:sanctum')->group(function () {
        //============================== Chats =================================//
        Route::prefix('chats')->controller(ChatController::class)->group(function () {
            Route::get('/','fetchUserChats');
            Route::post('/','createOrFetchChat');
            Route::get('/{id}','fetchChatMessages');
        });
        //============================== End Chats =================================//
        //==============================  Messages =================================//
        Route::controller(MessageController::class)->group(function () {
            Route::post('/','sendMessage');
            Route::get('chats/{id}/messages','getChatMessages');
            Route::patch('chats/{id}/messages-read-all','makeAllMessagesAsRead');
            Route::delete('chats/{id}/messages','deleteAllMessages');
            Route::delete('chat/{chatId}/message/{messageId}','deleteMessage');
        });
        //============================== End Messages =================================//
        //============================== Favorite Chats =================================//
        Route::prefix('favorites')->controller(FavoriteController::class)->group(function () {
            Route::get('/add/{chatId}','addToFavorite');
            Route::get('/remove/{chatId}','removeFromFavorite');
            Route::get('/chats','getFavoriteChats');
        });
        //============================== End Favorite Chats =================================//
        //============================== Search Chats =================================//
        Route::prefix('search')->controller(SearchController::class)->group(function () {
            Route::get('/',  'searchChats');
        });
        //============================== End Search Chats =================================//


    });

});