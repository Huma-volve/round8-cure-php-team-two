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

     
        
        $this->call([
            UserSeeder::class,
            SpecialtySeeder::class,
            DoctorSeeder::class,
            RoleSeeder::class,
            DoctorTimeSeeder::class,
            AdminSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
