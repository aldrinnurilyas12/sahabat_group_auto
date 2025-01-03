<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Data Kantor Cabang - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Perbaikan Unit Kendaraan</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                        <form class="form_input" method="POST" action="{{ route('master_maintenance_unit.store')}}" enctype="multipart/form-data">
                            @csrf   

                            <div class="form-group">
                                <label >Unit Kendaraan</label>
                                <select class="form-control" name="vehicle_id" id="">
                                    <option value="#">=== Pilih Unit ===</option>
                                @foreach ($maintenance_data as $vehicle)
                                    <option value="{{$vehicle->id}}">{{$vehicle->unit}}</option>     
                                @endforeach
                                </select>
                                @if ($errors->has('vehicle_id'))
                                <span class="text-danger">{{ $errors->first('vehicle_id') }}</span>
                                @endif
                            </div>
                            
                            <div class="form-group">
                                <label >Tipe Perbaikan Unit</label>
                                <select class="form-control" name="maintenance_type" id="">
                                    <option value="">=== Pilih Tipe Perbaikan ===</option>
                                    @foreach($maintenance_category as $ctg)
                                    <option value="{{$ctg->category_name}}">{{$ctg->category_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('maintenance_type'))
                                <span class="text-danger">{{ $errors->first('maintenance_type') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label >Detail Perbaikan</label>
                                <textarea  class="form-control" name="maintenance_detail" autocomplete="off" placeholder="Masukan Detail perbaikan"> </textarea>
                            </div>

                            <div class="form-group">
                                <label >Biaya Perbaikan</label>
                                <input type="text" class="form-control" name="cost" autocomplete="off" placeholder="Masukan biaya perbaikan">
                                @if ($errors->has('cost'))
                                <span class="text-danger">{{ $errors->first('cost') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label >Tanggal Perbaikan Unit</label>
                                <input type="date" class="form-control" name="maintenance_date" autocomplete="off">
                                @if ($errors->has('maintenance_date'))
                                <span class="text-danger">{{ $errors->first('maintenance_date') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label >Mekanik</label>
                                <select class="form-control" name="mechanic_name" id="">
                                    <option value="">=== Pilih Mekanik ===</option>
                                    @foreach($mechanic as $mekanik)
                                    <option value="{{$mekanik->name}}">{{$mekanik->nik . ' - ' . $mekanik->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('mechanic_name'))
                                <span class="text-danger">{{ $errors->first('mechanic_name') }}</span>
                                @endif
                            </div>

                           <div class="form-group">
                            <label >Upload bukti pembayaran</label>
                            <input type="file" class="form-control" name="foto" autocomplete="off">
                            <p style="color: gray"> <small>*dokumen bisa berupa kwitansi/bon pembayaran</small></p>
                            @if ($errors->has('foto'))
                            <span class="text-danger">{{ $errors->first('foto') }}</span>
                            @endif
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