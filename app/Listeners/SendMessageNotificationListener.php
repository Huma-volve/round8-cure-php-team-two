<?php

namespace App\Listeners;

use App\Events\SendMessageEvent;
use App\Models\Chat;
use App\Models\Doctor;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class SendMessageNotificationListener
{
    public function __construct()
    {
        //
    }

    public function handle(SendMessageEvent $event): void
    {
        $message = $event->message;

        $chat = Chat::findOrFail($message->chat_id);

        if ($message->sender_type === 'user') { 
            $receiver = Doctor::find($chat->doctor_id);
        } else {  
            $receiver = User::find($chat->user_id);
        }

        Notification::send($receiver, new NewMessageNotification($message));

    }
}
