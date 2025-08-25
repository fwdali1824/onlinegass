<head>
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Lucid Bootstrap 4.1.1 Admin Template">
    <meta name="author" content="WrapTheme, design by: ThemeMakker.com">

    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/jvectormap/jquery-jvectormap-2.0.3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/morrisjs/morris.min.css') }}">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/jquery-datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/chatapp.css') }}">

    <link rel="stylesheet" href="../assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css">
    <link rel="stylesheet" href="../assets/vendor/multi-select/css/multi-select.css">

    <!-- Select2 -->
    <link rel="stylesheet" href="../assets/vendor/select2/select2.css" />
    @livewireStyles


    <style>
        .btn.btn-round.btn-primary.buttons-copy.buttons-html5,
        .btn.btn-round.btn-primary.buttons-csv.buttons-html5,
        .btn.btn-round.btn-primary.buttons-print {
            display: none;
        }

        .theme-cyan .auth-main .btn-primary {
            background: #025888;
            border-color: #1b9b48;
        }
    </style>
</head>
