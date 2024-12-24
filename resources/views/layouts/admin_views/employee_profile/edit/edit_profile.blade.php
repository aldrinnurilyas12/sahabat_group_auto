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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div style="background: white;">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Profil Pengguna [{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name}}]</h4>
                
                
                <div style="display: flex; flex-wrap:wrap;gap:30px;justify-content:center;width:100%;" class="form-group-content">

                    <div style="width: 320px; height:max-content; padding:8px;" class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="mb-2 font-weight-bold text-primary">Informasi akun</h6>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; justify-content:center;" class="profile-image-content">
                                
                                @if($user_picture->isNotEmpty())
                                <img style="border-radius:50%;" src="{{ asset('storage/' . $user_picture->first()->users_foto) }}" width="200" height="200" alt="">
                                @else
                                <strong class="text-danger">*Belum Upload Foto</strong>
                                @endif
                            </div>
                            <br>
                            <h4 style="font-size: 14px;color:rgb(1, 1, 1);text-align:center;"><strong>{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name}}</strong></h4>
                            <h4 style="font-size: 14px;color:rgb(178, 178, 178);text-align:center;font-style:italic;">{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name}}</h4>
                            <h4 style="font-size: 14px;color:rgb(0, 0, 0);text-align:center;font-style:italic;">{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name}}</h4>
                            <hr>
                           @if($user_picture->isNotEmpty())
                            <form action="{{route('update_picture',$employee->first()->id)}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label style="color: black;" for=""><strong>Ubah Foto</strong></label>
                                <input type="text" name="user_id" value="{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id}}" hidden>
                                <input type="file" name="users_foto">
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan Foto</button>
                            </form>
                            @else
                            <form action="{{route('users_picture')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label style="color: black;" for=""><strong>Pasang Foto</strong></label>
                                <input type="text" name="user_id" value="{{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id}}" hidden>
                                <input type="file" name="users_foto">
                                <br>
                                <br>
                                <button type="submit" class="btn btn-primary">Simpan Foto</button>
                            </form>

                            @endif
                            <br>
                            <hr>
                            
                            <div class="signature-img">
                                @if($signature_employee->isNotEmpty())
                                <div style="display: flex;justify-content:center;" class="center-signature">
                                    <img src="{{ asset('storage/' . $signature_employee->first()->signature) }}" width="80" height="80" alt="">
                                </div>
                                 @else
                                <strong class="text-danger">*Belum Upload Tanda Tangan</strong>
                                @endif

                                @if($signature_employee->isNotEmpty())
                                <div style="display: flex;justify-content:space-between;" class="signature-component">

                                    <div class="form-update-signature">
                                        <label style="color: black;" for=""><strong>Ubah Tanda Tangan</strong></label>
                                        <form action="{{Route('upload_update_signature', $employee->first()->id)}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <input type="file" name="signature">
                                            <br>
                                            <br>
                                            <button class="btn btn-primary">Upload</button>
                                            {{-- <a class="btn btn-danger" href="#" data-toggle="modal" data-target="#deleteSignature">Hapus</a> --}}
                                        </form>
                                    </div>

                                    
                                </div>
                                @else
                                <form action="{{Route('upload_signature')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label style="color: black;" for=""><strong>Upload Tanda Tangan Digital</strong></label>
                                    <input type="file" name="signature">
                                    <br>
                                    <br>
                                    <button class="btn btn-primary">Upload</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div style="width:70%; color:black;" class="container-content">
                        <div style="padding:8px;width:100%;" class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="mb-2 font-weight-bold text-primary">Informasi Data Diri</h6>
                                <h5 style="font-size: 14px; color:black;font-weight:bold;">{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name}}</h5>
                            </div>
                            <div class="card-body">
                                @foreach ($employee as $emp)      
                                <form class="form_input" style="width:100%; margin-bottom:50px;" method="POST" action="{{ route('user_update', $emp->id)}}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                    <label>NIK <span style="color: red">*</span></label>
                                    <input type="text" class="form-control" name="nik" value="{{$emp->nik }}" readonly autocomplete="off">
                                
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Karyawan</label>
                                        <input type="text" class="form-control" name="name" value="{{$emp->name}}" autocomplete="off">
                                        @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control" name="address" value="{{$emp->address}}"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                    <label for="">No.Telepon</label>
                                    <div class="input-group mb-2">
                                        <div class="input-group-prepend">
                                        <div class="input-group-text">+62</div>
                                        </div>
                                        <input type="text" class="form-control" name="phone_number" value="{{$emp->cleaned_phone}}" autocomplete="off">
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" value="{{$emp->email}}" autocomplete="off">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="birth_date" value="{{ old('birth_date',$emp->birth_date ? $birth_date->format('Y-m-d'):null) }}" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label>Kantor</label>
                                        <input type="text" class="form-control" value="{{$emp->location_name}}" autocomplete="off" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Department</label>
                                        <input type="text" class="form-control" value="{{$emp->department_name}}" autocomplete="off" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Posisi</label>
                                        <input type="text" class="form-control" value="{{$emp->job_position}}" autocomplete="off" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label>Tanggal Mulai Bekerja</label>
                                        <input type="text" class="form-control" id="start_date" value="{{ old('start_date', $emp->start_date ? $start_date->format('Y-m-d'):null) }}" autocomplete="off" readonly>
                                    </div>
                                
                                    
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </form> 
                                @endforeach
                            </div>
                        </div>

                        <div style="width:100%; color:black;" class="container-content">
                            <div style="padding:8px;width:100%;" class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="mb-2 font-weight-bold text-primary">Ubah Password</h6>
                                </div>
                            
                                <div class="card-body">
                                    <form style="width: 100%;" class="form_input" method="post" action="{{ route('password.update') }}">
                                            @csrf
                                            @method('put')


                                            <div class="form-group">
                                                <label>Password saat ini</label>
                                                <input id="update_password_current_password" type="password" class="form-control" name="current_password" type="password" autocomplete="off">
                                            </div>


                                            <div class="form-group">
                                                <label>Password baru</label>
                                                <input  class="form-control" id="update_password_password" name="password" type="password" autocomplete="off">
                                            </div>

                                            <div class="form-group">
                                                <label>Konfirmasi password baru</label>
                                                <input class="form-control" id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="off">
                                            </div>
                                    

                                            <div class="flex items-center gap-4">
                                            <button class="btn btn-primary">Ubah Password</button>
                                    
                                            @if (session('status') === 'password-updated')
                                                    <div class="alert alert-success" role="alert">
                                                                <p
                                                                    x-data="{ show: true }"
                                                                    x-show="show"
                                                                    x-transition
                                                                    x-init="setTimeout(() => show = false, 2000)"
                                                    >{{ __('Password anda berhasil diperbarui.') }}</p>
                                             @endif
                                            </div>
                                    </form>
                                    </div>
                                </div>
                        </div>
                    </div>
            
                </div>

                
            </div>

            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('layouts.admin_views.update-password-form')
                </div>
            </div> --}}

            {{-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('layouts.admin_views.delete-user-form')
                </div>
            </div> --}}
            @include('layouts.admin_views.footer')
        </div>

          {{-- modal change status --}}
          <div class="modal fade" id="deleteSignature" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Hapus tanda tangan digital</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <form method="POST" action="{{route('delete_signature', $employee->first()->id)}}">
                      @csrf
                      @method('DELETE')
                      <div class="modal-footer">
                      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                      <button class="btn btn-danger" type="submit">Hapus</button>
                  </form>
                  </div>
              </div>
          </div>
          {{-- end --}}


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

    @if (Session::has('delete_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_success') }}",
            icon: 'error',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif

    @if (Session::has('nik_uknown'))
    <script>
        Swal.fire({
            title: 'UKNOWN NIK!',
            text: "{{ Session::get('nik_uknown') }}",
            icon: 'error',
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif


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