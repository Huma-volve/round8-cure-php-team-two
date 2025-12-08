<?php

namespace App\Listeners;

use App\Events\AppointmentUpdatedEvent;
use App\Notifications\UpdateAppointmentNotification;

class SendAppointmentUpdatedNotificationListener
{
    public function handle(AppointmentUpdatedEvent $event)
    {
        $appointment = $event->appointment;

        if ($appointment->doctor) {
            $appointment->doctor->notify(new UpdateAppointmentNotification($appointment));
        }
    }
}
