<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
@livewireStyles
<!-- Layout config Js -->
<script src="{{ asset('assets/js/layout.js') }}"></script>
<!-- Bootstrap Css -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    .navbar-menu .navbar-nav .nav-link i {
        display: inline-block;
        min-width: 1.2rem;
        font-size: 15px;
    }

    .navbar-menu .navbar-nav .nav-link {
        font-size: 16px;
    }
</style>
@stack('styles')
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/icons/fontawesome.css') }}" />
