<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;

class MessageController extends Controller
{
    public function store(Request $request, $id)
    {
        // التحقق من البيانات
        $request->validate([
            'content' => 'required_if:type,text',
            'type' => 'required|in:text,image,audio,video',
        ]);

        $doctor = Auth::guard('doctor')->user();
        $chat = $doctor->chats()->findOrFail($id);
        $content = $request->content;

        // معالجة رفع الملفات (صور، فيديو، صوت)
        if ($request->type !== 'text' && $request->hasFile('content')) {
            $file = $request->file('content');
            $path = $file->store('chat_attachments', 'public');
            $content = asset('storage/' . $path);
        }

        // إنشاء الرسالة
        $message = $chat->messages()->create([
            'chat_id' => $chat->id,
            'type' => $request->type,
            'sender_type' => Doctor::class, // التخزين باسم الكلاس الصحيح
            'sender_id' => $doctor->id,
            'content' => $content,
            'seen' => 0
        ]);

        // تحديث توقيت المحادثة
        $chat->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'type' => $message->type,
                'content' => $message->content,
                'sender_type' => 'doctor', // إرسال doctor صريحة للـ JS
                'created_at' => $message->created_at,
                'formatted_time' => $message->created_at->format('d-m H:i'),
            ],
        ], 201);
    }
}