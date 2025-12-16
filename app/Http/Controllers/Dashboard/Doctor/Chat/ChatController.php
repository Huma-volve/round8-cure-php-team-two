<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Auth::guard('doctor')->user()
            ->chats()->with(['lastMessage', 'messages', 'user' => fn($q) => $q->select('id', 'name', 'image')])
            ->withCount(['messages as unread_messages_count' => fn($q) => $q->where('seen', 0)])
            ->get();


        $favChats = Auth::guard('doctor')->user()->favoriteChats()
            ->with(['user' => fn($q) => $q->select('id', 'name', 'image'), 'lastMessage'])
            ->withCount(['messages as unread_messages_count' => fn($q) => $q->where('seen', 0)])
            ->get();

        return view('doctor.chat.index', compact('chats', 'favChats'));
    }

    public function showChatMessages($id)
    {
        $chat = Auth::guard('doctor')->user()
            ->chats()->with(['messages', 'user' => fn($q) => $q->select('id', 'name', 'image')])
            ->findOrFail($id);

            $chat->messages()->where('seen', 0)->update(['seen' => 1]);
        if (!$chat) {
            return response()->json(['message' => 'Chat not found'], 404);
        }

        return response()->json([
            'data' => $chat
        ]);
    }
}
