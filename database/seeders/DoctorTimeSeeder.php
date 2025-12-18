<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DoctorTimeSeeder extends Seeder
{
    public function run(): void
    {
        $data = [];

        $doctors = [1, 2, 3]; // IDs الدكاترة
        $daysCount = 7; // من النهارده ولمدة 7 أيام

        foreach ($doctors as $doctorId) {
            for ($i = 0; $i < $daysCount; $i++) {

                // أي يوم من النهارده وما بعده
                $date = Carbon::now()->addDays($i)->toDateString();

                $start = Carbon::createFromTime(9, 0);
                $end   = Carbon::createFromTime(15, 0);

                while ($start->lt($end)) {
                    $slotEnd = $start->copy()->addHour();

                    $data[] = [
                        'doctor_id'  => $doctorId,
                        'date'       => $date,
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
