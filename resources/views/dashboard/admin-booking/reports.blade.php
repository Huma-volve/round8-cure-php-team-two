@extends('layouts.dashboard.app')

@section('content')

<div class="container-fluid">


<!-- ===== Statistics Cards ===== -->
<div class="row mb-4">
<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h6>Total Doctors</h6>
<h3>{{ $totalDoctors }}</h3>
</div>
</div>
</div>


<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h6>Total Patients</h6>
<h3>{{ $totalPatients }}</h3>
</div>
</div>
</div>


<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h6>Total Bookings</h6>
<h3>{{ $totalBookings }}</h3>
</div>
</div>
</div>


<div class="col-md-3">
<div class="card shadow-sm">
<div class="card-body">
<h6>Total Payments</h6>
<h3>{{ number_format($totalPayments, 2) }} EGP</h3>
</div>
</div>
</div>
</div>


<!-- ===== Charts ===== -->
<div class="row">
<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">
<h5 class="mb-3">Monthly Bookings</h5>
<canvas id="bookingsChart"></canvas>
</div>
</div>
</div>


<div class="col-md-6">
<div class="card shadow-sm">
<div class="card-body">
<h5 class="mb-3">Monthly Payments</h5>
<canvas id="paymentsChart"></canvas>
</div>
</div>
</div>
</div>


</div>@endsection
