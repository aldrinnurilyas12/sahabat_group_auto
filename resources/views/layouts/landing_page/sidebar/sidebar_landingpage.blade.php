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
        {{-- <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet"> --}}
    <!-- Custom styles for this template-->
    

</head>

<body id="page-top">
   

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background-image: linear-gradient(to bottom, #16222A, #3A6073);padding:10px;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                
                <div class="sidebar-brand-text mx-3">PT Sahabat Group Auto</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div style="padding:10px; height:max-content;background:white;margin-bottom:10px;" class="card-filter">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Filter Brand</h6>
                </div>

                <div style="width: 100%;height:300px;background:white;overflow-y:scroll;padding:10px;" class="card-main">
                    <div style="display: inline-grid;width:100%;" class="brand-content">
                        <form action="{{ route('filter_brand/') }}" method="GET">
                            @if(is_array($brand) || is_object($brand))
                            @foreach($brand as $merk)
                                <div style="display: flex;" class="input-box">
                                    <input 
                                        type="radio" 
                                        name="brand_name" 
                                        value="{{ $merk->brand_name }}" 
                                        id="filterBrand_{{ $merk->id }}"
                                    >
                                    &nbsp;{{ $merk->brand_name }}
                                </div>
                            @endforeach
                        @else
                            {{-- Jika $brand adalah string atau tipe data lainnya, tampilkan semua brand --}}
                            @foreach($brands as $merk)  {{-- Pastikan $brands berisi semua data brand yang ingin ditampilkan --}}
                                <div style="display: flex;" class="input-box">
                                    <input 
                                        type="radio" 
                                        name="brand_name" 
                                        value="{{ $merk->brand_name }}" 
                                        id="filterBrand_{{ $merk->id }}"
                                    >
                                    &nbsp;{{ $merk->brand_name }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                </div>
                <br>
                <div style="display: flex; justify-content:space-between;" class="btn-flex">
                    <button class="btn btn-primary" type="submit">Filter</button>

                    <button class="btn btn-dark" type="submit">Reset</button>
                </div>
                </form>
                
            </div>
           

            <div style="padding:10px;background:white;" class="card-filter">
                <div class="card-header py-3">
                    <h6 style="color: rgb(0, 0, 0);" class="m-0 font-weight-bold">Filter Harga</h6>
                </div>

                <div style="width: 100%;height:max-content;background:white;overflow-y:scroll;padding:10px;" class="card-main">
                    <div style="display: inline-grid;width:100%;" class="brand-content">
                      
                        <form action="{{route('vehicle_price_range/')}}" action="GET">
                            <label for="">Harga awal</label>
                            <div style="width:100%;margin-bottom:10px;" class="input-box">
                                <input name="lower_price" style="width: 100%;" type="number"> 
                            </div>
                            <br>
                            <label for="">Hingga</label>
                            <div style="width:100%;" class="input-box">
                                <input name="high_price" style="width: 100%;" type="number"> 
                            </div>
                        
                    </div>
                  
                </div>
               <br>
                    <div style="display: flex; justify-content:space-between;" class="btn-filter">
                        <button class="btn btn-primary" style=""><i class="fa fa-search" aria-hidden="true"></i>
                            Cari
                        </button>

                        <button  class="btn btn-secondary" style="">
                            Reset
                        </button>
                        
                    </div>
                    </form>
            </div>
            

           
            <!-- Divider -->
            <hr class="sidebar-divider">

            
          

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

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

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    
    

</body>

</html>