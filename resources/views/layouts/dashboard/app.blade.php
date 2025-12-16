<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    @include('layouts.dashboard.include._head')
</head>

<body>
<div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive"
     aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
        <i class="ti ti-alert-circle fs-6"></i>
        <div>
            <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
            <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
        </div>
        <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast"
                aria-label="Close"></button>
    </div>
</div>
<!-- Preloader -->
<div class="preloader">
    <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid"/>
</div>
<div id="main-wrapper">

    @include('layouts.dashboard.include.side')
    <div class="page-wrapper">
        <!--  Header Start -->
        @include('layouts.dashboard.include.header')
        <!--  Header End -->


        <div class="body-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <script>
            function handleColorTheme(e) {
                document.documentElement.setAttribute("data-color-theme", e);
            }
        </script>
        <button class="btn btn-primary p-3 rounded-circle d-flex align-items-center justify-content-center customizer-btn"
                type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample">
            <i class="icon ti ti-settings fs-7"></i>
        </button>

    </div>

    <!--  Search Bar -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content rounded-1">
                <div class="modal-header border-bottom">
                    <input type="search" class="form-control fs-3" placeholder="Search here" id="search"/>
                    <a href="javascript:void(0)" data-bs-dismiss="modal" class="lh-1">
                        <i class="ti ti-x fs-5 ms-3"></i>
                    </a>
                </div>

            </div>

        </div>
        <div class="dark-transparent sidebartoggler"></div>
@include('layouts.dashboard.include._script')
</body>

</html>