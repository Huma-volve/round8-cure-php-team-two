<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class AdminBookingController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with([
            'user',
            'doctor',
            'payment'
        ])
            ->latest()
            ->paginate(15);

        return view('dashboard.admin-booking.index', compact('appointments'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'doctor', 'payment']);

        return view('dashboard.admin-booking.show', compact('appointment'));
    }
}
