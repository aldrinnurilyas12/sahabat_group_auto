<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah data posisi pekerjaan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                        <form class="form_input" method="POST" action="{{ route('master_employee_salary.store')}}">
                            @csrf   
                            
                            <div class="form-group">
                                <label>Posisi Pekerjaan</label>
                                <input type="text" class="form-control"  name="position_name" placeholder="Masukan Posisi Pekerjaan " autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Pilih Department</label>
                                    <select class="form-control" name="department_id">
                                        <option value="">=== Pilih Department ===</option>
                                        @foreach($department as $dept)
                                        <option value="{{$dept->id}}">{{$dept->department_name}}</option>
                                        @endforeach
                                    </select>
                               </div>

                            <div class="form-group">
                                <label>Gaji</label>
                                <input type="text" class="form-control"  name="salary" placeholder="Masukan Gaji" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Transport</label>
                                <input type="text" class="form-control"  name="tunjangan_transport" placeholder="Masukan tunjangan Transportasi " autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Kesehatan</label>
                                <input type="text" class="form-control"  name="tunjangan_kesehatan" placeholder="Masukan Tunjangan Kesehatan " autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Lainnya </label>
                                <input type="text" class="form-control"  name="tunjangan_lainnya" placeholder="Masukan Tunjangan Lainnya (Opsional) " autocomplete="off">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>  


                        {{-- <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Informasi pembuatan akun admin</h6>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Pembuatan akun admin ditujukan untuk seseorang/karyawan dalam mengelola kontent website Sahabat Group</li>
                                    <br>
                                    <li>Pembuatan akun hanya bisa dilakukan oleh role Super Admin</li>
                                    <br>
                                    <li>1 (Satu) akun hanya bisa 1 akses portal website Sahabat Group</li>
                                </ul>
                                
                            </div>
                        </div> --}}
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
</body> 
      
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
    
    <script>
        window.addEventListener('load', function() {
           var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');
       
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