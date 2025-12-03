<?php

namespace App\Policies\Chats;

use App\Models\Chat;

class ChatPolicy
{
    public function view($auth, Chat $chat)
    {
        return $auth->id === $chat->user_id ||
            $auth->id === $chat->doctor_id;
    }

    public function sendMessage($auth, Chat $chat)
    {
        return $auth->id === $chat->user_id ||
            $auth->id === $chat->doctor_id;
    }

    public function markSeen($auth, Chat $chat)
    {
        return $auth->id === $chat->user_id ||
            $auth->id === $chat->doctor_id;
    }

}
