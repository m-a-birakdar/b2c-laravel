@extends('layouts.app')

@section('title', 'whatsapp')

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">whatsapp</li>
@endsection

@section('content')
    <input type="hidden" id="tenant" value="{{ tenant()->id }}">
    <input type="hidden" id="userId" value="{{ auth()->id() }}">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Title</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
           <div class="row">
               <div class="col-md-3" id="whatsapp_status">

               </div>
           </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
@endsection

@push('js')
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script src="https://cdn.rawgit.com/jeromeetienne/jquery-qrcode/1.0/jquery.qrcode.min.js"></script>
    <script type="module" src="{{ asset('whatsapp/js/show.js') }}"></script>
@endpush
