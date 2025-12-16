<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder 
{
    public function run(): void
    {
        // إشعارات غير مقروءة
        Notification::factory()
            ->count(10)
            ->unread()
            ->create([
                'notifiable_id' => 141,
                'notifiable_type' => 'App\\Models\\User',
            ]);

        // إشعارات مقروءة
        Notification::factory()
            ->count(5)
            ->read()
            ->create([
                'notifiable_id' => 141,
                'notifiable_type' => 'App\\Models\\User',
            ]);
    }
}
