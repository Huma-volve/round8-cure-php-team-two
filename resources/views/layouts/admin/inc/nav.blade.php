<nav
        class="layout-navbar container-xxl  navbar navbar-expand-xl align-items-center"
        id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ri ri-menu-line icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">


        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
            <li class="nav-item dropdown mx-3">

                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <sub id="notifyAdminCount" class="badge bg-danger rounded-pill text-white "></sub>
                        <i class="icon-base ri ri-notification-line icon-md me-3"></i>

                    </button>

                    <div class="dropdown-menu dropdown-menu-end p-0" style="width: 320px;">
                        <div class="list-group list-group-flush" id="notifyAdminList">
                                <a href="#"
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>#</span>
                                    <small class="text-muted">#</small>
                                </a>
                                <div id="notifyAdminListEmpty" class="list-group-item text-center text-muted">
                                    No notifications
                                </div>
                        </div>

                    </div>
                </div>

            </li>


            <!-- User -->
            @if(Auth::guard('doctor')->check())
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a
                            class="nav-link dropdown-toggle hide-arrow p-0"
                            href="{{ route('doctor.profile.show') }}"
                            {{-- data-bs-toggle="dropdown"> --}}>
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets/admin/img/avatars/1.png') }}" alt="alt" class="rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                                <a class="dropdown-item" href="{{ route('doctor.profile.show') }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar avatar-online">
                                                <img src="../assets/img/avatars/1.png" alt="alt"
                                                     class="w-px-40 h-auto rounded-circle"/>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{Auth::guard('doctor')->user()->name}}</h6>
                                            <small class="text-body-secondary">Admin</small>
                                        </div>
                                    </div>
                                </a>

                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="icon-base ri ri-user-line icon-md me-3"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="icon-base ri ri-settings-4-line icon-md me-3"></i>
                                <span>Edit Profile</span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                            <span class="d-flex align-items-center align-middle">
                              <i class="flex-shrink-0 icon-base ri ri-bank-card-line icon-md me-3"></i>
                              <span class="flex-grow-1 align-middle ms-1">Billing Plan</span>
                              <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                            </span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1"></div>
                        </li>
                        <li>
                            <form action="{{route('logout')}}" method="post">
                                <div class="d-grid px-4 pt-2 pb-1">
                                @csrf
                                @method('post')
                                    <button class="btn btn-danger d-flex" type="submit" onclick="submitDeleteFormAdmin()">
                                        <small class="align-middle">Logout</small>
                                        <i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
            <!--/ User -->
        </ul>
    </div>
</nav>
<script>
    function submitDeleteFormAdmin() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't to logOut!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#8c57ff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logOut!'
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('LogOutAdmin').submit();
            }
        })

    }
</script>