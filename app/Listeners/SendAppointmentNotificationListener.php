<?php

namespace App\Listeners;

use App\Events\AppointmentBookedEvent;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AppointmentBookedEvent $event): void
    {
        $appointment = $event->appointment;

        // إرسال Notification للدكتور
        $appointment->doctor->notify(new NewAppointmentNotification($appointment));
  
    }
}
