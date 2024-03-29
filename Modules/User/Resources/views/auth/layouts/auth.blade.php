<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/dist/css/adminlte.min.css') }}">
    @stack('css')
</head>
<body class="hold-transition login-page">

@yield('content')
<!-- jQuery -->
<script src="{{ asset('easy-build/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('easy-build/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('easy-build/adminlte/dist/js/adminlte.min.js') }}"></script>
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
@stack('js')
</body>
</html>
