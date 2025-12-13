<?php

namespace App\Listeners;

use App\Events\SendMessageEvent;
use App\Notifications\NewMessageNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\User;

class SendMessageNotificationListener
{
    public function __construct()
    {
        //
    }

//    public function handle(SendMessageEvent $event): void
//    {
//        $message = $event->message;
//
//        // future user
//        $receiver = User::find($message->receiver_id);
//
//        Notification::send($receiver, new NewMessageNotification($message));
//        // \App\Models\Notification::create([
//        //     'user_id' => $receiver,
//        //     'title'   => $title,
//        //     'message' => $message,
//        // ]);
//    }
}
