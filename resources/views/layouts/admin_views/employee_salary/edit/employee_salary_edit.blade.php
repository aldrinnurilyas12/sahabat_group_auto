<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Gaji Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                    
                    <h4 style="text-align:center;color:black;font-weight:bold;">Edit Penggajian Karyawan</h4>
                    @foreach($employee_salary as $emp_salary)
                    <div class="form-group-content">
                  
                        <form class="form_input" method="POST" action="{{ route('edit_employee_salary.update', $emp_salary->id)}}">
                            @csrf   
                            @method('PUT')
                            
                            <input hidden type="text" class="form-control" value="{{$emp_salary->id}}" name="id" autocomplete="off">
                    
                            <div class="form-group">
                                <label>Posisi Pekerjaan</label>
                                <input type="text" class="form-control" value="{{$emp_salary->position_name}}" name="position_name" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Pilih Department</label>
                                @if($emp_salary->department_name == null)
                                    <select class="form-control" name="department_id">
                                        <option value="">=== Pilih Department ===</option>
                                        @foreach($department as $dept)
                                        <option value="{{$dept->id}}">{{$dept->department_name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="form-control" name="department_id">
                                        @foreach($department as $dept)
                                        <option value="{{$dept->id}}" {{$dept->department_name == $emp_salary->department_name ? 'selected' : ''}}>{{$dept->department_name}}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Gaji</label>
                                <input type="text" class="form-control" value="{{$emp_salary->salary}}" name="salary" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Transport</label>
                                <input type="text" class="form-control" value="{{$emp_salary->tunjangan_transport}}" name="tunjangan_transport" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Kesehatan</label>
                                <input type="text" class="form-control" value="{{$emp_salary->tunjangan_kesehatan}}" name="tunjangan_kesehatan" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Tunjangan Lainnya </label>
                                <input type="text" class="form-control" value="{{$emp_salary->tunjangan_lainnya}}" name="tunjangan_lainnya" autocomplete="off">
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