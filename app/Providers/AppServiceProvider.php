<?php

namespace App\Providers;

use App\Models\Chat;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


//    protected $listen = [
//        \App\Events\SendMessageEvent::class => [
////            \App\Listeners\SendMessageNotificationListener::class,
//        ],
//    ];



    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'user'   => User::class,
            'doctor' => Doctor::class,
        ]);
    }
}
