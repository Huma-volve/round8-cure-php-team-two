@extends('dashboard')
@section('admin-dashboard')
    @if(Auth::guard('admin')->check())
            <div class="py-10">
                <div class="mx-auto">

                    <h3 class="text-lg font-medium text-gray-900">Admin Section</h3>
                    <nav class="nav">
                <a href="{{ route('admin.doctor.index') }}" class="nav-link active" aria-current="page">Doctors
                    Management</a>

                </nav>
            </div>
            @yield('content')
        </div>
    @endif

@endsection