<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    @stack('css')
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    @include('layouts.includes.navbar')

    @include('layouts.includes.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@yield('title')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.includes.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ asset('easy-build/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('easy-build/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('easy-build/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('easy-build/adminlte/dist/js/demo.js') }}"></script>
@if(session('success'))
    <script type="text/javascript">
        $(document).Toasts('create', {
            title: 'Success',
            class: 'bg-success',
            delay: 5000,
            body: @json(session('success')),
            autohide: true
        })
    </script>
@endif
@if($errors->any())
    @foreach ($errors->all() as $error)
        <script type="text/javascript">
            $(document).Toasts('create', {
                title: 'Error',
                class: 'bg-danger',
                delay: 5000,
                body: @json($error),
                autohide: true
            })
        </script>
    @endforeach
@endif
{{--<script type="text/javascript">--}}
{{--    $(document).ready(function (){--}}
{{--        $.ajaxSetup({--}}
{{--            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }--}}
{{--        });--}}
{{--    });--}}
{{--</script>--}}
@stack('js')
</body>
</html>

