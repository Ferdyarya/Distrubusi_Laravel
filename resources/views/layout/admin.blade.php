<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aplikasi Distributor</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('template/plugins/fontawesome-free/css/all.min.css')}} ">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}} ">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css')}} ">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.0.0-beta.11/dist/select2-bootstrap-5.css" rel="stylesheet" />
    <style>
        .select2-container--bootstrap-5 .select2-selection--single {
            background-color: #40474f;
            border: 1px solid #6c757d;
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-results__option {
            background-color: #343a40;
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background-color: #343a40;
            color: #fff;
        }
    </style>
    @stack('css')
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{ asset('template/dist/img/AdminLTELogo.png')}} " alt="AdminLTELogo"
                height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="{{ asset('template/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><b>PT SSM</b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('template/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name}}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                {{-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                        {{-- dashboard --}}
                        <li class="nav-item menu-open">
                            <a href="/" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    {{-- <i class="right fas fa-angle-left"></i> --}}
                                </p>
                            </a>
                        </li>


                        {{-- Master Data --}}
                        @if (Auth::user()->hakakses('supervisor'))
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Master Data
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('masteruser.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Pegawai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mastertoko.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Toko</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('mastersupplier.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Supplier</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('masterbarang.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Bahan Baku</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif


                        {{-- Data Tables --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Transaksi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('pendafoutlite.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pendaftaran Outlite</p>
                                    </a>
                                </li>
                                 @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin'))
                                <li class="nav-item">
                                    <a href="{{ route('brgmasuk.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang Masuk</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('sales')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('helper'))
                                <li class="nav-item">
                                    <a href="{{ route('brgkeluar.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Orderan</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('laporanharian.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan harian</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('brgretur.index')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang Retur</p>
                                    </a>
                                </li>
                                @endif
                                {{-- @if (Auth::user()->hakakses('kepgudang')|| Auth::user()->hakakses('helper')|| Auth::user()->hakakses('supervisor'))
                                <li class="nav-item">
                                    <a href="{{ route('laporansales.showinvoice')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Invoice</p>
                                    </a>
                                </li>
                                @endif --}}
                            </ul>
                        </li>

                        {{-- Recapan --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Report
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin'))
                                <li class="nav-item">
                                    <a href="{{ route('pernama')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Sales Pemegang Toko</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('laporanoutlet')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pendaftaran Outlet</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin'))
                                <li class="nav-item">
                                    <a href="{{ route('laporanbrgmasuk')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('laporanorderan')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Orderan</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('laporanhariansales')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Laporan Harian</p>
                                    </a>
                                </li>
                                @endif
                                @if (Auth::user()->hakakses('supervisor')|| Auth::user()->hakakses('admin')|| Auth::user()->hakakses('sales'))
                                <li class="nav-item">
                                    <a href="{{ route('laporanbrgretur')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Barang Retur</p>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('logout')}}" class="nav-link btn btn-dark btn-block">Log Out</a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('template/plugins/jquery/jquery.min.js')}} "></script>
    <!-- Bootstrap -->
    <script src="{{ asset('template/plugins/bootstrap/js/bootstrap.bundle.min.js')}} "></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}} "></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('template/dist/js/adminlte.js')}} "></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{ asset('template/plugins/jquery-mousewheel/jquery.mousewheel.js')}} "></script>
    <script src="{{ asset('template/plugins/raphael/raphael.min.js')}} "></script>
    <script src="{{ asset('template/plugins/jquery-mapael/jquery.mapael.min.js')}} "></script>
    <script src="{{ asset('template/plugins/jquery-mapael/maps/usa_states.min.js')}} "></script>
    <!-- ChartJS -->
    <script src="{{ asset('template/plugins/chart.js/Chart.min.js')}} "></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('template/dist/js/demo.js')}} "></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('template/dist/js/pages/dashboard2.js')}} "></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        @if(Session::has('success'))
    toastr.success("{{ Session::get('success')}}")
    @endif
    </script>
    @stack('scripts')
</body>

</html>
