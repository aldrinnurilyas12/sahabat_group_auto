<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Promosikan Unit Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
<div id="wrapper">

    @include('layouts.admin_views.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div  id="content">
            @include('layouts.admin_views.header')
            <h4 style="text-align:center;color:black;font-weight:bold;">Pemasaran Unit Kendaraan</h4>
            <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                
            <form style="width: 60%;" class="form_input" method="POST" action="{{ route('email_marketing_vehicle.store')}}" enctype="multipart/form-data">
                @csrf
                @foreach ($vehicle_data as $vehicle)
                    
                <hr>
                <h6 style="color: black;"><strong>Detail Unit Kendaraan</strong></h6>
                <hr>
               
                <input hidden type="text" name="vehicle_id" class="form-control" value="{{$vehicle->id}}" readonly autocomplete="off">

                <div class="form-group">
                    <label >VIN/NO.POL Kendaraan <span style="color: red">*</span></label>
                    <input type="text" class="form-control" value="{{$vehicle->vehicle_registration_number}}" readonly autocomplete="off">
                </div>

                <div class="form-group">
                    <label >Unit Kendaraaan</label>
                    <input type="text" class="form-control" value="{{$vehicle->unit}}" readonly autocomplete="off">
                </div>

                <div class="form-group">
                    <label >Harga Unit</label>
                    <input type="text" class="form-control" value="{{$vehicle->price}}" readonly autocomplete="off">
                </div>

                <div class="form-group">
                    <label >Harga Kredit Unit</label>
                    <input type="text" class="form-control" value="{{$vehicle->credit_price}}" readonly autocomplete="off">
                </div>
                <hr>
                <h6 style="color: black;"><strong>Email Marketing</strong></h6>
                <hr>
                <div class="form-group">
                    <label >Subjek Email</label>
                    <input type="text" class="form-control" placeholder="Masukan subjek email" name="subject" autocomplete="off">
                </div>

                <div class="form-group">
                    <label >Judul Email</label>
                    <input type="text" class="form-control" placeholder="Masukan judul email" name="title" autocomplete="off">
                </div>

                <div class="form-group">
                    <label >Konten Email</label>
                   <textarea class="form-control" placeholder="Masukan konten email" name="description" id="" cols="30" rows="10"></textarea>
                </div>
            
                <div class="form-group">
                    <label for="">Gunakan Link?</label>
                    <input style="margin-bottom: 10px;" type="text" class="form-control" name="link" value="{{strtolower($vehicle->brand . '-'. $vehicle->vehicle_type . '-' . $vehicle->manufacture_year)}}" readonly autocomplete="off">
                    <input name="requestlink" id="ya" type="radio" value="ya">&nbsp; Ya
                    <br>
                    <input name="requestlink" id="no" type="radio" value="tidak">&nbsp; Tidak
                 </div>
                
                @endforeach
                <button type="submit" class="btn btn-primary">Kirim Email</button>
            
            </form> 

            <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi tambah data kendaraan</h6>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Penambahan master data kendaraan diharapkan benar</li>
                        <br>
                        <li>User bisa melakukan upload foto dan dokumen kendaraan</li>
                        <br>
                        <li>Upload Foto kendaraan hanya bisa setelah upload master data kendataan dan Ketentuan upload gambar dengan format : JPEG, JPG, PNG, jpeg,jpg</li>
                        <br>
                        <li>Ketentuan upload dokumen seperti dokumen STNK & BPKB serta dokumen lainnya</li>
                    </ul>
                    
                </div>
            </div>

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



