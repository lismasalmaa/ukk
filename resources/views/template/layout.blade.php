<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Flexy lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Flexy admin lite design, Flexy admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Flexy Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>IndoApril</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/Flexy-admin-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="navbar-brand" href="index.html">
                        <b class="logo-icon">
                            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                            <img src="{{ asset('assets/images/logo-light-icon.png') }}" alt="homepage"
                                class="light-logo" />
                        </b>
                        <span class="logo-text">
                            <img src="{{ asset('assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                            <img src="{{ asset('assets/images/logo-light-text.png') }}" class="light-logo"
                                alt="homepage" />
                        </span>
                    </a>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item search-box">
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter">
                                <a class="srh-btn">
                                    <i class="mdi mdi-window-close"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user"
                                    class="rounded-circle" width="31">

                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="javascript:void(0)"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ti-user m-r-5 m-l-5"></i>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        <button type="submit">Keluar</button>
                                    </form>
                                    Keluar
                                </a>

                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        @if(Auth::user()->role === 'admin')
                <!-- Sidebar untuk Admin -->
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                        href="{{ url('admin/dashboard') }}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('admin/product*') ? 'active' : '' }}"
                        href="{{ url('admin/product') }}" aria-expanded="false">
                        <i class="mdi mdi-store"></i>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('admin/sale') ? 'active' : '' }}"
                        href="{{ url('admin/sale') }}" aria-expanded="false">
                        <i class="mdi mdi-cart"></i>
                        <span class="hide-menu">Penjualan</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('admin/user') ? 'active' : '' }}"
                        href="{{ url('admin/user') }}" aria-expanded="false">
                        <i class="mdi mdi-account-network"></i>
                        <span class="hide-menu">User</span>
                    </a>
                </li>
                @elseif(Auth::user()->role === 'employee')
                <!-- Sidebar untuk Employee -->
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('employee/dashboard') ? 'active' : '' }}"
                        href="{{ url('employee/dashboard') }}" aria-expanded="false">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('employee/product*') ? 'active' : '' }}"
                        href="{{ url('employee/product') }}" aria-expanded="false">
                        <i class="mdi mdi-store"></i>
                        <span class="hide-menu">Produk</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link
                        {{ request()->is('employee/sale') ? 'active' : '' }}"
                        href="{{ url('employee/sale') }}" aria-expanded="false">
                        <i class="mdi mdi-cart"></i>
                        <span class="hide-menu">Penjualan</span>
                    </a>
                </li>
                @endif
                    </ul>
                </nav>
            </div>
        </aside>
        @yield('container')

    </div>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>
    @yield('scripts')

</body>

</html>
