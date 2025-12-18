<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
        public function index()
    {
        // ====== Main Statistics ======
        $totalDoctors   = Doctor::count();
        $totalPatients  = User::count();
        $totalBookings  = Appointment::count();
        $totalPayments  = Payment::sum('price');

        // ====== Monthly Bookings ======
        $monthlyBookings = Appointment::selectRaw(
                'MONTH(created_at) as month, COUNT(*) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ====== Monthly Payments ======
        $monthlyPayments = Payment::selectRaw(
                'MONTH(created_at) as month, SUM(price) as total'
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // ====== Completed Bookings ======
        $completedBookings = Appointment::where('status', 'completed')->count();
// resources/views/dashboard/admin-booking/reports.blade.php
        return view('dashboard.admin-booking.reports', compact(
            'totalDoctors',
            'totalPatients',
            'totalBookings',
            'totalPayments',
            'monthlyBookings',
            'monthlyPayments',
            'completedBookings'
        ));
    }

}
