<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notification;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Notification::factory()->count(5)->read()->create();
        // Notification::factory()->count(5)->unread()->create();
        
        
        $this->call([
            UserSeeder::class,
            SpecialtySeeder::class,
            DoctorSeeder::class,
            RoleSeeder::class,
            DoctorTimeSeeder::class,
        ]);
    }
}
