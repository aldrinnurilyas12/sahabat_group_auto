<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit data Sub Menu - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                
                {{-- content --}}


                <div id="content">
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Edit User Admin</h4>
                    @foreach($submenu as $sub)
                    <div class="form-group-content">
                    <form class="form_input" method="POST" action="{{ route('edit_submenu.update',['id' => $sub->id])}}">
                      
                        @csrf
                        @method('PUT')
                
                        <div class="form-group">
                            <input type="text" name="id" class="form-control" disabled autocomplete="off" value="{{$sub->id}}" hidden>
                        </div>
                        
                        <div class="form-group">
                            <label >Nama Submenu</label>
                            <input name="submenu_name" type="text" class="form-control" autocomplete="off" value="{{$sub->submenu_name}}">
                        </div>

                        <div class="form-group">
                            <label >Icon</label>
                            <input name="submenu_icons" type="text" class="form-control" autocomplete="off" value="{{$sub->submenu_icons}}">
                        </div>

                        <div class="form-group">
                            <label >Link</label>
                            <input name="submenu_link" type="text" class="form-control" autocomplete="off" value="{{$sub->submenu_link}}">
                        </div>

                        <div class="form-group">
                            
                            <input name="parent_id" type="text" class="form-control" autocomplete="off" value="{{$sub->parent_id}}" hidden>
                        </div>
                        @endforeach

                        <div class="form-group">
                            <label for="">Pilih Role</label>
                            @if($submenu)
                            <input type="checkbox" value="Y"  name="superadmin_role"
                            @if($usr_role['superadmin_role'] === 'Y') checked @endif> Super Admin
                            <br>
                            <input type="checkbox" value="Y" name="admin_role"
                            @if($usr_role['admin_role'] === 'Y') checked @endif> Admin 
                            <br>
                            <input type="checkbox" value="Y" name="branch_head_role"
                            @if($usr_role['branch_head_role'] === 'Y') checked @endif> Branch Head
                            @else

                            @endif
                        </div>
                       
                        <div class="form-group">
                            <label>Aktif?</label>
                            <select class="form-control" name="is_active" id="">
                                <option value="Y">Ya</option>
                                <option value="N">Tidak</option>
                            </select>
                            </div>

                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>  
                    </div>
                </div>
    
            </div>
           
            @include('layouts.admin_views.footer')
        
        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
      </div>
      
      <style>
        #loadingSpinnerWrapper {
        position: fixed; /* Fix posisi spinner */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: none; /* Spinner disembunyikan saat halaman dimuat */
        justify-content: center; /* Horizontal center */
        align-items: center; /* Vertical center */
        background-color: rgba(0, 0, 0, 0.517); /* Background semi-transparan */
        z-index: 9999; /* Pastikan spinner berada di atas konten lainnya */
      }
      
      .spinner-border {
        color: yellow;
        width: 3rem;
        height: 3rem; /* Pastikan tinggi spinner diatur */
      }
      
      </style>
  

    
</body>
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>

    <script>
        window.addEventListener('load', function() {
           var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
       
           // Log elemen untuk memastikan spinner ditemukan
           console.log(loadingSpinnerWrapper);  // Cek apakah elemen ditemukan
       
           if (loadingSpinnerWrapper) {
               // Menampilkan spinner saat halaman dimuat
               loadingSpinnerWrapper.style.display = 'flex';
               console.log("Spinner muncul, timer akan dimulai.");
       
               // Menyembunyikan spinner setelah 2 detik (2000ms)
               setTimeout(function() {
                   console.log("2 detik berlalu, menyembunyikan spinner.");
                   loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
               }, 1000);  // 2000ms = 2 detik
           } else {
               console.log("Elemen spinner tidak ditemukan!");
           }
       });
       </script>
</html>