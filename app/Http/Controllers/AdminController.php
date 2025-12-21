<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDoctorRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // public function dashboard()
    // {
        
    //     return view('admin.dashboard');
    // }
    public function listDoctors()
    {
        $doctors = Doctor::all();
        return view('dashboard.admin-booking.doctor.index', compact('doctors'));
    }
    public function createDoctor()
    {
        $specialties = \App\Models\Specialty::all();
        return view('dashboard.admin-booking.doctor.create', compact('specialties'));
    }

    public function storeDoctor(StoreDoctorRequest $request)
    {
        
        
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'specialty_id' => $request->specialty_id,
            'phone' => $request->phone,
            'gender' => $request->gender,
        ]);
    
        return redirect()->route('admin.doctor.index')->with('status', 'Doctor created successfully!');
    }

    public function deleteDoctor(Request $request,Doctor $doctor)
    {
        

        $doctor->delete();

        return redirect()->route('admin.doctor.index')->with('status', 'Doctor created successfully!');
    }
}
