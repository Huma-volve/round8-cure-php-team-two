<?php

namespace App\Http\Controllers\Dashboard\Doctor;

use App\Http\Controllers\Controller;
use App\Models\DoctorTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorTimesController extends Controller
{
    public function index()
    {
        $doctor = Auth::guard('doctor')->user();

        $times = $doctor->times;

        return view('dashboard.doctor-booking.times.index', compact('times'));
    }

    public function create()
    {
        return view('dashboard.doctor-booking.times.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'       => 'required|date',
            'start_time' => 'required',
            'end_time'   => 'required|after:start_time',
        ]);
        


        DoctorTime::create([
            'doctor_id'  => Auth::guard('doctor')->user()->id,
            'date'       => $request->date,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        return redirect()
            ->route('doctor.times.index')
            ->with('success', 'Time slot created successfully');
    }

    public function show($id)
    {
        $time = DoctorTime::where('doctor_id', Auth::guard('doctor')->user()->id)
            ->findOrFail($id);

        return view('dashboard.doctor-booking.times.show', compact('time'));
    }

    public function edit(DoctorTime $time)
    {
        
        if ($time->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        return view('dashboard.doctor-booking.times.edit', compact('time'));
    }

    public function update(Request $request, DoctorTime $time)
    {
        
        if ($time->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'from' => 'required',
            'to'   => 'required|after:from',
        ]);

        $time->update([
            'date' => $request->date,
            'from' => $request->from,
            'to'   => $request->to,
        ]);

        return redirect()
            ->route('doctor.times.index')
            ->with('success', 'Time slot updated successfully');
    }

    public function destroy(DoctorTime $time)
    {
        
        if ($time->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403);
        }

        $time->delete();

        return redirect()
            ->route('doctor.times.index')
            ->with('success', 'Time slot deleted successfully');
    }
}
