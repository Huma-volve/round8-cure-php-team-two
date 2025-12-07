<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorTimeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'doctor_id'  => 1,
                'date'       => '2025-01-10',
                'start_time' => '09:00:00',
                'end_time'   => '12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id'  => 1,
                'date'       => '2025-01-11',
                'start_time' => '13:00:00',
                'end_time'   => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id'  => 2,
                'date'       => '2025-01-10',
                'start_time' => '10:00:00',
                'end_time'   => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('doctor_times')->insert($data);
    }
}
