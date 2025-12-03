<?php

namespace App\Http\Controllers\Api\Chat\Favorite;

use App\Http\Controllers\Controller;
use App\Models\Chat;

class FavoriteController extends Controller
{

    public function getFavoriteChats()
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }
        $favoriteChats = $auth->favoriteChats()->with('doctor')->get();
        return apiResponse(200, 'success', $favoriteChats);
    }

    public function addToFavorite($id)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = Chat::find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }
        if ($chat->user_id != $auth->id) {
            return apiResponse(401, 'unauthorized');
        }
        $auth->favoriteChats()->syncWithoutDetaching($id);
        return apiResponse(200, 'Chat added to favorites');
    }

    public function removeFromFavorite($id)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $auth->favoriteChats()->detach($id);
        return apiResponse(200, 'Chat added to favorites');
    }
}
