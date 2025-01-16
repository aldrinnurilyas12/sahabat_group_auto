<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buat E-Ticket - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
    
                <div id="content">
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data E-Ticket</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;width:100%;" class="form-group-content">
                        <div style="display: block;" class="container-infromation">
                            <div style="width: 300px; height:max-content; padding:8px;" class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi Akun </h6>
                                </div>
                                <div style="color:black;" class="card-body">
                                   <label for=""><strong>Requester</strong></label>
                                   <p><?php echo app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name  ?></p>

                                   <label for=""><strong>Kantor</strong></label>
                                   <p><?php echo app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name  ?></p>

                                   <label for=""><strong>Department</strong></label>
                                   <p><?php echo app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name  ?></p>
                                </div>
                            </div>

                            <div style="width: 300px; height:max-content; padding:8px;" class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Informasi pembuatan E-Ticket</h6>
                                </div>
                                <div style="color: black;" class="card-body">
                                    <ul>
                                        <li>Pembuatan E-Ticket diajukan untuk mengajukan perbaikan pada Software/Hardware PT Sahabat Group Auto</li>
                                        <br>
                                        <li>Pembuatan E-Ticket hanya bisa dilakukan 1 kali sehari dan dibuka pada jam 13</li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>

                        <form class="form_input" method="POST" action="{{ route('master_eticket.store')}}" enctype="multipart/form-data">
                            @csrf   
                            <div class="form-group">
                                <label>Kategory Tiket</label>
                                <select class="form-control" name="eticket_category" id="">
                                    <option value="#">=== Pilih Kategori Tiket ===</option>
                                @foreach ($eticket_category as $category)
                                    <option value="{{$category->menu_name . ' - ' . $category->submenu_name}}">{{$category->menu_name . ' - ' . $category->submenu_name}}</option>     
                                @endforeach
                                </select>
                                @if ($errors->has('eticket_category'))
                                <span class="text-danger">{{ $errors->first('eticket_category') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="title" autocomplete="off" placeholder="Masukan Judul E-Tiket">
                                @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Permasalahan</label>
                               <textarea class="form-control" name="main_issue" id="" cols="30" rows="5" placeholder="Masukan permasalahan yang dihadapi"></textarea>
                               @if ($errors->has('main_issue'))
                               <span class="text-danger">{{ $errors->first('main_issue') }}</span>
                               @endif
                            </div>

                            <div class="form-group">
                                <label>Lampiran</label>
                                <input type="file" class="form-control" name="attachment_files" autocomplete="off">
                            </div>

                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
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
      
        .form_input {
            width: 60%;
        }


    @media only screen and (max-width: 390px) {
    .form_input{
    width: 100%;
    color: rgb(0, 0, 0);
    }
    }
    </style>
  

</body>

<script>
    window.addEventListener('load', function() {
       var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
   
       // Log elemen untuk memastikan spinner ditemukan
         // Cek apakah elemen ditemukan
   
       if (loadingSpinnerWrapper) {
           // Menampilkan spinner saat halaman dimuat
           loadingSpinnerWrapper.style.display = 'flex';
          
   
           // Menyembunyikan spinner setelah 2 detik (2000ms)
           setTimeout(function() {
               
               loadingSpinnerWrapper.style.display = 'none';  // Sembunyikan spinner setelah 2 detik
           }, 1000);  // 2000ms = 2 detik
       } else {
           console.log("Elemen spinner tidak ditemukan!");
       }
   });
   </script>

</html>