<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteChatController extends Controller
{
    public function AddToFavorite(Request $request)
    {
        $request->validate(['chat_id' => 'required|exists:chats,id']);
        Auth::guard('doctor')->user()->favoriteChats()->syncWithoutDetaching($request->chat_id);
        return response()->json(['status' => 'success', 'is_favorite' => true]);
    }

    public function removeFromFavorite(Request $request)
    {
        $request->validate(['chat_id' => 'required|exists:chats,id']);
        Auth::guard('doctor')->user()->favoriteChats()->detach($request->chat_id);
        return response()->json(['status' => 'success', 'is_favorite' => false]);
    }
}