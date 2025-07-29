<!DOCTYPE html>
<html lang="en">

<head>
    <title>Carbook </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('client_asset/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('client_asset/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>

<body>
    @include('client.block.navigation')

    @yield('content')

    @include('client.block.footer')
    <!-- loader -->
    <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke="#eeeeee" />
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4"
                stroke-miterlimit="10" stroke="#F96D00" />
        </svg></div>


    <script src="{{ asset('client_asset/js/jquery.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/popper.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/aos.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('client_asset/js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('client_asset/js/scrollax.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
    <script src="{{ asset('client_asset/js/google-map.js') }}"></script>
    <script src="{{ asset('client_asset/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @yield('my-js')
</body>

</html>
