@extends('layouts.dashboard.app')

@section('content')

    <div class="card">
        <div class="card-body px-4 py-3">

            <h4 class="fw-semibold mb-4">Doctor Appointments</h4>

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($appointments as $appointment)
                        <tr class="{{ $appointment->status === App\Enums\AppointmentStatus::Cancelled ? 'table-danger' : '' }}">
                            <td>{{ $appointment->user->name }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">{{ $appointment->appointment_time }}</small>
                            </td>

                            <td>
                            <span class="badge
                                {{ $appointment->status === App\Enums\AppointmentStatus::PendingPayment ? 'bg-warning text-dark' : '' }}
                                {{ $appointment->status === App\Enums\AppointmentStatus::Paid ? 'bg-info' : '' }}
                                {{ $appointment->status === App\Enums\AppointmentStatus::Confirmed ? 'bg-success' : '' }}
                                {{ $appointment->status === App\Enums\AppointmentStatus::Completed ? 'bg-primary' : '' }}
                                {{ $appointment->status === App\Enums\AppointmentStatus::Cancelled ? 'bg-danger' : '' }}">
                                {{ ucfirst($appointment->status->value) }}
                            </span>
                            </td>

                            <td class="d-flex gap-2">
                                <!-- Change Status -->
                                <form action="{{ route('doctor.appointments.status', $appointment) }}" method="POST">
                                    @csrf
                                    <select name="status"
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                        @foreach(App\Enums\AppointmentStatus::cases() as $status)
                                            <option value="{{ $status->value }}"
                                                {{ $appointment->status === $status ? 'selected' : '' }}>
                                                {{ ucfirst($status->value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                                <!-- Cancel -->
                                <form action="{{ route('doctor.appointments.cancel', $appointment) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Cancel this appointment?')">
                                        Cancel
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No appointments found
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                {{ $appointments->links() }}
            </div>

        </div>
    </div>

@endsection
