<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="#" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-semibold ms-2">Admin News</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="menu-toggle-icon d-xl-inline-block align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                <i class="menu-icon icon-base ri ri-home-smile-line"></i>
                <div data-i18n="Basic">Dashboard</div>
            </a>
        </li>


        {{-- users links --}}
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-user-2-line"></i>
                    <div data-i18n="Layouts">Users</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Without menu">USERS</div>
                        </a>
                    </li>

                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Create User</div>
                            </a>
                        </li>
                </ul>
            </li>

            @if(Auth::guard('admin')->check())
        {{-- Admin links --}}
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-user-2-line"></i>
                    <div data-i18n="Layouts">Admins</div>
                </a>
                
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Without menu">Admins</div>
                        </a>
                    </li>

                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without navbar">Create Admin</div>
                            </a>
                        </li>

                    <li class="menu-item">
                        <a href="{{route('admin.bookings.index')}}" class="menu-link">
                            <div data-i18n="Without menu">bookings</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('admin.dashboard.reports')}}" class="menu-link">
                            <div data-i18n="Without menu">reports</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{route('admin.doctor.index')}}" class="menu-link">
                            <div data-i18n="Without menu">Doctors</div>
                        </a>
                    </li>
                    

                </ul>
            </li>

        {{-- categories links --}}

            @elseif(Auth::guard('doctor')->check())
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-blogger-line"></i>
                    <div data-i18n="Layouts">Doctor</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('doctor.appointments.index')}}" class="menu-link">
                            <div data-i18n="Without menu">Appointments</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('doctor.times.index')}}" class="menu-link">
                            <div data-i18n="Without menu">Doctor Times</div>
                        </a>
                    </li>
                </ul>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{route('doctor.dashboard.reports')}}" class="menu-link">
                            <div data-i18n="Without menu">reports</div>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-pencil-line"></i>
                    <div data-i18n="Layouts">Posts</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Without menu">Posts</div>
                        </a>
                    </li>

                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">Create Post</div>
                            </a>
                        </li>
                </ul>
            </li>


            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-lock-line"></i>
                    <div data-i18n="Layouts">Roles</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <div data-i18n="Without menu">Roles</div>
                        </a>
                    </li>

                        <li class="menu-item">
                            <a href="#" class="menu-link">
                                <div data-i18n="Without menu">Create Role</div>
                            </a>
                        </li>
                </ul>
            </li>



            {{-- contacts links --}}
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon icon-base ri ri-mail-line"></i>
                    <div data-i18n="Basic">Contacts</div>
                </a>
            </li>

            {{-- contacts links --}}
            <li class="menu-item">
                <a href="#" class="menu-link">
                    <i class="menu-icon icon-base ri ri-notification-line"></i>
                    <div data-i18n="Basic">Notifications</div>
                </a>
            </li>



            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon icon-base ri ri-lock-line"></i>
                    <div data-i18n="Layouts">Setting</div>
                </a>

                <ul class="menu-sub">
                    {{-- Setting links --}}
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-tools-line"></i>
                            <div data-i18n="Basic">Settings</div>
                        </a>
                    </li>

                    {{-- Setting links --}}
                    <li class="menu-item">
                        <a href="#" class="menu-link">
                            <i class="menu-icon icon-base ri ri-tools-line"></i>
                            <div data-i18n="Basic">Sites</div>
                        </a>
                    </li>
                </ul>
            </li>



        <!-- Cards -->
        <li class="menu-item">
            <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon icon-base ri ri-bank-card-2-line"></i>
                <div data-i18n="Basic">Cards</div>
            </a>
        </li>

        <form action="{{route('logout')}}" method="post">
            
            @csrf
            @method('post')
            
            <li class="menu-item">
                <button type="submit" class="menu-link">
                    <i class="menu-icon icon-base ri ri-shut-down-line"></i>
                    <div data-i18n="Basic">Logout</div>
                </button>
            </li>
        
        </form>


    </ul>
</aside>
