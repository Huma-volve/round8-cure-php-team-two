<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorDashboardController extends Controller
{
        public function index()
    {
        $doctor = auth()->user();

        $monthlyEarnings = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, SUM(price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $patientsPerMonth = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->selectRaw('MONTH(created_at) as month, COUNT(DISTINCT user_id) as users')
            ->groupBy('month')
            ->get();

        $completedSessions = Appointment::where('doctor_id', $doctor->id)
            ->where('status', 'completed')
            ->count();

        $thisMonthEarnings = Appointment::where('doctor_id', $doctor->id)
            ->whereMonth('created_at', now()->month)
            ->where('status', 'completed')
            ->sum('price');

        return view('dashboard.doctor-booking.reports', compact(
            'monthlyEarnings',
            'patientsPerMonth',
            'completedSessions',
            'thisMonthEarnings'
        ));
    }

   
}

