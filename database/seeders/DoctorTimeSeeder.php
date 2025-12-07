<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorTimeSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        $data = [
            [
                'doctor_id'  => 1,
                'date'       => $today->toDateString(),
                'start_time' => '09:00:00',
                'end_time'   => '12:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id'  => 1,
                'date'       => $today->copy()->addDay()->toDateString(),
                'start_time' => '13:00:00',
                'end_time'   => '17:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'doctor_id'  => 2,
                'date'       => $today->toDateString(),
                'start_time' => '10:00:00',
                'end_time'   => '14:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('doctor_times')->insert($data);
    }
}
