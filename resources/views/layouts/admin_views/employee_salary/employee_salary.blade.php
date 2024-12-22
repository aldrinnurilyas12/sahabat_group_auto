<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Gaji Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                
                    <!-- DataTable -->
                    <div class="card shadow mb-4">
                        <div  class="card-header py-3">
                            <h5 style="color: black;"><strong>Data Posisi Pekerjaan PT Sahabat Group Auto</strong></h5>
                            <br>
                            <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                                <a href="{{ route('add_emp_salary') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>&nbsp;Tambah Posisi Pekerjaan
                                </a>
                                @if($employee_salary->isNotEmpty())
                                <form action="{{route('export_employee_salary')}}" method="POST">
                                    @csrf
                                    <input type="text" value="{{$departments}}" name="department" hidden>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i>
                                        &nbsp; Download Excel
                                    </button> 
                                </form>
                                @else
                                <button class="btn btn-dark">
                                    <i class="fas fa-file-excel"></i>
                                    &nbsp; Download Excel
                                </button> 
                                @endif
                            </div>
                            <br>
                            <hr>
                            <div style="color: black;" class="form-group">
                                <form  action="{{route('filter_employee_salary')}}" method="GET">

                                    <div style="display: flex;gap:10px;" class="grouped-container">
                                        
                                        <div style="display: block" class="select-group">
                                        <label for="">Department</label>
                                        <select class="form-control" name="department" id="status">
                                            <option value="">--- Pilih Department ---</option>
                                            <option value="alldata">Semua Department</option>
                                            @foreach($department as $dept)
                                                <option value="{{$dept->department_name}}">{{$dept->department_name}}</option>
                                            @endforeach
                                           
                                        </select>
                                        @if ($errors->has('year'))
                                        <span class="text-danger">{{ $errors->first('year') }}</span>
                                        @endif
                                        </div>

                                        <button style="height: 40px; align-self:end;" type="submit" class="btn btn-dark">Pilih</button>
                                        <a href="{{route('master_employee_salary.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                    </div>
                                    &nbsp;
                                 
                                </form>
                                <div style="font-size:14px;" class="result-selected">
                                        @if ($employee_salary->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div class="alert alert-warning">
                                                Department :{{$departments}}
                                                <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                 </div>
                                        @elseif($employee_salary->isEmpty())
                                        <div class="alert alert-warning">
                                            Tidak ada data dipilih
                                        </div>
                                        @endif  

                                 </div> 
                                
                                

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Posisi Pekerjaan</th>
                                            <th>Department</th>
                                            <th>Gaji Pokok</th>
                                            <th>Tunjangan Transport</th>
                                            <th>Tunjangan Kesehatan</th>
                                            <th>Tunjangan Lainnya</th>
                                            <th>Total Gaji</th>
                                            <th>Jumlah Karyawan</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($employee_salary as $emp_salary)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href="{{route('edit_emp_salary', $emp_salary->id)}}"><i class="fas fa-edit"></i></a>
                                                <a style="size: 12px;" href="#" data-toggle="modal" data-target="#deleteUnit{{$emp_salary->id}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                            <td>{{$emp_salary->position_name}}</td>
                                            <td>{{$emp_salary->department_name}}</td>
                                            <td>{{"Rp " . number_format($emp_salary->salary)}}</td>
                                            <td>{{"Rp " . number_format($emp_salary->tunjangan_transport)}}</td>
                                            <td>{{"Rp " . number_format($emp_salary->tunjangan_kesehatan)}}</td>
                                            <td>{{"Rp " . number_format($emp_salary->tunjangan_lainnya)}}</td>
                                            <td>{{"Rp " . number_format($emp_salary->salary_total)}}</td>
                                            <td>{{$emp_salary->employee_total}} Karyawan &nbsp; 
                                                <a style="text-decoration:underline;" href="#"  data-toggle="modal" data-target="#showData{{$emp_salary->jb_id}}"> Lihat data <i class="fas fa-external-link-alt"></i></a></td>
                                            <td>{{$emp_salary->created_at}}</td>
                                            <td>{{$emp_salary->created_by}}</td>
                                            <td>{{$emp_salary->updated_at}}</td>
                                            <td>{{$emp_salary->updated_by}}</td>
                                        </tr>

                                        @endforeach
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

              

                {{-- end content --}}

                

            </div>
           
            @include('layouts.admin_views.footer')
            

        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>

     {{-- modal change status --}}

     @foreach($employee_salary as $emp_salary) 
     <div class="modal fade" id="deleteUnit{{$emp_salary->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$emp_salary->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$emp_salary->id}}">Hapus data cabang: {{$emp_salary->position_name . ' - ' . $emp_salary->salary}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('master_employee_salary.destroy', $emp_salary->id) }}">
                     @csrf
                     @method('DELETE')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin menghapus data posisi pekerjaan:
                         {{$emp_salary->position_name . ' - ' . $emp_salary->salary}} ?
                         <br>
                         <span style="font-style: italic;color:gray;font-size:12px;">*Data akan terhapus permanen.</span>    
                     </div>
                     <div class="modal-footer">
                         <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                         <button class="btn btn-danger" type="submit">Hapus</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
     
     @endforeach



     {{-- show data karyawan --}}
     @foreach($employee_salary as $emp_salary) 
     <div class="modal fade" id="showData{{$emp_salary->jb_id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$emp_salary->jb_id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div style="width:700px;" class="modal-content">
                 <div class="modal-header">
                    <h5>Data Karyawan {{$emp_salary->position_name}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
                <div class="card-body">
                 <table style="font-size: 14px;font-weight:600;color:black;" class="table">
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>Posisi</th>
                    <th>Kantor</th>
                    <th>No.Telepon</th>
                    <?php 
                    $no = 1;
                    ?>
                    <tbody> 
                        @foreach($show_employee as $showEmp)
                            @if($emp_salary->jb_id == $showEmp->jb_id)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$showEmp->nik}}</td>
                                    <td>{{$showEmp->name}}</td>
                                    <td>{{$showEmp->position_name}}</td>
                                    <td>{{$showEmp->location_name}}</td>
                                    <td>{{$showEmp->phone_number}}</td>
                                </tr>
                            @else 
                            @endif
                        @endforeach
                    </tbody>
                 </table>
                </div>
             </div>
         </div>
     </div>
     
     @endforeach

     {{-- end modal --}}
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <style>
        .col-sm-12{
            overflow-x: scroll;
        }

    </style>

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
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>

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

    @if (Session::has('failed_insert'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: "{{ Session::get('failed_insert') }}",
            icon: "error",
            timer:6000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif

    @if (Session::has('delete_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_success') }}",
            icon: "success",
            timer:2000,
            confirmButtonText: 'OK'
        });
    </script>
        
    @endif
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

@if (Session::has('failed_insert'))
<script>
    Swal.fire({
        title: 'Gagal',
        text: "{{ Session::get('failed_insert') }}",
        icon: "error",
        timer:6000,
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