<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DoctorTimeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        $doctors = [1, 2, 3, 197, 198, 199]; // IDs الدكاترة

        $startDate = Carbon::today();               // من النهارده
        $endDate   = Carbon::today()->addMonth();   // لشهر قدام

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($doctors as $doctorId) {
            foreach ($period as $date) {

                $start = Carbon::createFromTime(9, 0);
                $end   = Carbon::createFromTime(15, 0);

                while ($start->lt($end)) {
                    $slotEnd = $start->copy()->addHour();

                    $data[] = [
                        'doctor_id'  => $doctorId,
                        'date'       => $date->toDateString(),
                        'start_time' => $start->format('H:i'),
                        'end_time'   => $slotEnd->format('H:i'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $start->addHour();
                }
            }
        }

        DB::table('doctor_times')->insert($data);
    }
}
