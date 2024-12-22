<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title> Edit Presensi Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
<div id="wrapper">

    @include('layouts.admin_views.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div  id="content">
            @include('layouts.admin_views.header')
            <h4 style="text-align:center;color:black;font-weight:bold;">Edit Data Presensi Karyawan</h4>
            <div class="form-group-content">
            
            @foreach ($employee_attedance as $emp)      
            <form class="form_input" method="POST" action="{{ route('edit_employee_attedance.update', $emp->id)}}">
                @csrf
                @method('PUT')

                <div class="form-group">
                <input hidden type="text" class="form-control" name="employee_id" value="{{$emp->employee_id }}" readonly autocomplete="off">
                <div class="form-group">
                    <label >NIK <span style="color: red">*</span></label>
                    <input type="text" class="form-control" name="nik" value="{{$emp->nik }}" readonly autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Nama Karyawan</label>
                    <input type="text" class="form-control" name="nik" value="{{$emp->name }}" readonly autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Tipe Kehadiran</label>
                    <div style="display: block;" class="listed-option">
                        <input type="radio" value="hadir" name="attedance_type" > Hadir
                        <input type="radio" value="izin" name="attedance_type" > Izin
                        <input type="radio" value="sakit" name="attedance_type" > Sakit
                    </div>
                    @error('attedance_type')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="form-group">
                    <label>Alasan</label>
                    <input type="text" class="form-control" name="reasons" value="{{$emp->reasons}}" placeholder="Masukan alasan jika izin" autocomplete="off">
                </div>
                <div class="form-group">
                    <label >Tanggal Presensi</label>
                    <input type="text" class="form-control" value="{{$emp->attedance_date}}" name="attedance_date" readonly autocomplete="off">
                    @error('attedance_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
               
                
               
                <button type="submit" class="btn btn-primary">Ubah</button>
            </form> 
            @endforeach
           
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