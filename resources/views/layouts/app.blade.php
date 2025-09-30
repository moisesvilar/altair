<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Altair - SaaS Admin Dashboard">
    <meta name="robots" content="index, follow">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Altair - SaaS Admin Dashboard')</title>
    
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/fillow/images/favicon.png') }}">
    
    <!-- Vendor CSS -->
    <link href="{{ asset('assets/fillow/vendor/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fillow/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/fillow/vendor/nouislider/nouislider.min.css') }}">
    
    @stack('styles')
    
    <!-- Main Style CSS -->
    <link href="{{ asset('assets/fillow/css/style.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    @yield('styles')
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        
        @include('layouts.partials.nav-header')
        
        @include('layouts.partials.chat-box')
        
        @include('layouts.partials.header')
        
        @include('layouts.partials.sidebar')
        
        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
        @include('layouts.partials.footer')
        
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/fillow/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('assets/fillow/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/fillow/vendor/chart-js/chart.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/fillow/vendor/owl-carousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/fillow/vendor/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('assets/fillow/vendor/apexchart/apexchart.js') }}"></script>
    
    <!-- Dashboard 1 -->
    <script src="{{ asset('assets/fillow/js/dashboard/dashboard-1.js') }}"></script>
    
    <!-- Main JS -->
    <script src="{{ asset('assets/fillow/js/custom.min.js') }}"></script>
    <script src="{{ asset('assets/fillow/js/dlabnav-init.js') }}"></script>
    
    @stack('scripts')
    
    <!-- Custom Scripts -->
    @yield('scripts')
</body>
</html>
