<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Edit data Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div  id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">PERNYATAAN RESIGN KARYAWAN</h4>
                <div class="form-group-content">
                
                @foreach ($employee as $emp)      
                <form class="form_input" method="POST" action="{{ route('resign_approval', $emp->id)}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                    <label>NIK</label>
                    <input type="text" class="form-control" value="{{$emp->nik }}" readonly autocomplete="off">
                
                    </div>
                    <div class="form-group">
                        <label>Nama Karyawan </label>
                        <input type="text" class="form-control" value="{{$emp->name}}" readonly autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Alamat </label>
                        <input type="text" class="form-control" value="{{$emp->address}}" readonly  autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Posisi Pekerjaan </label>
                        <input type="text" class="form-control" value="{{$emp->address}}" readonly  autocomplete="off">
                    </div>
                    
                    <div class="form-group">
                        <label>Tanggal Mulai Bekerja</label>
                        <input readonly type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $emp->start_date ? $start_date->format('Y-m-d'):null) }}" autocomplete="off">
                        
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="">Alasan Resign<span style="color: red">*</span></label>
                        <select class="form-control" name="resign_reasons" id="kategori_resign">
                            <option value="">=== Pilih Alasan Resign ===</option>
                            <option value="Alasan Pribadi">Alasan Pribadi</option>
                            <option value="Alasan Karier">Alasan Karier</option>
                            <option value="Masalah Lingkungan Kerja">Masalah Lingkungan Kerja</option>
                            <option value="Masalah Kompensasi dan Tunjangan">Masalah Kompensasi dan Tunjangan</option>
                            <option value="Perubahan dalam Perusahaan">Perubahan dalam Perusahaan</option>
                            <option value="Memulai Usaha Sendiri">Memulai Usaha Sendiri</option>
                            <option value="Pensiun">Pensiun</option>
                            <option value="Ketidakpuasan dengan Pengembangan Karier">Ketidakpuasan dengan Pengembangan Karier</option>
                            <option value="Masalah Kesehatan">Masalah Kesehatan</option>
                            <option value="Kelelahan atau Burnout">Kelelahan atau Burnout</option>
                        </select>
                        @if ($errors->has('resign_reasons'))
                        <span class="text-danger">{{ $errors->first('resign_reasons') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label>Tanggal Resign<span style="color: red">*</span></label>
                        <input type="date" class="form-control" id="start_date" name="resign_date" autocomplete="off">
                        @if ($errors->has('resign_date'))
                        <span class="text-danger">{{ $errors->first('resign_date') }}</span>
                        @endif
                    </div>

                    
                
                    <div class="form-group">
                    
                   <input type="text" name="is_active" value="N" hidden>
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