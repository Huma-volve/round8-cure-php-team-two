<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;            
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Doctor;

class DoctorProfileController extends Controller
{
    public function showProfile()
    {
        $doctor = Auth::guard('doctor')->user();

        return view('dashboard.doctor-booking.profile.show', compact('doctor'));
    }

    /**
     * Edit doctor profile page
     */
    public function editProfile()
    {
        $doctor = Auth::guard('doctor')->user();

        return view('dashboard.doctor-booking.profile.edit', compact('doctor'));
    }

    /**
     * Update doctor profile
     */
    public function updateProfile(Request $request)
    {
        $doctor = Doctor::findOrFail(Auth::guard('doctor')->id());

        $data = $request->validate([
            'email'         => 'nullable|email|unique:doctors,email,' . $doctor->id,
            'phone'         => 'nullable|string|max:20',
            'hospital_name' => 'nullable|string|max:255',
            'location'      => 'nullable|string|max:255',
            'price'         => 'nullable|numeric',
            'exp_years'     => 'nullable|integer|min:0',
            'bio'           => 'nullable|string',
            'status'        => 'nullable|boolean',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        
        if ($request->hasFile('image')) {
            if ($doctor->image) {
                Storage::disk('public')->delete($doctor->image);
            }

            $data['image'] = $request->file('image')
                ->store('doctors', 'public');
        }

        $doctor->update($data);



        return redirect()
            ->route('doctor.profile.show')
            ->with('success', 'Profile updated successfully');
    }}
