<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Appointment;

class AppointmentCanceledEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    // القناة الخاصة بالدكتور
    public function broadcastOn()
    {
        return new PrivateChannel('doctor.' . $this->appointment->doctor_id);
    }

    // البيانات اللي هتتبعت للفرونت
    public function broadcastWith()
    {
        return [
            'appointment_id' => $this->appointment->id,
            'patient_name' => $this->appointment->user->name ?? null,
            'appointment_date' => $this->appointment->appointment_date,
            'appointment_time' => $this->appointment->appointment_time,
            'status' => 'canceled',
        ];
    }

    // اسم الحدث اللي هيسمعه الفرونت
    public function broadcastAs()
    {
        return 'appointment.canceled';
    }
}
