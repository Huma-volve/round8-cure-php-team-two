<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\User;

class AdminSummary extends Controller
{
    public function index()
    {
        $summary = [
            'total_users' => User::count(),
            'total_doctors' => Doctor::count(),
            'total_appointments' => Appointment::count(),
            'total_paid_amount' => Payment::sum('price'),
        ];
        
        return view('dashboard.admin-booking.summary', compact('summary'));
    }

    
}
