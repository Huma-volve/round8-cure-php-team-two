<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMessageNotification extends Notification
{
    use Queueable;
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' => [  
                'sender_id' => $this->message->sender_id,
                'message_id' => $this->message->id,
                'from' => $this->message->sender_id,
                'content' => $this->message->content,
                'time' => $this->message->created_at->toDateTimeString(),
            ]

        ];
    }


    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'message_id' => $this->message->id,
                'from' => $this->message->sender_id,
                'content' => $this->message->content,
                'time' => $this->message->created_at->toDateTimeString(),
            ]
        ];
    }

    public function broadcastOn()
    {
        return ['user.' . $this->message->receiver_id];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
