@extends('layouts.dashboard.app')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Doctors</h5>
                        <p class="card-text display-4">{{ $summary['total_doctors'] }}</p> 
                    </div>
                </div>  
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5> 
                        <p class="card-text display-4">{{ $summary['total_users'] }}</p>
                    </div>
                </div>
            </div>
            </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Appointments</h5>
                        <p class="card-text display-4">{{ $summary['total_appointments'] }}</p> 
                    </div>
                </div>  
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5> 
                        {{-- <p class="card-text display-4">{{ $summary['total_users'] }}</p> --}}
                    </div>
                </div>
            </div>
            </div>
            </div>


@endsection