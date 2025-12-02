<?php

namespace App\Http\Controllers\Api\Chat\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Models\Chat;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request)
    {

        try {
            DB::beginTransaction();
            $auth = auth()->user();
            $chat = $auth->chats()->find($request->chat_id);

            $message = $chat->messages()->create([
                'type' => $request->type,
                'sender_id' => $auth->id,
                'sender_type' => get_class($auth)
            ]);

            if ($request->hasFile('file')) {
                ImageManagement::saveMessageType($request->file, $message);
            }

            $chat->update([
                'last_message_at' => now(),
            ]);

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            return apiResponse(500, 'server error');
        }

    }


    public function getChatMessages($id)
    {
        $perPage = request('per_page', 10);
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

        $messages = $chat->messages()->with('sender')->paginate($perPage);

        if ($messages->count() == 0) {
            return apiResponse(200, 'no messages yet');
        }
        return apiResponse(200, 'success', $messages);

    }

    public function makeAllMessagesAsRead($id)
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

        if ($chat->messages()->count() == 0) {
            return apiResponse(200, 'All messages are already read');
        }

        $chat->messages()->where('seen', 0)->update(
            ['seen' => 1]
        );
        return apiResponse(200, 'All messages are read');

    }
}
