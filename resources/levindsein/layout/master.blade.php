<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Aplikasi PT. Pengelola Pusat Perdagangan Caringin di Kota Bandung">
        <meta name="author" content="Levind Sein">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
        <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
        
        <!-- Custom fonts for this template -->
        <link
            href="{{asset('vendor/fontawesome-free/css/all.min.css')}}"
            rel="stylesheet"
            type="text/css">
        <link
            href="{{asset('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i')}}"
            rel="stylesheet">
        
        <!-- Custom styles for this template -->
        <!-- <link href="{{asset('css/sb-admin-2-copy.min.css')}}" rel="stylesheet"> -->
        <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/fixed-columns.min.css')}}" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link
            href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}"
            rel="stylesheet">

        <link rel="icon" href="{{asset('img/logo.png')}}">

        <script src="{{asset('js/animate.min.js')}}"></script>
        
        <link rel="stylesheet" href="{{asset('vendor/select2/select2.min.css')}}"/>
        <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
    </head>

    <body id="page-top">

        <div class="se-pre-con">  
        </div>
        
        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav sidebar bg-gradient-vine sidebar-dark accordion" id="accordionSidebar">
                <!-- Sidebar - Brand -->
                <a
                    class="sidebar-brand d-flex align-items-center justify-content-center"
                    href="#">
                    <div class="sidebar-brand-text mx-3">
                    @if(Session::get('role') == 'master')
                    MASTER
                    @elseif(Session::get('role') == 'manajer')
                    MANAJER
                    @elseif(Session::get('role') == 'admin')
                    ADMIN
                    @else
                    WHO ARE YOU ?
                    @endif
                    </div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' || Session::get('role') == 'admin')
                <!-- Nav Item - Dashboard -->
                <li class="nav-item {{ (request()->is('dashboard*')) ? 'active' : '' }}"  >
                    <a class="nav-link" href="{{url('dashboard')}}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></a>
                </li>
                <!-- Divider -->
                <hr class="sidebar-divider">
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'manajer'||  Session::get('role') == 'admin' && (Session::get('otoritas')->pedagang || Session::get('otoritas')->tempatusaha || Session::get('otoritas')->tagihan || Session::get('otoritas')->publish || Session::get('otoritas')->layanan || Session::get('otoritas')->neraca))
                <!-- Heading -->
                <div class="sidebar-heading">
                    Sumber Daya
                </div>

                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->layanan))
                <!-- Nav Item - Pedagang -->
                <li class="nav-item {{ (request()->is('layanan*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('layanan')}}">
                        <i class="fas fa-fw fa-headset"></i>
                        <span>Layanan</span></a>
                </li>
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->pedagang))
                <!-- Nav Item - Pedagang -->
                <li class="nav-item {{ (request()->is('pedagang*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('pedagang')}}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Pedagang</span></a>
                </li>
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' ||  Session::get('role') == 'admin' && (Session::get('otoritas')->tempatusaha))
                <!-- Nav Item - Tempat Usaha -->
                <li class="nav-item {{ (request()->is('tempatusaha*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('tempatusaha')}}">
                        <i class="fas fa-fw fa-store"></i>
                        <span>Tempat Usaha</span></a>
                </li>
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->tagihan || Session::get('otoritas')->publish || Session::get('otoritas')->neraca))
                <!-- Nav Item - Tagihan -->
                <li class="nav-item {{ (request()->is('tagihan*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('tagihan')}}">
                        <i class="fas fa-fw fa-plus"></i>
                        <span>Tagihan</span></a>
                </li>
                @endif
                <!-- Divider -->
                <hr class="sidebar-divider">
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->pemakaian || Session::get('otoritas')->pendapatan || Session::get('otoritas')->datausaha))
                <!-- Heading -->
                <div class="sidebar-heading">
                    Report
                </div>

                @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' ||  Session::get('role') == 'admin' && (Session::get('otoritas')->pemakaian || Session::get('otoritas')->pendapatan))
                <!-- Nav Item - Laporan -->
                <li class="nav-item {{ (request()->is('rekap/*')) ? 'active' : '' }}">
                    <a
                        class="nav-link collapsed"
                        href="#"
                        data-toggle="collapse"
                        data-target="#collapsePages"
                        aria-expanded="true"
                        aria-controls="collapsePages">
                        <i class="fa fa-fw fa-book"></i>
                        <span>Laporan</span>
                    </a>
                    <div
                        id="collapsePages"
                        class="collapse {{ (request()->is('rekap/*')) ? 'show' : '' }}"
                        aria-labelledby="headingPages"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' || Session::get('role') == 'admin' && (Session::get('otoritas')->pemakaian))
                            <a class="collapse-item {{ (request()->is('rekap/pemakaian')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('rekap/pemakaian')}}">Pemakaian</a>
                            @endif
                            @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' || Session::get('role') == 'admin' && (Session::get('otoritas')->pendapatan))
                            <a class="collapse-item {{ (request()->is('rekap/pendapatan')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('rekap/pendapatan')}}">Pendapatan</a>
                            @endif
                        </div>
                    </div>
                </li>
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'manajer' || Session::get('role') == 'admin' && (Session::get('otoritas')->datausaha))
                <!-- Nav Item - Data -->
                <li class="nav-item {{ (request()->is('datausaha*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('datausaha')}}">
                        <i class="fa fa-fw fa-list"></i>
                        <span>Data Usaha</span></a>
                </li>
                @endif
                <!-- Divider -->
                <hr class="sidebar-divider">
                @endif

                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->blok || Session::get('otoritas')->alatmeter || Session::get('otoritas')->tarif || Session::get('otoritas')->harilibur || Session::get('otoritas')->simulasi))
                <!-- Heading -->
                <div class="sidebar-heading">
                    Others
                </div>
                @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->blok || Session::get('otoritas')->alatmeter || Session::get('otoritas')->tarif || Session::get('otoritas')->harilibur || Session::get('otoritas')->simulasi))
                <!-- Nav Item - Utilities -->
                <li class="nav-item {{ (request()->is('utilities/*')) ? 'active' : '' }}">
                    <a 
                        class="nav-link collapsed" 
                        href="#" 
                        data-toggle="collapse" 
                        data-target="#utilities" 
                        aria-expanded="true" 
                        aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Utilities</span>
                    </a>
                    <div 
                        id="utilities" 
                        class="collapse {{ (request()->is('utilities/*')) ? 'show' : '' }}" 
                        aria-labelledby="headingTwo" 
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->tarif))
                            <a class="collapse-item {{ (request()->is('utilities/tarif*')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('utilities/tarif')}}">Tarif</a>
                            @endif
                            @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->alatmeter))
                            <a class="collapse-item {{ (request()->is('utilities/alatmeter*')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('utilities/alatmeter')}}">Alat Meter</a>
                            @endif
                            @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->harilibur))
                            <a class="collapse-item {{ (request()->is('utilities/harilibur*')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('utilities/harilibur')}}">Hari Libur</a>
                            @endif
                            @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->blok))
                            <a class="collapse-item {{ (request()->is('utilities/blok*')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('utilities/blok')}}">Blok</a>
                            @endif
                            @if(Session::get('role') == 'master' || Session::get('role') == 'admin' && (Session::get('otoritas')->simulasi))
                            <a class="collapse-item {{ (request()->is('utilities/simulasi*')) ? 'active' : '' }}" style="font-size:0.8rem;" href="{{url('utilities/simulasi')}}">Simulasi</a>
                            @endif
                        </div>
                    </div>
                </li>
                @endif
                
                @if(Session::get('role') == 'master')
                 <!-- Nav Item - User -->
                 <li class="nav-item {{ (request()->is('master/kasir*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('master/kasir')}}">
                        <i class="fas fa-fw fa-dollar-sign"></i>
                        <span>Kasir</span></a>
                </li>
                
                <!-- Nav Item - User -->
                <li class="nav-item {{ (request()->is('user*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('user')}}">
                        <i class="fas fa-fw fa-users"></i>
                        <span>User</span></a>
                </li>

                <!-- Nav Item - Log -->
                <li class="nav-item {{ (request()->is('log*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{url('log')}}">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Login</span></a>
                </li>
                @endif
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
                @endif

            </ul>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">

                        <!-- Sidebar Toggle (Topbar) -->
                        <button
                            id="sidebarToggleTop"
                            class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    id="userDropdown"
                                    role="button"
                                    data-toggle="dropdown"
                                    data-target="#logoutDropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Session::get('username')}}</span>
                                    <img class="img-profile rounded-circle" src="{{asset('img/icon_user.png')}}">
                                </a>
                                <!-- Dropdown - User Information -->
                                <div
                                    id="logoutDropdown"
                                    class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <a
                                        class="dropdown-item"
                                        href="#"
                                        data-toggle="modal"
                                        data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>
                    <!-- End of Topbar -->

                    <!-- Begin Content -->
                    @include('message.flash-message') 
                    @include('message.password-message') 
                    @include('message.update-message') 
                    
                    @yield('content')
                    <!-- End Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy;2020 PT Pengelola Pusat Perdagangan Caringin</span>
                            </div>
                        </div>
                    </footer>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->
        </div>

        @yield('modal')

        <!-- Logout Modal-->
        <div
            class="modal fade"
            id="logoutModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
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

        <script>
            $(window).load(function () {
                $(".se-pre-con")
                    .fadeIn("slow")
                    .fadeOut("slow");;
            });
        </script>

        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <!-- <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script> -->

        <!-- Core plugin JavaScript-->
        <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
        <script src="{{asset('js/autocomplete.js')}}"></script>

        <!-- Page level plugins -->
        <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

        <!-- Button -->
        <script src="{{asset('js/datatables.buttons.min.js')}}"></script>
        <script src="{{asset('js/jszip.min.js')}}"></script>
        <script src="{{asset('js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>

        <script src="{{asset('js/fixed-columns.min.js')}}"></script>

        <!--for column table toggle-->
        <script>
            $(document).ready(function() {
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
                    $($.fn.dataTable.tables( true ) ).DataTable().columns.adjust().draw();
                } );
            });
        </script>
        
        @yield('js')
        
    </body>
</html>