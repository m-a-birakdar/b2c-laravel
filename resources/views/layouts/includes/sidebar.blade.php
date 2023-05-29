<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('easy-build/adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ tenant('id') }}</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image"><img src="{{ asset('easy-build/adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"></div>
            <div class="info"><a href="#" class="d-block">{{ auth()->user()->name }}</a></div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i><p class="text">{{ tr('dashboard') }}</p></a></li>--}}
{{--                <li class="nav-header">{{ tr('operations') }}</li>--}}
                <li class="nav-item"><a href="{{ route('supports.index') }}" class="nav-link"><i class="nav-icon far fa-circle text-danger"></i><p class="text">{{ tr('support') }}</p></a></li>
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-danger"></i><p class="text">{{ tr('orders') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-info"></i><p class="text">{{ tr('invoices') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-warning"></i><p class="text">{{ tr('shipment') }}</p></a></li>--}}
{{--                <li class="nav-header">{{ tr('interaction') }}</li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-primary"></i><p class="text">{{ tr('advertises') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-secondary"></i><p class="text">{{ tr('notifications') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-light"></i><p class="text">{{ tr('coupons') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon far fa-circle text-cyan"></i><p class="text">{{ tr('currencies') }}</p></a></li>--}}
{{--                <li class="nav-header">{{ tr('data') }}</li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-users"></i><p>{{ tr('users') }}</p></a></li>--}}
                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-list"></i><p>{{ tr('categories') }}</p></a></li>
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-tags"></i><p>{{ tr('products') }}</p></a></li>--}}
{{--                <li class="nav-item"><a href="#" class="nav-link"><i class="nav-icon fas fa-table"></i><p>{{ tr('tags') }}</p></a></li>--}}
                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-circle"></i>
                        <p>
                            Level 1
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Level 2
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="far fa-dot-circle nav-icon"></i>
                                        <p>Level 3</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Level 2</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
