<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Tagihan Air')</title>
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}">
    
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- Select2 -->
    <link href="{{ asset('dist/css/select2.min.css') }}" rel="stylesheet">
    <!-- DataTables -->
    <link href="{{ asset('assets/js/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="{{ asset('dist/swal/sweetalert2.min.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-cls-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">TAGIHAN AIR</a>
            </div>
            <div style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;">
                <span class="label label-danger">
                    Welcome, {{ auth()->user()->nama_user }} - {{ auth()->user()->level }}
                </span>
            </div>
        </nav>

        <!-- Sidebar -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    @if(auth()->user()->isAdmin())
                        <li>
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa fa-dashboard fa-2x"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pakai.index') }}">
                                <i class="fa fa-refresh fa-2x"></i> Pemakaian
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-tags fa-2x"></i> Tagihan
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ route('admin.tagihan.index') }}">Tagihan Belum Lunas</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.tagihan.lunas') }}">Tagihan Lunas</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if(auth()->user()->isPelanggan())
                        <li>
                            <a href="{{ route('pelanggan.tagihan') }}">
                                <i class="fa fa-tags fa-2x"></i> Tagihan Saya
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pelanggan.tagihan.lunas') }}">
                                <i class="fa fa-check fa-2x"></i> Riwayat Pembayaran
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-2x"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('dist/swal/sweetalert2.min.js') }}"></script>

    @stack('scripts')
</body>
</html>
