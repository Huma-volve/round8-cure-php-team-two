<?php

namespace App\Http\Controllers\Api\Chat\Favorite;

use App\Http\Controllers\Controller;
use App\Http\Resources\Chat\Room\RoomCollection;
use App\Http\Resources\Chat\Room\RoomResource;

class FavoriteController extends Controller
{

    public function getFavoriteChats()
    {
        $perPage = request('per_page', 10);
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }
        $favoriteChats = $auth->favoriteChats()->with('doctor')->paginate($perPage);
        return apiResponse(200, 'success', (new RoomCollection($favoriteChats))->response()->getData(true));
    }

    public function addToFavorite($id)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        if ($auth->favoriteChats()->where('chat_id', $chat->id)->exists()) {
            return apiResponse(400, 'chat already in favorites');
        }

        $auth->favoriteChats()->syncWithoutDetaching([
            $chat->id => [
                'user_id' => $auth->id,
                'doctor_id' => $chat->doctor_id
            ]
        ]);
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
        return apiResponse(200, 'Chat remove from favorites');
    }
}
