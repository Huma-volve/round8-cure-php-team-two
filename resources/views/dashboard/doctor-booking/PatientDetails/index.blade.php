@extends('layouts.dashboard.app')

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Patient Details</h2>

    @if ($user)
        <div class="card mb-4">
            <div class="card-header">
                <strong>Patient Info</strong>
            </div>
            <div class="d-flex align-items-center p-3">
                <div class="me-4">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('images/default-avatar.png') }}"
                         alt="Patient Photo" class="rounded-circle" width="100" height="100">
                </div>
                <div>
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</p>
                    <p><strong>Gender:</strong> {{ ucfirst($user->gender ?? 'N/A') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <strong>All Appointments</strong>
        </div>
        <div class="card-body">
            @if ($appointments->isEmpty())
                <p class="text-muted">No appointments found.</p>
            @else
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appt)
                            <tr>
                                <td>{{ $appt->id }}</td>
                                <td>{{ $appt->appointment_date }}</td>
                                <td>{{ $appt->appointment_time }}</td>
                                <td>{{ $appt->doctor->name }}</td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>
@endsection
