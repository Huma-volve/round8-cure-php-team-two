<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Str;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $doctorId = 3;
        $doctorType = \App\Models\Doctor::class;

        // 🔴 إشعارات غير مقروءة
        for ($i = 1; $i <= 10; $i++) {
            DatabaseNotification::create([
                'id' => (string) Str::uuid(),
                'type' => 'App\\Notifications\\NewAppointmentNotification',
                'notifiable_id' => $doctorId,
                'notifiable_type' => $doctorType,
                'data' => [
                    'title' => 'New Appointment',
                    'message' => 'You have a new appointment request',
                ],
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 🟢 إشعارات مقروءة
        for ($i = 1; $i <= 5; $i++) {
            DatabaseNotification::create([
                'id' => (string) Str::uuid(),
                'type' => 'App\\Notifications\\NewAppointmentNotification',
                'notifiable_id' => $doctorId,
                'notifiable_type' => $doctorType,
                'data' => [
                    'title' => 'Appointment Viewed',
                    'message' => 'You viewed an appointment',
                ],
                'read_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
