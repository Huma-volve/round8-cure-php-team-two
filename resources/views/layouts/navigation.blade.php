
@if(Auth::guard('admin')->check())
    @include('layouts.admin-nav')
@endif
@if(Auth::guard('doctor')->check())
    @include('layouts.doctor-nav')
@endif
