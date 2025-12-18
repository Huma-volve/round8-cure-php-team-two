<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AppointmentCanceledNotification extends Notification
{
    use Queueable;

    public $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Appointment Canceled',
            'message' => 'The appointment has been canceled.',
            'appointment_id' => $this->appointment->id,
            'patient' => $this->appointment->user->name,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Appointment Canceled',
            'message' => 'The appointment has been canceled.',
            'appointment_id' => $this->appointment->id,
            'patient' => $this->appointment->user->name,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
        ]);
    }

    public function broadcastType(): string
    {
        return 'appointment.canceled';
    }
}
