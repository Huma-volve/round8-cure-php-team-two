<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class ChatController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();

        // جلب المحادثات مع آخر رسالة وعدد الرسائل غير المقروءة
        $chats = $doctor->chats()
            ->with(['user', 'lastMessage'])
            ->withCount(['messages as unread_messages_count' => fn($q) =>
            $q->where('seen', 0)->where('sender_type', '!=', Doctor::class)
            ])
            ->orderByDesc('last_message_at')
            ->get();

        // جلب المحادثات المفضلة
        $favChats = $doctor->favoriteChats()
            ->with(['user', 'lastMessage'])
            ->get();

        return view('doctor.chat.index', compact('chats', 'favChats'));
    }

    public function showChatMessages($id)
    {
        $doctor = Auth::guard('doctor')->user();
        $chat = $doctor->chats()->with('user')->findOrFail($id);

        // تعليم الرسائل كمقروءة
        $chat->messages()
            ->where('sender_type', '!=', Doctor::class)
            ->where('seen', 0)
            ->update(['seen' => 1]);

        // تجهيز الرسائل للـ JS
        $messages = $chat->messages()->oldest()->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'content' => $msg->content,
                'type' => $msg->type,
                'created_at' => $msg->created_at,
                // تحويل اسم الكلاس الطويل إلى كلمة بسيطة للـ JS
                'sender_type' => ($msg->sender_type === Doctor::class || $msg->sender_type == 'App\Models\Doctor') ? 'doctor' : 'user',
            ];
        });

        return response()->json([
            'data' => [
                'messages' => $messages,
                'user' => $chat->user
            ]
        ]);
    }
}