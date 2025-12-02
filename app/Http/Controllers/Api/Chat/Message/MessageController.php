<?php

namespace App\Http\Controllers\Api\Chat\Message;

use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendMessageRequest;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request)
    {

        try {
            DB::beginTransaction();
            $auth = auth()->user();
            $chat = $auth->chats()->find($request->chat_id);

            $this->authorize('sendMessage', $chat);  // check permission by policy
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
            broadcast(new SendMessageEvent($message));
            return apiResponse(200, 'message sent successfully', $message);

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

        $chat = $auth->chats()->find($id);
        $this->authorize('view', $chat);  // check permission by policy
        if (!$chat) {
            return apiResponse(404, 'chat not found');
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

        $chat = $auth->chats()->find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        if ($chat->messages()->count() == 0) {
            return apiResponse(200, 'All messages are already read');
        }

        $this->authorize('markSeen', $chat);  // check permission by policy
        $chat->messages()->where('seen', 0)->update(
            ['seen' => 1]
        );
        return apiResponse(200, 'All messages are read');

    }

    public function deleteAllMessages($id)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $chat->messages()->delete();
        return apiResponse(200, 'All messages are deleted');
    }

    public function deleteMessage($chatId, $messageId)
    {
        $auth = auth()->user();
        if (!$auth) {
            return apiResponse(401, 'unauthorized');
        }

        $chat = $auth->chats()->find($id);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $chat->messages()->where('id', $messageId)->delete();
        return apiResponse(200, 'Message deleted');
    }
}
