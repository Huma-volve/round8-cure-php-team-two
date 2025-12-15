<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorAppointmentDashboardController extends Controller
{
    public function index()
    {
        $doctorId = auth('doctor')->id();

        $appointments = Appointment::where('doctor_id', $doctorId)
            ->with('user')
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc')
            ->paginate(10);

        return view('dashboard.doctor-booking.appointments', compact('appointments'));
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->status = AppointmentStatus::Cancelled;
        $appointment->save();

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
        ]);

        $appointment->appointment_date = $request->appointment_date;
        $appointment->appointment_time = $request->appointment_time;
        $appointment->status = AppointmentStatus::PendingPayment; // reset status
        $appointment->save();

        return back()->with('success', 'Appointment rescheduled successfully.');
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending_payment,paid,cancelled,completed,confirmed',
        ]);

        $appointment->status = AppointmentStatus::from($request->status);
        $appointment->save();

        return back()->with('success', 'Appointment status updated successfully.');
    }
}
