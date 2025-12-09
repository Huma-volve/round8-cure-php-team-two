<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@cure.com',
            'password' => bcrypt('admin123'),
        ]);
        Admin::create([
            'name' => 'Huma Super Admin',
            'email' => 'huma@cure.com',
            'password' => bcrypt('volve123'),
        ]);
    }
}
