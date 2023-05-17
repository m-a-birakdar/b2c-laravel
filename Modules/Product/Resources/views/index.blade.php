@extends('layouts.app')

@section('title', 'Products')

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ tr('dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ tr('products') }}</li>
@endsection

@section('content')
    <div class="container-xxl p-1">
        {!! $dataTable->table(['class' => 'table table-striped'] , true) !!}
    </div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
@endpush
