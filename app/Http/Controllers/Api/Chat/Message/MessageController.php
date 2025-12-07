<?php

namespace App\Http\Controllers\Api\Chat\Message;

use App\Events\SendMessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Http\Resources\Chat\Message\MessageCollection;
use App\Http\Resources\Chat\Message\MessageResource;

use App\Models\Message;
use App\Utils\ImageManagement;
use App\Utils\RateLimter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function sendMessage(SendMessageRequest $request)
    {
        $remaining = RateLimter::checkRateLimit($request, 10);

        try {
            DB::beginTransaction();
            $auth = auth()->user();
            $chat = $auth->chats()->find($request->chat_id);

            if (!$chat) {
                return apiResponse(404, 'chat not found');
            }
            $message = $auth->messages()->create([
                'chat_id' => $chat->id,
                'type' => $request->type,
                'content' => $request->type === "text" ? $request->content : null,
            ]);
            if ($request->hasFile('content')) {
                ImageManagement::uploadImage($request, $message);
            }

            $chat->update([
                'last_message_at' => now(),
            ]);

            DB::commit();
            broadcast(new SendMessageEvent($message));
            return apiResponse(200, 'message sent successfully', Messageresource::make($message));

        } catch (Exception $e) {
            DB::rollBack();
            return apiResponse(500, 'server error', $remaining);
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
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $messages = $chat->messages()->with('sender')->latest()->paginate($perPage);

        if ($messages->count() == 0) {
            return apiResponse(200, 'no messages yet');
        }
        return apiResponse(200, 'success', new MessageCollection($messages)->response()->getData(true));

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

        $chat = $auth->chats()->find($chatId);
        if (!$chat) {
            return apiResponse(404, 'chat not found');
        }

        $chat->messages()->where('id', $messageId)->delete();
        return apiResponse(200, 'Message deleted');
    }
}
