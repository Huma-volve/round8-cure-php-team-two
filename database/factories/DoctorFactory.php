<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'password',
            'phone' => $this->faker->phoneNumber(),
            'image' => 'assets/admin/img/avatars/' . $this->faker->numberBetween(1, 7) . '.png',
            'status' => true,
            'location' => [
                'lat' => $this->faker->latitude(),
                'lng' => $this->faker->longitude(),
            ],
            'gender' => $this->faker->randomElement(['male', 'female']),
            'specialty_id' => Specialty::inRandomOrder()->first()->id ?? null,
            'bio' => $this->faker->text(),
            'price' => $this->faker->numberBetween(100, 1000),
            'hospital_name' => $this->faker->company(),
            'exp_years' => $this->faker->numberBetween(1, 10),
        ];
    }
}
