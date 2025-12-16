<?php

namespace App\Http\Controllers\Dashboard\Doctor\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Chat;
use App\Models\Message;
use App\Utils\ImageManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(SendMessageRequest $request, $id)
    {
        $doctor = Auth::guard('doctor')->user();

        // Use route parameter $id (chat id) to find the chat belonging to the doctor
        $chat = $doctor->chats()->findOrFail($id);

        $data = $request->validated();

        // Create message with all required fields at once
        $message = $chat->messages()->create([
            'type' => $data['type'],
            'sender_type' => 'App\\Models\\Doctor',
            'sender_id' => $doctor->id,
            'content' => $data['type'] === 'text' ? $data['content'] : null,
        ]);

        // Handle file uploads for non-text messages (ImageManagement itself checks for file)
        if ($data['type'] !== 'text') {
            ImageManagement::uploadImage($request, $message);
            $message->refresh();
        }

        // Update last message timestamp
        $chat->update(['last_message_at' => now()]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $message->id,
                'type' => $message->type,
                'content' => $message->content,
                'sender_type' => 'doctor',
                'created_at' => $message->created_at,
                'formatted_time' => $message->created_at->format('d-m H:i'),
            ],
        ], 201);
    }

    public function markAsRead(Request $request, $chatId)
    {
        $doctor = Auth::guard('doctor')->user();
        $chat = $doctor->chats()->findOrFail($chatId);

        $updated = $chat->messages()
            ->where('sender_type', '!=', 'App\Models\Doctor')
            ->where('seen', 0)
            ->update(['seen' => 1]);

        return response()->json([
            'success' => true,
            'marked_count' => $updated
        ]);
    }
}
