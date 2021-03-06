<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Projeto</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" >
            <div class="sidebar-brand-icon">
                <img src="/img/logo.png" alt="Logo" class="logo-img">
            </div>
            <div class="sidebar-brand-text mx-3">DEI</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item -->
        <li class="nav-item {{Route::currentRouteName() == 'pages.index' ?  'active' : ''}}">
            <a class="nav-link" href="{{route('pages.index')}}">
                <i class="fas fa-fw fa-table"></i>
                <span>Apresentação</span></a>
        </li>

    @auth
        <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName() == 'estatisticas.index' ? 'sel' : ''}}">
                <a class="nav-link" href="{{route('estatisticas.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Estatisticas</span></a>
            </li>
            <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName() == 'conta.index' ? 'sel' : ''}}">
                <a class="nav-link" href="{{route('conta.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Contas</span></a>
            </li>
            <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName() == 'utilizadores.index' ? 'sel' : ''}}">
                <a class="nav-link" href="{{route('utilizadores.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Utilizadores</span></a>
            </li>
            <!-- Nav Item -->
            <li class="nav-item {{Route::currentRouteName() == 'definicoes.index' ? 'sel' : ''}}">
                <a class="nav-link" href="{{route('definicoes.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Definicões</span></a>
            </li>
    @endauth

    <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @guest
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="flex-center position-ref full-height">
                        @if (Route::has('login'))
                            <div class="top-right links">
                                @auth
                                    <a href="{{ route('logout') }}">Logout</a>
                                    <h4>Utilizador:{{ Auth::user()->name }}</h4>

                                @else
                                    <a href="{{ route('login') }}">Login</a>

                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </nav>
            @endguest

            @auth
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                @if(Auth::user()->foto==null)
                                    <td>
                                        <img class="img-profile rounded-circle" src="/img/default_img.png" width="50px"
                                             height="50px">
                                    </td>
                                @else
                                    <td>
                                        <img class="img-profile rounded-circle"
                                             src="{{ asset('storage/fotos/'.Auth::user()->foto)}}" width="50px"
                                             height="50px">
                                    </td>
                                @endif


                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                 aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{route('definicoes.index')}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Definições
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
        @endauth
        <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

            @if (session('alert-msg'))
                @include('partials.message')
            @endif
            @if ($errors->any())
                @include('partials.errors-message')
            @endif

            <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
                </div>

                <!-- Content Row -->
                <div class="row">
                    <div class="col">
                        @yield('content')
                    </div>

                </div>


            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Departamento de Engenharia Informática 2020</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>

@stack('scripts')

</body>

</html>
