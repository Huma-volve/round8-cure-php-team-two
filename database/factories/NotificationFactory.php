<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Notifications\DatabaseNotification;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Illuminate\Notifications\DatabaseNotification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'type' => $this->faker->randomElement([
                'App\\Notifications\\AppointmentCanceledNotification',
                'App\\Notifications\\UpdateAppointmentNotification',
                'App\\Notifications\\NewAppointmentNotification',
                'App\\Notifications\\NewMessageNotification'
            ]),
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id' => $this->faker->numberBetween(1, 10),
            'data' => [
                'title' => $this->faker->sentence(),
                'message' => $this->faker->sentence(),
                'appointment_id' => $this->faker->numberBetween(1, 50),
                'patient' => $this->faker->name(),
                'date' => $this->faker->date(),
                'time' => $this->faker->time(),
            ],
            'read_at' => null,
        ];
    }

    // state للإشعارات المقروءة
    public function read()
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => now(),
        ]);
    }

    // state للإشعارات الغير مقروءة
    public function unread()
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => null,
        ]);
    }
}
