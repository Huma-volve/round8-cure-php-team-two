<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specialties = ['Cardiology', 'Neurology', 'Dentistry', 'Dermatology', 'Gynecology' , 'Ophthalmology'  ,
            'Pediatrics' , 'Surgery' , 'Urology' , 'Gastroenterology' , 'Nephrology' , 'Rheumatology','Oncology'];

        foreach ($specialties as $speacialty)
        {
            Specialty::create(['name' => $speacialty]);
        }
    }
}
