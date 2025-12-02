<?php

use App\Http\Controllers\Api\Chat\Room\ChatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::prefix('v1')->group(function () {

    Route::prefix('user')->middleware('auth:sanctum')->group(function () {

        Route::prefix('chats')->controller(ChatController::class)->group(function () {
            Route::get('/','FetchUserChats');
            Route::post('/','CreateOrFetchChat');
            Route::get('/{id}','FetchChatMessages');
        });
    });
});