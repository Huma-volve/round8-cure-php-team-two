<!doctype html>
<html lang="en" class="layout-wide customizer-hide">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="robots" content="noindex, nofollow"/>

    <title>Admin | @yield('title')</title>
    <meta name="description" content="{{config('app.name')}}"/>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/img/favicon/favicon.ico') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/iconify-icons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/pages/page-auth.css') }}"/>

    <!-- Helpers -->
    <script src="{{ asset('assets/admin/vendor/js/helpers.js') }}"></script>

    <!-- Config (Theme options) -->
    <script src="{{ asset('assets/admin/js/config.js') }}"></script>
</head>

<body>
<!-- Content -->
<div class="position-relative">


    @yield('content')


</div>
<!-- / Content -->


<!-- Core JS -->
<script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/admin/vendor/js/menu.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/admin/js/main.js') }}"></script>
</body>
</html>