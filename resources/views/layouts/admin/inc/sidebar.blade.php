<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">

            <span class="app-brand-text demo menu-text fw-semibold ms-2">
                @if(Auth::guard('admin')->check())
                Admin News
                @elseif(Auth::guard('doctor')->check())
                Doctor News
                @endif

            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- Dashboard --}}
        <li class="menu-item">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div>Dashboard</div>
            </a>
        </li>

        {{-- ================= ADMIN ================= --}}

        


        @if (Auth::guard('admin')->check())

            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-user-2-line"></i>
                    <div>Admin</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('admin.bookings.index') }}" class="menu-link">
                            Bookings
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.dashboard.reports') }}" class="menu-link">
                            Reports
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('admin.doctor.index') }}" class="menu-link">
                            Doctors
                        </a>
                    </li>
                </ul>

            </li>

            <li class="menu-item">
                <a href="{{ route('doctor.notifications.all') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-notification-line"></i>
                    <div>Notifications</div>
                </a>
            </li>

            {{-- ================= DOCTOR ================= --}}
        @elseif(Auth::guard('doctor')->check())
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-blogger-line"></i>
                    <div>Doctor</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('doctor.appointments.index') }}" class="menu-link">
                            Appointments
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('doctor.times.index') }}" class="menu-link">
                            Doctor Times
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('doctor.dashboard.reports') }}" class="menu-link">
                            Reports
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item">
                <a href="{{ route('doctor.notifications.all') }}" class="menu-link">
                    <i class="menu-icon icon-base ri ri-notification-line"></i>
                    <div>Notifications</div>
                </a>
            </li>
        @endif
        


        {{-- Notifications --}}


        {{-- ================= LOGOUT ================= --}}
        @if (Auth::guard('admin')->check() || Auth::guard('doctor')->check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                @method('post')
                <li class="menu-item">
                    <button type="submit" class="menu-link">
                        <i class="menu-icon icon-base ri ri-shut-down-line"></i>
                        <div>Logout</div>
                    </button>
                </li>
            </form>
        @endif

    </ul>
</aside>
