<?php

namespace App\Http\Controllers\Api\Chat\Room;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function fetchUserChats()
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chats = $auth->chats()
            ->with(['doctor', 'messages' => function ($query) {
                $query->latest()->take(1);
            }])->get();

        if (!$chats) {
            return apiResponse(404, 'chats not found');
        }

        if ($chats->isEmpty()) {
            return apiResponse(204, 'no chats yet');
        }

        return apiResponse(200, 'success', $chats);
    }

    public function createOrFetchChat(Request $request)
    {
        $request->validate([
            'doctor_id' => ['required', 'exists:doctors,id']
        ]);

        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = Chat::firstOrCreate([
            'doctor_id' => $request->doctor_id,
            'user_id' => $auth->id
        ]);

        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }
        return apiResponse(200, 'success', $chat);
    }

    public function fetchChatMessages($id)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->find($id);

        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $message = $chat->load('messages.sender');

        if ($message->messages->count() == 0) {
            return apiResponse(200, 'no messages yet');
        }
        return apiResponse(200, 'success', $message);
    }
}
