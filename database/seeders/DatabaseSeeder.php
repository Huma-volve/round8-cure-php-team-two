<?php

namespace Database\Seeders;
use Illuminate\Notifications\DatabaseNotification;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            NotificationSeeder::class,
            DoctorTimeSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
