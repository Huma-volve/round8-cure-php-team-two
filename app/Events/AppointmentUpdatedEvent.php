<?php

namespace App\Events;

use App\Models\Appointment;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class AppointmentUpdatedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('doctor.' . $this->appointment->doctor_id);
    }

    public function broadcastWith()
    {
        return [
            'appointment_id' => $this->appointment->id,
            'patient' => $this->appointment->user->name,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
            'status' => $this->appointment->status,
        ];
    }

    public function broadcastAs()
    {
        return 'appointment.updated';
    }
}
