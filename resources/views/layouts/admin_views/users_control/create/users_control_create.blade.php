<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Users</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Tambah User Admin</h4>
                    
                    <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">
                        <form class="form_input" method="POST" action="{{ route('save_users')}}">
                            @csrf
                            <div class="form-group">
                                <label>Pilih Karyawan</label>
                                <select 
                                    id="employee" 
                                    name="employee_id" 
                                    class="form-control" 
                                    required 
                                    autocomplete="employee">
                                    <option value="" disabled selected>Select a employee</option>
                                    @foreach($employees as $emp)
                                        <option 
                                            value="{{ $emp->id }}" 
                                            {{ old('employee') == $emp->id ? 'selected' : '' }}>
                                            {{ $emp->nik }} - {{ $emp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label >NIK</label>
                                <input type="text" class="form-control" name="nik" autocomplete="off" placeholder="Masukan NIK">
                            </div>
                            <div class="form-group">
                                <label>Pilih Role</label>
                                <select 
                                id="role" 
                                name="role" 
                                class="form-control" 
                                required 
                                autocomplete="role">
                                <option value="" disabled selected>Select a role</option>
                                @foreach($roles as $role)
                                    <option 
                                        value="{{ $role->id }}" 
                                        {{ old('role') == $role->id ? 'selected' : '' }} >
                                        {{ $role->role_name }}
                                    </option>
                                @endforeach
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Aktif?</label>
                                <select class="form-control" name="is_active" id="">
                                    <option value="Y">Ya</option>
                                    <option value="N">Tidak</option>
                                </select>
                                </div>
                            <div class="form-group">
                                <label >Password</label>
                                <input type="password" class="form-control" name="password" autocomplete="off" placeholder="Masukan Password">
                            </div>
                            <div class="form-group">
                                <label >Konfirmasi Password</label>
                                <input type="password" class="form-control" autocomplete="off" name="password_confirmation" placeholder="Masukan kembali Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>  


                        <div style="width: 400px; height:max-content; padding:8px;" class="card shadow mb-4">
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
                        </div>
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

    
    
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>



</body>



</html>