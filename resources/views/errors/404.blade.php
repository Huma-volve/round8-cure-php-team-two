<!doctype html>

<html lang="en" class="layout-wide" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>404 Not Found</title>


    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin') }}/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
            rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/fonts/iconify-icons.css" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css -->

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/libs/node-waves/node-waves.css" />

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/css/core.css" />
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/demo.css" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- endbuild -->

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/vendor/css/pages/page-misc.css" />

    <!-- Helpers -->
    <script src="{{ asset('assets/admin') }}/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->

    <!--? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file. -->

    <script src="{{ asset('assets/admin') }}/js/config.js"></script>
</head>

<body>
<!-- Content -->

<!-- Error -->
<div class="misc-wrapper">
    <h1 class="mb-2 mx-2" style="font-size: 6rem; line-height: 6rem">404</h1>
    <h4 class="mb-2">Page Not Found 🙄</h4>
    <p class="mb-10 mx-2">we couldn't find the page you are looking for</p>
    <div class="d-flex justify-content-center mt-5">
        <img
                src="{{ asset('assets/admin') }}/img/illustrations/tree-3.png"
                alt="misc-tree"
                class="img-fluid misc-object d-none d-lg-inline-block" />
        <img
                src="{{ asset('assets/admin') }}/img/illustrations/misc-mask-light.png"
                alt="misc-error"
                class="scaleX-n1-rtl misc-bg d-none d-lg-inline-block"
                 />
        <div class="d-flex flex-column align-items-center">
            <img
                    src="{{ asset('assets/admin') }}/img/illustrations/404.png"
                    alt="misc-error"
                    class="misc-model img-fluid z-1"
                    width="780" />

        </div>
    </div>
</div>
<!-- /Error -->

<!-- / Content -->


<!-- Core JS -->

<script src="{{ asset('assets/admin') }}/vendor/libs/jquery/jquery.js"></script>

<script src="{{ asset('assets/admin') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('assets/admin') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('assets/admin') }}/vendor/libs/node-waves/node-waves.js"></script>

<script src="{{ asset('assets/admin') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="{{ asset('assets/admin') }}/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->

<!-- Main JS -->

<script src="{{ asset('assets/admin') }}/js/main.js"></script>

<!-- Page JS -->

</body>
</html>
