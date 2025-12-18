@extends('layouts.dashboard.app')

@section('content')

    {{-- Page Title --}}
    <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

    {{-- Statistics Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        {{-- Monthly Earnings --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-gray-500 text-sm">This Month Earnings</p>
            <h3 class="text-2xl font-bold mt-2">
                {{ number_format($thisMonthEarnings) }} EGP
            </h3>
        </div>

        {{-- Completed Sessions --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-gray-500 text-sm">Completed Sessions</p>
            <h3 class="text-2xl font-bold mt-2">
                {{ $completedSessions }}
            </h3>
        </div>

        {{-- Patients This Month --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-gray-500 text-sm">Patients This Month</p>
            <h3 class="text-2xl font-bold mt-2">
                {{ $patientsPerMonth->where('month', now()->month)->first()->patients ?? 0 }}
            </h3>
        </div>

        {{-- Total Earnings --}}
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-gray-500 text-sm">Total Earnings</p>
            <h3 class="text-2xl font-bold mt-2">
                {{ number_format($monthlyEarnings->sum('total')) }} EGP
            </h3>
        </div>

    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Earnings Chart --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Monthly Earnings</h3>
            <canvas id="earningsChart"></canvas>
        </div>

        {{-- Patients Chart --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-4">Patients Per Month</h3>
            <canvas id="patientsChart"></canvas>
        </div>

    </div>

</div>



@endsection
