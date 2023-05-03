@extends('layouts.app')

@section('title', 'Dashboard')

@push('css')

@endpush

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ tr('dashboard') }}</li>
@endsection

@section('content')
    <input type="hidden" id="userId" value="{{ auth()->id() }}">
    <input type="hidden" id="tenant" value="{{ tenant('id') }}">
    <div class="row">
        <div class="col-md-4">
            <a href="#" class="btn btn-primary btn-block mb-3">Compose</a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ tr('users') }}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fas fa-inbox"></i> Inbox
                                <span class="badge bg-primary float-right">12</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-envelope"></i> Sent
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-file-alt"></i> Drafts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-filter"></i> Junk
                                <span class="badge bg-warning float-right">65</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-trash-alt"></i> Trash
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="col-md-8">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">Direct Chat</h3>
                    <div class="card-tools">
                        <span title="3 New Messages" class="badge badge-primary">3</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">

                    <div class="direct-chat-messages">

                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            </div>

                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">

                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>

                        </div>


                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>

                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">

                            <div class="direct-chat-text">
                                You better believe it!
                            </div>

                        </div>


                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 5:37 pm</span>
                            </div>

                            <img class="direct-chat-img" src="dist/img/user1-128x128.jpg" alt="message user image">

                            <div class="direct-chat-text">
                                Working with AdminLTE on a great new app! Wanna join?
                            </div>

                        </div>


                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 6:10 pm</span>
                            </div>

                            <img class="direct-chat-img" src="dist/img/user3-128x128.jpg" alt="message user image">

                            <div class="direct-chat-text">
                                I would love to.
                            </div>

                        </div>

                    </div>


                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user1-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
Count Dracula
<small class="contacts-list-date float-right">2/28/2015</small>
</span>
                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>

                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user7-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
Sarah Doe
<small class="contacts-list-date float-right">2/23/2015</small>
</span>
                                        <span class="contacts-list-msg">I will be waiting for...</span>
                                    </div>

                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user3-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
Nadia Jolie
<small class="contacts-list-date float-right">2/20/2015</small>
</span>
                                        <span class="contacts-list-msg">I'll call you back at...</span>
                                    </div>

                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user5-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
Nora S. Vans
<small class="contacts-list-date float-right">2/10/2015</small>
</span>
                                        <span class="contacts-list-msg">Where is your new...</span>
                                    </div>

                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user6-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
John K.
<small class="contacts-list-date float-right">1/27/2015</small>
</span>
                                        <span class="contacts-list-msg">Can I take a look at...</span>
                                    </div>

                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img class="contacts-list-img" src="dist/img/user8-128x128.jpg" alt="User Avatar">
                                    <div class="contacts-list-info">
<span class="contacts-list-name">
Kenneth M.
<small class="contacts-list-date float-right">1/4/2015</small>
</span>
                                        <span class="contacts-list-msg">Never mind I found...</span>
                                    </div>

                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

                <div class="card-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
<button type="button" class="btn btn-primary">Send</button>
</span>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
{{--    <script src="{{ asset('js/vendor/socket.io.min.js') }}"></script>--}}
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js" integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script src="{{ asset('js/support-client.js') }}"></script>
{{--    <script type="text/javascript">--}}
{{--        const socket = io('http://localhost:6001');--}}
{{--        socket.on('connect', () => {--}}
{{--            console.log(`Connected to server with ID ${socket.id}`);--}}
{{--        });--}}
{{--        socket.on('news', (data) => {--}}
{{--            console.log(data);--}}
{{--        });--}}
{{--    </script>--}}
@endpush
