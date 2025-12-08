<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class UpdateAppointmentNotification extends Notification
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
            'title' => 'Appointment Updated',
            'message' => 'The appointment has been updated.',
            'appointment_id' => $this->appointment->id,
            'patient' => $this->appointment->user->name ?? null,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
            'status' => $this->appointment->status,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'Appointment Updated',
            'message' => 'The appointment has been updated.',
            'appointment_id' => $this->appointment->id,
            'patient' => $this->appointment->user->name ?? null,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
            'status' => $this->appointment->status,
        ]);
    }

    public function broadcastType(): string
    {
        return 'appointment.updated';
    }
}
