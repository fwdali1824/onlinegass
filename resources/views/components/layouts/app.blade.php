<!doctype html>
<html lang="en">


<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/index8.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Oct 2021 05:49:10 GMT -->

<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">
    <x-layouts.css.styles />

    <style>
        .navbar-fixed-top .navbar-brand img {
            width: 42px;
            vertical-align: top;
            /* margin-top: 2px; */
        }

        .page-loader-wrapper .loader {
            background: rgb(255, 255, 255);
            height: 100vh;
            top: 0;
            align-items: center;
            justify-items: center;
            align-content: center
        }
    </style>
</head>

<body>

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div>
                <img src="{{ asset('assets/images/logo.png') }}" width="200" alt="Lucid">
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- Overlay For Sidebars -->

    <div id="wrapper">

        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-btn">
                    <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                </div>

                <div class="navbar-brand">
                    <a href="{{ route('admin.dashboard') }}">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Lucid Logo" class="img-responsive logo">
                    </a>
                </div>

                <div class="navbar-right">
                    <div id="navbar-menu">
                        <ul class="nav navbar-nav">

                            <li>
                                <a href="{{ route('admin.manage.chat') }}" class="icon-menu d-none d-sm-block"><i
                                        class="icon-bubbles"></i></a>
                            </li>


                            <li>
                                <a href="page-login.html" class="icon-menu"><i class="icon-login"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <x-layouts.siderbar />

        <div id="main-content">

            <div class="container-fluid">
                <div class="row clearfix mt-3">
                    {{ $slot }}
                </div>
            </div>
        </div>
        <!-- Javascript -->
        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>

        <script src="{{ asset('assets/bundles/jvectormap.bundle.js') }}"></script> <!-- JVectorMap Plugin Js -->
        <script src="{{ asset('assets/bundles/morrisscripts.bundle.js') }}"></script> <!-- Morris Plugin Js -->
        <script src="{{ asset('assets/bundles/knob.bundle.js') }}"></script> <!-- jQuery Knob -->

        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/index8.js') }}"></script>


        <script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/vendorscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/bundles/datatablescripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-datatable/buttons/buttons.print.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
        <script src="{{ asset('assets/bundles/mainscripts.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/pages/tables/jquery-datatable.js') }}"></script>


        <script src="../assets/vendor/select2/select2.min.js"></script> <!-- Select2 Js -->
        <script src="../assets/vendor/multi-select/js/jquery.multi-select.js"></script> <!-- Multi Select Plugin Js -->

        @livewireScripts

    </div>
</body>

<!-- Mirrored from www.wrraptheme.com/templates/lucid/html/light/index8.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 01 Oct 2021 05:49:11 GMT -->

</html>
