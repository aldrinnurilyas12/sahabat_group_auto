<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Users</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Edit User Admin</h4>
                    @foreach($user as $usr)
                    <div class="form-group-content">
                    <form class="form_input" method="POST" action="{{ route('edit_users.update',['id' => $usr->id])}}">
                      
                        @csrf
                        @method('PUT')
                
                        <div class="form-group">
                            <input type="text" name="id" class="form-control" disabled autocomplete="off" value="{{$usr->id}}" hidden>
                        </div>

                        <div class="form-group">
                            <input type="text" name="employee_id" class="form-control" disabled autocomplete="off" value="{{$usr->employee_id}}" hidden>
                        </div>
                        
                        <div class="form-group">
                            <label >Nama</label>
                            <input type="text" class="form-control" disabled autocomplete="off" value="{{$usr->nik." - ".$usr->name}}">
                        </div>

                       
                        <div class="form-group">
                            <label >NIK</label>
                            <input type="text" class="form-control" name="nik" autocomplete="off" value="{{$usr->nik}}" readonly>
                        </div>

                        <div class="form-group">
                            <label >Email</label>
                            <input type="text" class="form-control" name="email" autocomplete="off" value="{{$usr->email}}" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Pilih Role</label>
                            <select 
                            id="role" 
                            name="role" 
                            class="form-control" 
                            required 
                            autocomplete="role">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" {{$role->role_name ==  $usr->role_name ? 'selected' : '' }}>{{$role->role_name}}</option>
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
                        @endforeach
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>  
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