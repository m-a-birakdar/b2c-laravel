@extends('layouts.app')

@section('title', $title)

@push('css')
{{--    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('easy-build/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">--}}
    <style>
        tfoot {display: table-header-group !important;}
    </style>
@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ tr('dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
@endsection

@section('content')
    <div class="card p-2">
        {!! $dataTable->table(['class' => 'table table-striped'] , true) !!}
    </div>
@endsection

@push('js')
    <script src="{{ asset('easy-build/adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('easy-build/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}
@endpush
