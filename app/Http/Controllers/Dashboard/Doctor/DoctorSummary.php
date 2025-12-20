<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\User;

class DoctorSummary extends Controller
{
    public function index()
    {
        $doctor = \Illuminate\Support\Facades\Auth::guard('doctor')->user();
        $doctorId = $doctor->id;

        $summary = [
            
            'total_patients' => Appointment::where('doctor_id', $doctorId)
                ->distinct('user_id')
                ->count('user_id'),

            
            'total_appointments' => Appointment::where('doctor_id', $doctorId)
                ->count(),

            
            'total_paid_amount' => Appointment::where('doctor_id',$doctorId)->sum('price')
        ];

        return view('dashboard.doctor-booking.summary', compact('summary'));
    }
}
