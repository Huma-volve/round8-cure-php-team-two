@extends('dashboard')
@section('doctor-dashboard')
    @if(Auth::guard('doctor')->check())
        <h3 class="text-lg font-medium text-gray-900 mt-4">Doctor Section</h3>
        <nav class="nav">
            <a href="{{ route('doctor.appointments') }}" class="nav-link active" aria-current="page">View
                Appointments</a>
            
        </nav>
        @yield('content')
    @endif

@endsection