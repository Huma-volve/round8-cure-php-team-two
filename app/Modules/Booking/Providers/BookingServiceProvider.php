<?php

namespace App\Modules\Booking\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class BookingServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\AppointmentBookedEvent::class => [
            \App\Listeners\SendAppointmentNotificationListener::class,
        ],
        \App\events\AppointmentCanceledEvent::class => [
           \App\Listeners\SendAppointmentCanceledNotificationListeners::class,
        ],
    ];
   

    public function boot()
    {
        Route::middleware('api')
            ->prefix(config('app.api_prefix', 'api/v1'))
            ->group(__DIR__ . '/../routes/api.php');
    }
}
