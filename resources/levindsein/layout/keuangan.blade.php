<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="BP3C Keuangan">
        <meta name="author" content="Levind Sein">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

        <!-- Favicon -->
        <link rel="icon" href="{{asset('img/logo.png')}}">

        <!-- Custom styles for this page -->
        <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
        <link href="{{asset('vendor/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet">
        <!-- <link href="{{asset('dashforge/assets/css/jquery.dataTables.min.css')}}" rel="stylesheet"> -->
        <!-- <link href="{{asset('dashforge/assets/css/responsive.dataTables.min.css')}}" rel="stylesheet"> -->

        <!-- vendor css -->
        <link href="{{asset('dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('dashforge/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

        <!-- DashForge CSS -->
        <link rel="stylesheet" href="{{asset('dashforge/assets/css/dashforge.min.css')}}">
        <!-- <link rel="stylesheet" href="{{asset('dashforge/assets/css/dashforge.dashboard.css')}}"> -->
        
        <script src="{{asset('js/animate.min.js')}}"></script>
        <link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}"/>
        <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
    </head>
    <body class="page-profile">
        <div class="se-pre-con"></div>
        <header class="navbar navbar-header navbar-header-fixed">
            <a href="" id="mainMenuOpen" class="burger-menu"><i data-feather="menu"></i></a>
            <div class="navbar-brand">
                <a href="#" class="df-logo">Keuangan&nbsp;|<span>&nbsp;BP3C</span></a>
            </div><!-- navbar-brand -->
            <div id="navbarMenu" class="navbar-menu-wrapper">
                <div class="navbar-menu-header">
                    <a href="#" class="df-logo">Keuangan&nbsp;|<span>&nbsp;BP3C</span></a>
                    <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
                </div><!-- navbar-menu-header -->
                <ul class="nav navbar-menu">
                    <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">MENU KEUANGAN</li>
                    <li class="nav-item {{ (request()->is('keuangan')) ? 'active' : '' }}"><a href="{{url('keuangan')}}" class="nav-link"><i data-feather="pie-chart"></i> Dashboard</a></li>
                    <li class="nav-item with-sub {{ (request()->is('keuangan/laporan*')) ? 'active' : '' }}">
                        <a href="" class="nav-link"><i data-feather="layers"></i> Laporan</a>
                        <div class="navbar-menu-sub">
                            <div class="d-lg-flex">
                                <ul>
                                    <li class="nav-label">Tagihan</li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/listrik')}}" class="nav-sub-link"><i data-feather="zap"></i> Listrik</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/airbersih')}}" class="nav-sub-link"><i data-feather="droplet"></i> Air Bersih</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/keamananipk')}}" class="nav-sub-link"><i data-feather="shield"></i> Keamanan & IPK</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/kebersihan')}}" class="nav-sub-link"><i data-feather="feather"></i> Kebersihan</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/airkotor')}}" class="nav-sub-link"><i data-feather="droplet"></i> Air Kotor</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/lain')}}" class="nav-sub-link"><i data-feather="grid"></i> Lain - Lain</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/tagihan/tagihan')}}" class="nav-sub-link"><i data-feather="send"></i> Fasillitas</a></li>
                                </ul>
                                <ul>
                                    <li class="nav-label">Pendapatan</li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/pendapatan/harian')}}" class="nav-sub-link"><i data-feather="calendar"></i> Harian</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/pendapatan/bulanan')}}" class="nav-sub-link"><i data-feather="calendar"></i> Bulanan</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/pendapatan/tahunan')}}" class="nav-sub-link"><i data-feather="calendar"></i> Tahunan</a></li>
                                </ul>
                                <ul>
                                    <li class="nav-label">Rekap</li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/rekap/sisa')}}" class="nav-sub-link"><i data-feather="dollar-sign"></i> Sisa Tagihan</a></li>
                                    <li class="nav-sub-item"><a href="{{url('keuangan/laporan/rekap/selesai')}}" class="nav-sub-link"><i data-feather="calendar"></i> Akhir Bulan</a></li>
                                </ul>
                            </div>
                        </div><!-- nav-sub -->
                    </li>
                    <li class="nav-item with-sub {{ (request()->is('keuangan/data*')) ? 'active' : '' }}">
                        <a href="" class="nav-link"><i data-feather="database"></i> Data Usaha</a>
                        <ul class="navbar-menu-sub">
                            <li class="nav-sub-item"><a href="{{url('keuangan/data/tagihan')}}" class="nav-sub-link"><i data-feather="dollar-sign"></i> Tagihan</a></li>
                            <li class="nav-sub-item"><a href="{{url('keuangan/data/tunggakan')}}" class="nav-sub-link"><i data-feather="arrow-up-right"></i> Tunggakan</a></li>
                        </ul>
                    </li>
                    <li class="nav-item with-sub {{ (request()->is('keuangan/checkout*')) ? 'active' : '' }}">
                        <a href="" class="nav-link"><i data-feather="send"></i> Checkout</a>
                        <div class="navbar-menu-sub">
                            <div class="d-lg-flex">
                                <ul>
                                    <li class="nav-label">Arsip Harian</li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arslistrik"><i data-feather="zap"></i> Listrik</a></li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arsairbersih"><i data-feather="droplet"></i> Air Bersih</a></li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arskeamananipk"><i data-feather="shield"></i> Keamanan & IPK</a></li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arskebersihan"><i data-feather="feather"></i> Kebersihan</a></li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arsairkotor"><i data-feather="droplet"></i> Air Kotor</a></li>
                                    <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="arslain"><i data-feather="grid"></i> Lain - Lain</a></li>
                                </ul>
                            </div>
                        </div><!-- nav-sub -->
                    </li>
                </ul>
            </div><!-- navbar-menu-wrapper -->
            <div class="navbar-right">
                <div class="dropdown dropdown-profile">
                    <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                        <span class="mr-2 d-none d-lg-inline text-dark">{{Session::get('username')}}</span>
                        <div class="avatar avatar-sm">
                            <img src="{{asset('img/icon_user.png')}}" class="rounded-circle" alt="">
                        </div>
                    </a><!-- dropdown-link -->
                    <div class="dropdown-menu dropdown-menu-right tx-13">
                        <h6 class="tx-semibold mg-b-5">{{Session::get('username')}}</h6>
                        <p class="mg-b-25 tx-12 tx-color-03">{{Session::get('role')}}</p>
                        <div class="dropdown-divider"></div>
                        <a href="" class="dropdown-item"><i data-feather="settings"></i>Settings</a>
                        <a
                            class="dropdown-item"
                            href="#"
                            data-toggle="modal"
                            data-target="#logoutModal"
                            data-animation="effect-scale">
                            <i data-feather="log-out"></i>Logout
                        </a>
                    </div><!-- dropdown-menu -->
                </div><!-- dropdown -->
            </div><!-- navbar-right -->
        </header><!-- navbar -->

        <div class="content content-fixed">
			<div class="container-fluid page-body-wrapper">
                @yield('breadcrumb')
				<div class="main-panel">
					<div class="content-wrapper">
						<div class="row mt-4">
							<div class="col-lg-12 grid-margin stretch-card">
								<!-- <div class="card shadow">
									<div class="card-body"> -->
										@yield('content')
									<!-- </div>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
            <footer class="content-footer">
                <div class="footer-wrap">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright &copy;2020&nbsp;</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">PT Pengelola Pusat Perdagangan Caringin Bandung</span>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Logout Modal-->
        <div
            class="modal fade"
            id="logoutModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 id="exampleModalLabel">Apakah anda yakin untuk logout?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body-short">Pilih "Logout" di bawah ini jika anda siap untuk mengakhiri sesi anda saat ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="{{url('logout')}}">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="myModal"
            tabIndex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title" id="titlesArsip"></span>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="user" action="{{url('keuangan/checkout/arsip')}}" target="_blank" method="GET">
                        <div class="modal-body-short">
                            <div class="col-lg-12">
                                <input
                                    required
                                    placeholder="Masukkan Tanggal" class="form-control" type="text" onfocus="(this.type='date')"
                                    autocomplete="off"
                                    type="date"
                                    name="tanggal"
                                    id="tanggal">
                                <input type="hidden" id="fasilitasarsip" name="fasilitasarsip"/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(window).load(function () {
                $(".se-pre-con")
                    .fadeIn("slow")
                    .fadeOut("slow");;
            });
        </script>

        <script src="{{asset('dashforge/lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('dashforge/lib/feather-icons/feather.min.js')}}"></script>
        <script src="{{asset('dashforge/lib/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('dashforge/lib/chart.js/Chart.bundle.min.js')}}"></script>
        
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/responsive.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/responsiveBootstrap.min.js')}}"></script>

        <script src="{{asset('dashforge/assets/js/dashforge.js')}}"></script>

        <script>
            $(document).ready(function() {
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                    $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
                } ); 

                $(document).on('click', '#arslistrik', function(){
                    $('#fasilitasarsip').val("listrik");
                    $('#titlesArsip').html("<h5>Arsip Listrik</h5>");
                });

                $(document).on('click', '#arsairbersih', function(){
                    $('#titlesArsip').html("<h5>Arsip Air Bersih</h5>");
                    $('#fasilitasarsip').val("airbersih");
                });

                $(document).on('click', '#arskeamananipk', function(){
                    $('#titlesArsip').html("<h5>Arsip Keamanan IPK</h5>");
                    $('#fasilitasarsip').val("keamananipk");
                });

                $(document).on('click', '#arskebersihan', function(){
                    $('#titlesArsip').html("<h5>Arsip Kebersihan</h5>");
                    $('#fasilitasarsip').val("kebersihan");
                });

                $(document).on('click', '#arsairkotor', function(){
                    $('#titlesArsip').html("<h5>Arsip Air Kotor</h5>");
                    $('#fasilitasarsip').val("airkotor");
                });

                $(document).on('click', '#arslain', function(){
                    $('#titlesArsip').html("<h5>Arsip Lain Lain</h5>");
                    $('#fasilitasarsip').val("lain");
                });
            });
        </script>

        @yield('js')
    </body>
</html>
