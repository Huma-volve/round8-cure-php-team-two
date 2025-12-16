<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteChatController extends Controller
{
    public function AddToFavorite(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
        ]);

        $chat = Auth::guard('doctor')->user()->chats()->findOrFail($request->chat_id);

        // FIX: Changed condition from !exists() to exists()
        if (Auth::guard('doctor')->user()->favoriteChats()->where('chat_id', $request->chat_id)->exists()) {
            return response()->json(['message' => 'Chat already in favorites'], 400);
        }

        Auth::guard('doctor')->user()->favoriteChats()->syncWithoutDetaching($chat->id);

        return response()->json([
            'message' => 'Chat added to favorites',
            'chat_id' => $chat->id
        ], 200);
    }

    public function removeFromFavorite(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
        ]);

        $removed = Auth::guard('doctor')->user()->favoriteChats()->detach($request->chat_id);

        if ($removed) {
            return response()->json(['message' => 'Chat removed from favorites'], 200);
        }

        return response()->json(['message' => 'Chat not found in favorites'], 404);
    }
}
