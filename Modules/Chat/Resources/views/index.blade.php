@extends('layouts.app')

@section('title', 'Chat')

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Chat - {{ auth()->user()->name }} - {{ auth()->id() }}</li>
@endsection

@section('content')
    <input type="hidden" id="tenant" value="{{ tenant()->id }}">
    <input type="hidden" id="userId" value="{{ auth()->id() }}">
    <input type="hidden" id="load-users-url" value="{{ route('chat.load-users') }}">
    <input type="hidden" id="load-messages" value="{{ route('chat.messages') }}">
    <div class="row">
        <div class="col-md-4">
            <div class="btn btn-primary btn-block mb-3" id="compose">Compose</div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ tr('users') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column" id="load-users"></ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card direct-chat direct-chat-primary" style="display: none">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title chat-title"></h3>
                    <input type="hidden" id="receipt_id">
                </div>
                <div class="card-body">
                    <div class="direct-chat-messages">
                        @include('loading')
                    </div>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button id="sendMessage" type="button" class="btn btn-primary">Send</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script type="module" src="{{ asset('chat/js/index.js') }}"></script>
@endpush
