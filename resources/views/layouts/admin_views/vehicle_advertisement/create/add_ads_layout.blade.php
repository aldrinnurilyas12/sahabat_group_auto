<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Posting Iklan Unit Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Iklan Kendaraan</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                        @if($vehicle_data->first()->foto)
                        <div style="display: block;" class="d-block-image">
                            <label for="">Foto iklan saat ini</label>
                            <div style="display: flex;flex-wrap:wrap;margin-top:10px;" class="img-display">
                                <img height="100" width="100" src="{{ asset('storage/' . $vehicle_data->first()->foto) }}">
                            </div>
                            <br>
                            <br>
                            <label for="">Pilih foto terbaru</label>

                            <form class="form-input" action="{{route('update_foto', $vehicle_data->first()->vehicle_id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div style="display: flex; flex-wrap:wrap; gap:10px;" class="dflex-images">
                                    @foreach ($vehicle_images as $galery)
                                        <div style="display: block;" class="d-block-image">
                                            <div style="display: flex;flex-wrap:wrap;margin-top:10px;" class="img-display">
                                                <img height="200" width="200" src="{{ asset('storage/' . $galery->images) }}">
                                            </div>
                                            <br>
                                            <input style="height:20px;width:20px;" type="radio" value="{{$galery->images}}" name="foto">
                                        </div>
                                    @endforeach
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary">Perbarui Foto</button>
                            </form>
                            
                        </div>
                        @else
                        @foreach ($vehicle_data as $vhcl)
                        <form class="form_input" method="POST" action="{{ route('master_vehicle_advertisement.store')}}">
                            @csrf   
                            
                            <div class="form-group">
                                <label >Unit</label>
                                <input type="text" class="form-control" value="{{$vhcl->vehicle_id}}" name="vehicle_id" hidden autocomplete="off" readonly>
                                <input  type="text" class="form-control" value="{{$vhcl->unit}}" autocomplete="off" readonly>
                            </div>

                            <div class="form-group">
                                <label >Harga Unit</label>
                                <input  type="text" class="form-control" value="{{"Rp " . number_format($vhcl->price)}}" autocomplete="off" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Pilih foto untuk tampilan depan</label>
                                <small style="font-style: italic; color:gray;">*hanya 1 foto</small>
                                <br>
                                <div style="display: flex; flex-wrap:wrap;gap:5px;" class="container-image">
                                    @if ($vehicle_images->isEmpty())
                                    <p>Tidak ada foto tersedia, <span style="color: blue;text-decoration:underline;"><a href="{{route('detail_vehicle', $vhcl->vehicle_id )}}">Upload foto dahulu.</a><i class="fa fa-share"></i></span></p>
                                        
                                    @elseif($vehicle_data->first()->foto == null)
                                        @foreach ($vehicle_images as $galery)
                                        <div style="display: block;" class="d-block-image">
                                            <div style="display: flex;flex-wrap:wrap;margin-top:10px;" class="img-display">
                                                <img height="200" width="200" src="{{ asset('storage/' . $galery->images) }}">
                                            </div>
                                            <br>
                                            <input style="height:20px;width:20px;" type="radio" value="{{$galery->images}}" name="foto">
                                            
                                        </div>
                                        @endforeach
                                    @else
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <input hidden type="text" name="is_active" value="Y">
                            </div>

                            @if ($vehicle_images->isEmpty())
                            <button type="button" class="btn btn-secondary">Simpan Iklan</button>
                            @else
                            <button type="submit" class="btn btn-primary">Simpan Iklan</button>
                            @endif
                        </form>  
                        @endforeach
                        @endif


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

@if (Session::has('message_success'))
<script>
    Swal.fire({
        title: 'Berhasil',
        text: "{{ Session::get('message_success') }}",
        icon: 'success',
        timer:2000,
        confirmButtonText: 'OK'
    });
</script>
    
@endif
    
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