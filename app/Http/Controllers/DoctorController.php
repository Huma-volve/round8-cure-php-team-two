<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class DoctorController extends Controller
{
    public function dashboard()
    {
        $doctor = Auth::guard('doctor')->user();
        // Assuming appointments are related to doctor via 'doctor_id'
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();
        return view('doctor.dashboard', compact('appointments'));
    }

    public function editProfile()
    {
        $doctor = Auth::guard('doctor')->user();
        return view('doctor.profile', compact('doctor'));
    }

    public function updateProfile(Request $request)
    {
        $doctor = Auth::guard('doctor')->user(); // Get the authenticated doctor model

        // Since $doctor is an instance of the model, verify it works as intended.
        // We might need to ensure it's treated as a Doctor model instance for validation unique ignore.

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('doctors')->ignore($doctor->id)],
            'specialty' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $doctor->update([
            'name' => $request->name,
            'email' => $request->email,
            'specialty' => $request->specialty,
            'phone' => $request->phone,
        ]);

        return redirect()->route('doctor.dashboard')->with('status', 'Profile updated successfully!');
    }

    // Placeholder for appointment modification
    public function updateAppointmentStatus(Request $request, $id)
    {
        $appointment = Appointment::where('doctor_id', Auth::guard('doctor')->id())->findOrFail($id);
        $appointment->status = $request->status; // Expecting status input
        $appointment->save();
        return back()->with('status', 'Appointment status updated!');
    }

   public function patientdetails($id)
{
   
    $appointment = Appointment::with('user')->findOrFail($id);

    $user = $appointment->user;

   
    $appointments = $user->appointments()->orderBy('appointment_date', 'desc')->get();

    return view('dashboard.doctor-booking.PatientDetails.index', compact('user', 'appointments'));
}



}
