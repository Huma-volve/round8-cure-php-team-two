<!-- Required meta tags -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Favicon icon-->
<link rel="shortcut icon" type="image/png" href="{{ asset('assets') }}/images/logos/favicon.png" />

<!-- Core Css -->
<link rel="stylesheet" href="{{ asset('assets') }}/css/styles.css" />

<title>Doctor Dashboard</title>
<!-- Owl Carousel  -->
<link rel="stylesheet" href="{{ asset('assets') }}/libs/owl.carousel/dist/assets/owl.carousel.min.css" />

@stack('css')
