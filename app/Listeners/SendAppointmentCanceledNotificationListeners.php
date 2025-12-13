<?php

namespace App\Listeners;

use App\Events\AppointmentCanceledEvent;
use App\Notifications\AppointmentCanceledNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAppointmentCanceledNotificationListeners
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
//    public function handle(AppointmentCanceledEvent $event): void
//    {
//        $appointment = $event->appointment;
//
//        // جيب الدكتور
//        $doctor = $appointment->doctor;
//
//        // ابعت له الإشعار
//        $doctor->notify(new AppointmentCanceledNotification ($appointment));
//
//    }
}
