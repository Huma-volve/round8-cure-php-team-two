<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // إشعارات غير مقروءة
        $doctorId = 3;

        Notification::factory()
            ->count(10)
            ->unread()
            ->create([
                'notifiable_id' => $doctorId,
                'notifiable_type' => \App\Models\Doctor::class,
            ]);

        Notification::factory()
            ->count(5)
            ->read()
            ->create([
                'notifiable_id' => $doctorId,
                'notifiable_type' => \App\Models\Doctor::class,
            ]);

    }
}
