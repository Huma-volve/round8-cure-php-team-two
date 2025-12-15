@extends('layouts.dashboard.app')

@section('content')

    <div class="card">
        <div class="card-header">
            <h4>All Bookings & Payments</h4>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                <tr>
                    <th>Patient</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Booking Status</th>
                    <th>Payment</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->user->name }}</td>
                        <td>{{ $appointment->doctor->name }}</td>

                        <td>
                            {{ $appointment->appointment_date }}
                            <br>
                            <small>{{ $appointment->appointment_time }}</small>
                        </td>

                        <td>
                        <span class="badge bg-secondary">
                            {{ ucfirst(str_replace('_',' ', $appointment->status->value)) }}
                        </span>
                        </td>

                        <td>
                            @if($appointment->payment)
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning text-dark">Unpaid</span>
                            @endif
                        </td>

                        <td>
                            {{ $appointment->payment->amount ?? '—' }}
                        </td>

                        <td>
                            <a href="{{ route('admin.bookings.show', $appointment) }}"
                               class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $appointments->links() }}
    </div>

@endsection
