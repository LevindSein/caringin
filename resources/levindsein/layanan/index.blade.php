<!DOCTYPE html>
<html lang="en">
    <head>

        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Meta -->
        <meta name="description" content="Layanan BP3C">
        <meta name="author" content="Levind Sein">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

        <!-- Favicon -->
        <link rel="icon" href="{{asset('img/logo.png')}}">

        <!-- Custom styles for this page -->
        <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
        <link href="{{asset('vendor/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet">

        <!-- vendor css -->
        <link href="{{asset('dashforge/lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
        <link href="{{asset('dashforge/lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

        <!-- DashForge CSS -->
        <link rel="stylesheet" href="{{asset('dashforge/assets/css/dashforge.css')}}">
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
                <a href="#" class="df-logo">LAYANAN&nbsp;|<span>&nbsp;BP3C</span></a>
            </div><!-- navbar-brand -->
            <div id="navbarMenu" class="navbar-menu-wrapper">
                <div class="navbar-menu-header">
                    <a href="#" class="df-logo">LAYANAN&nbsp;|<span>&nbsp;BP3C</span></a>
                    <a id="mainMenuClose" href=""><i data-feather="x"></i></a>
                </div><!-- navbar-menu-header -->
                <ul class="nav navbar-menu">
                    <li class="nav-label pd-l-20 pd-lg-l-25 d-lg-none">MENU LAYANAN</li>
                    <li class="nav-item"><a href="{{url('dashboard')}}" class="nav-link"><i data-feather="arrow-left"></i> Back to Dashboard</a></li>
                    <li class="nav-item {{ (request()->is('layanan')) ? 'active' : '' }}"><a href="{{url('layanan')}}" class="nav-link"><i data-feather="book"></i> Registrasi</a></li>
                    <li class="nav-item with-sub {{ (request()->is('layanan/diskon*')) ? 'active' : '' }}">
                        <a href="" class="nav-link"><i data-feather="database"></i> Pengajuan Diskon</a>
                        <ul class="navbar-menu-sub">
                            <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="dislistrik"><i data-feather="zap"></i> Listrik</a></li>
                            <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="disairbersih"><i data-feather="droplet"></i> Air Bersih</a></li>
                            <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="diskeamananipk"><i data-feather="shield"></i> Keamanan & IPK</a></li>
                            <li class="nav-sub-item"><a href="#" data-toggle="modal" data-target="#myModal" class="nav-sub-link" id="diskebersihan"><i data-feather="feather"></i> Kebersihan</a></li>
                        </ul>
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
                        <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin untuk logout?</h5>
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
                        <span class="modal-title" id="titlesDiskon"></span>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form class="user" action="{{url('layanan/pengajuan/diskon')}}" target="_blank" method="POST">
                        @csrf
                        <div class="modal-body-short">
                            <div class="col-lg-12">
                                <select class="kontroldiskon select2" style="width:100%" name="kontroldiskon[]" id="kontroldiskon" required multiple></select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="fasilitasdiskon" name="fasilitasdiskon"/>
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

                $(document).on('click', '#dislistrik', function(){
                    $('#titlesDiskon').html("<h5>Pengajuan Diskon Listrik</h5>");
                    $('#fasilitasdiskon').val("listrik");
                });

                $(document).on('click', '#disairbersih', function(){
                    $('#titlesDiskon').html("<h5>Pengajuan Diskon Air Bersih</h5>");
                    $('#fasilitasdiskon').val("airbersih");
                });

                $(document).on('click', '#diskeamananipk', function(){
                    $('#titlesDiskon').html("<h5>Pengajuan Diskon Keamanan IPK</h5>");
                    $('#fasilitasdiskon').val("keamananipk");
                });

                $(document).on('click', '#diskebersihan', function(){
                    $('#titlesDiskon').html("<h5>Pengajuan Diskon Kebersihan</h5>");
                    $('#fasilitasdiskon').val("kebersihan");
                });

                $('#kontroldiskon').select2({
                    placeholder: '--- Pilih Tempat ---',
                    ajax: {
                        url: "/cari/alamat",
                        dataType: 'json',
                        delay: 250,
                        processResults: function (alamat) {
                            return {
                            results:  $.map(alamat, function (al) {
                                return {
                                    text: al.kd_kontrol,
                                    id: al.id
                                }
                            })
                            };
                        },
                        cache: true
                    }
                });
            });
        </script>

        @yield('js')
    </body>
</html>
