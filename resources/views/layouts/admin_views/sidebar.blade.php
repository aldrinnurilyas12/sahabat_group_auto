<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background: rgb(27, 0, 180);" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SAHABAT GROUP</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
            <ul class="navbar-nav">
                @foreach($sidebar_menu as $main)
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse{{ $main->id }}" aria-expanded="true" aria-controls="collapse{{ $main->id }}">
                        <i class="{{ $main->menu_icon }}"></i>
                        <span>{{ $main->menu_name }}</span>
                    </a>
                    <div id="collapse{{ $main->id }}" class="collapse" aria-labelledby="heading{{ $main->id }}" data-parent="#accordionSidebar">
                        <div class="py-2 collapse-inner rounded" style="padding: 10px;background:rgb(24, 0, 161);color:white;">
                            @foreach($grouped_sub_menu[$main->id] ?? [] as $sub)
                            <div style="display: flex;align-items:center;" class="grouped-icons">
                                <i class="{{ $sub->submenu_icons }}"></i>
                                <a style="color: white;hover:blue;" class="collapse-item" href="../../{{ $sub->submenu_link }}">{{ $sub->submenu_name }}</a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            

           
            <!-- Divider -->
            <hr class="sidebar-divider">

            
            <a style="color: rgb(255, 255, 255); background:rgba(17, 16, 16, 0.379);" class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                Logout
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">
          

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

      

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.js')}}"></script>
    {{-- <script src="{{url('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>  --}}
    

</body>

</html>