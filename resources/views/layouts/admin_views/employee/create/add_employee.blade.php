<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link
    href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{asset('assets/css/form.css')}}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<title>Tambah data Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div  id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Karyawan</h4>
                <div class="form-group-content">
                
                        
                <form class="form_input" method="POST" action="{{ route('master_employee.store')}}">
                    @csrf
                    <div class="form-group">
                        <label >NIK <span style="color: red">*</span></label>
                        <input type="text" class="form-control" name="nik" placeholder="Masukan NIK 6 digit terakhir" autocomplete="off">
                        <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                    </div>
                    <div class="form-group">
                        <label >Nama Karyawan</label>
                        <input type="text" class="form-control" name="name"  placeholder="Masukan nama karyawan" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" name="address"  placeholder="Masukan alamat" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">No.Telepon</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                            <div class="input-group-text">+62</div>
                            </div>
                            <input type="text" class="form-control" name="phone_number" placeholder="Masukan nomor telepon/hp karyawan" autocomplete="off">
                        </div>
                        </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="text" class="form-control" name="email"  placeholder="Masukan email" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="">Cabang</label>
                    
                            <select class="form-control" name="branch_id" id="">
                                <option value="">--- pilih cabang ---</option>
                                @foreach($branch as $cabang)
                                <option value="{{$cabang->id}}">{{$cabang->location_code . " - " .$cabang->location_name}}</option>
                                @endforeach
                            </select>
                        
                    </div>
                    <div class="form-group">
                        <label for="">Posisi Pekerjaan</label>
                    
                            <select class="form-control" name="job_position" id="">
                                <option value="">--- pilih posisi pekerjaan---</option>
                                @foreach($job_position as $job)
                                <option value="{{$job->id}}">{{$job->position_name}}</option>
                                @endforeach
                            </select>
                        
                    </div>

                    <div class="form-group">
                        <label >Tanggal Lahir</label>
                        <input type="date" class="form-control" name="birth_date" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label >Tanggal Mulai Bekerja</label>
                        <input type="date" class="form-control" name="start_date" autocomplete="off">
                    </div>
                    <div class="form-group">
                    <label>Aktif?</label>
                    <select class="form-control" name="is_active" id="">
                        <option value="Y">Ya</option>
                        <option value="N">Tidak</option>
                    </select>
                    </div>

                
                    
                    <button type="submit" class="btn btn-primary">Simpan</button>
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