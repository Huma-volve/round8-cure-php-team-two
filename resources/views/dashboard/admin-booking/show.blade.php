@extends('layouts.dashboard.app')

@section('content')

    <div class="row">

        <!-- Booking Info -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Booking Details</div>
                <div class="card-body">
                    <p><strong>Status:</strong> {{ $appointment->status->value }}</p>
                    <p><strong>Date:</strong> {{ $appointment->appointment_date }}</p>
                    <p><strong>Time:</strong> {{ $appointment->appointment_time }}</p>
                </div>
            </div>
        </div>

        <!-- Patient -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Patient</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $appointment->user->name }}</p>
                    <p><strong>Email:</strong> {{ $appointment->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Doctor -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Doctor</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $appointment->doctor->name }}</p>
                    <p><strong>Specialty:</strong> {{ $appointment->doctor->specialty }}</p>
                </div>
            </div>
        </div>

        <!-- Payment -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Payment</div>
                <div class="card-body">
                    @if($appointment->payment)
                        <p><strong>Status:</strong> {{ $appointment->payment->status }}</p>
                        <p><strong>Amount:</strong> {{ $appointment->payment->amount }}</p>
                        <p><strong>Payer:</strong> {{ $appointment->payment->payer_name }}</p>
                        <p><strong>Email:</strong> {{ $appointment->payment->payer_email }}</p>
                        <p><strong>Date:</strong> {{ $appointment->payment->paid_at }}</p>
                    @else
                        <p class="text-danger">No payment recorded</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

@endsection
