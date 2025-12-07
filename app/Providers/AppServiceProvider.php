<?php

namespace App\Providers;

use App\Models\Chat;
use App\Policies\Chats\ChatPolicy;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{


    protected $listen = [
        \App\Events\SendMessageEvent::class => [
            \App\Listeners\SendMessageNotificationListener::class,
        ],
    ];

    protected $policies = [
        Chat::class => ChatPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
