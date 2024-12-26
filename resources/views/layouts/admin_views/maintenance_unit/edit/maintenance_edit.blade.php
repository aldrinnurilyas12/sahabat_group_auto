<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit data Maintenance - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Edit Cabang</h4>
                    @foreach($maintenance_data as $mtc)
                    <div class="form-group-content">
                  
                        <form class="form_input" method="POST" action="{{ route('maintenance_update', $mtc->id)}}">
                            @csrf   
                            @method('PUT')

                            <div class="form-group">
                                <label >Unit Kendaraan</label>
                                <select class="form-control" name="vehicle_id" id="">
                                    <option value="#">=== Pilih Unit ===</option>
                                @foreach ($vehicle_data as $vehicle)
                                    <option value="{{$vehicle->id}}" {{$vehicle->id == $mtc->vehicle_id ? 'selected' : '' }}>{{$vehicle->unit}}</option>     
                                @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label >Tipe Perbaikan Unit</label>
                                <select class="form-control" name="maintenance_type" id="">
                                    <option value="">=== Pilih Tipe Perbaikan ===</option>
                                    @foreach($maintenance_category as $ctg)
                                    <option value="{{$ctg->category_name}}" {{$ctg->category_name == $mtc->maintenance_type ? 'selected' : '' }}>{{$ctg->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label >Detail Perbaikan</label>
                                <textarea  class="form-control" name="maintenance_detail" autocomplete="off" placeholder="Masukan Detail perbaikan"> {{$mtc->maintenance_detail}} </textarea>
                            </div>

                            <div class="form-group">
                                <label >Biaya Perbaikan</label>
                                <input type="text" class="form-control" value="{{$mtc->cost}}" name="cost" autocomplete="off" placeholder="Masukan biaya perbaikan">
                            </div>

                            <div class="form-group">
                                <label >Tanggal Perbaikan Unit</label>
                                <input type="date" class="form-control" name="maintenance_date" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label >Mekanik</label>
                                <select class="form-control" name="mechanic_name" id="">
                                    <option value="">=== Pilih Mekanik ===</option>
                                    @foreach($mechanic as $mekanik)
                                    <option value="{{$mekanik->name}}" {{$mekanik->name == $mtc->mechanic_name ? 'selected' : '' }}>{{$mekanik->nik . ' - ' . $mekanik->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                           
                            
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>  
                        @endforeach
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