<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Tambah data Kredit Simulasi - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div  id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Simulasi Kredit</h4>
                <div class="form-group-content">
                
                        
                <form class="form_input" method="POST" action="{{ route('master_credit_simulation.store')}}">
                    @csrf
                    <div class="form-group">
                        @foreach($vehicle as $car)
                        <div class="form-group">
                            <label>Unit</label>
                        
                                <input type="text" class="form-control" name="vehicle_id" value="{{$car->id}}" hidden autocomplete="off">
                                <input type="text" class="form-control"  value="{{$car->brand .' '. $car->vehicle_type .' '. $car->manufacture_year}}" readonly autocomplete="off">
                        
                        </div>
                        <div class="form-group">
                            <label>Harga Unit</label>
                            @if($vehicle->first()->credit_price)
                            <input type="text" class="form-control"  value="{{"Rp " . number_format($car->credit_price)}}" autocomplete="off" readonly>
                            @else
                            <input type="text" class="form-control" placeholder="TIDAK ADA HARGA KREDIT, MASUKAN HARGA KREDIT DAHULU..." readonly>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="">Jenis Insurance</label>
                    
                            <select class="form-control" name="insurance_id" id="">
                                <option value="">--- pilih insurance---</option>
                                @foreach($insurance as $insurances)
                                <option value="{{$insurances->id}}">{{$insurances->insurance_name}}</option>
                                @endforeach
                            </select>
                        
                    </div>
                
                    <div class="form-group">
                        <label>Harga DP</label>
                        <input type="text" class="form-control" name="down_payment"  placeholder="Masukan harga dp kendaraan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 12 Month</label>
                        <input type="text" class="form-control" name="tenor_12_month"  placeholder="Masukan biaya tenor 12 bulan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 24 Bulan</label>
                        <input type="text" class="form-control" name="tenor_24_month"  placeholder="Masukan biaya tenor 24 bulan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 36 Bulan</label>
                        <input type="text" class="form-control" name="tenor_36_month"  placeholder="Masukan biaya tenor 36 bulan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 48 Bulan</label>
                        <input type="text" class="form-control" name="tenor_48_month"  placeholder="Masukan biaya tenor 48 bulan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 60 Bulan</label>
                        <input type="text" class="form-control" name="tenor_60_month"  placeholder="Masukan biaya tenor 60 bulan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tenor 72 Bulan</label>
                        <input type="text" class="form-control" name="tenor_72_month"  placeholder="Masukan biaya tenor 72 bulan" autocomplete="off">
                    </div>

                    @if($vehicle->first()->credit_price)
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    @else
                    <button type="button" class="btn btn-dark">Simpan</button>
                    @endif
                </form> 
            
                </div>
            </div>

            @include('layouts.admin_views.footer')
        
        </div>

    
    </div>

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



@if (session('alert'))
    <script type="text/javascript">
        alert('{{ session('alert') }}');
    </script>
@endif

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
