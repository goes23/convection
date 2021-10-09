<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/fontawesome-free/css/all.min.css">
    {{-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/iconframework.css">
    <link rel="stylesheet"
        href="{{ asset('assets/') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/jqvmap/jqvmap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets/') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <script src="{{ asset('assets/') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/jquery/inputmask.js"></script>
    <script src="{{ asset('assets/') }}/plugins/jquery/mask.js"></script>
    <script src="{{ asset('assets/') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js">
        < /> <
        script src = "{{ asset('assets/') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js" >
    </script>
    <script src="{{ asset('assets/') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="{{ asset('assets/') }}/dist/js/adminlte.js"></script>
    <script src="{{ asset('assets/') }}/dist/js/demo.js"></script>

    <div class="mask"></div>
    <div class="loading">
        <img alt="Loading.." src="{{ asset('assets/') }}/img/loader.gif">
    </div>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('layout.v_navbar')

        @include('layout.v_sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        @include('layout.v_footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
</body>

</html>
