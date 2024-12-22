<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
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
                
                {{-- content --}}
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 style="color: black;"><strong>Data Karyawan PT Sahabat Group Auto</strong></h5>
                            <br>
                            <div style="display: flex; gap:10px; font-family:inter,sans-serif;" class="btn-content">
                                <a href="{{ route('add_employee') }}" class="btn btn-primary">
                                  <i class="fas fa-plus-circle"></i>&nbsp;Tambah Karyawan
                                 </a>

                                 @if($employee->isNotEmpty())
                                 <form action="{{route('export_employee')}}" method="POST">
                                    @csrf
                                    <input type="text" name="office" value="{{$offices}}" hidden>
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
                            <div style="color: black;" class="form-group">
                                <form  action="{{route('filter_employee')}}" method="GET">

                                    <div style="display: flex;gap:10px;" class="grouped-container">
                                        <div style="display: block" class="select-group">
                                            <label for="">Kantor</label>
                                            <select class="form-control" name="office" id="branch">
                                                <option value="">--- Pilih Kantor ---</option>
                                                <option value="alldata">Semua Kantor</option>
                                               @foreach($office as $kantor)
                                                <option value="{{$kantor->location_name}}">{{$kantor->location_name}}</option>
                                               @endforeach
                                                
                                            </select>
                                            @if ($errors->has('month'))
                                            <span class="text-danger">{{ $errors->first('month') }}</span>
                                            @endif
                                        </div>
                                    
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
                                        <a href="{{route('master_employee.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                    </div>
                                    &nbsp;
                                 
                                </form>
                                <div style="font-size:14px;" class="result-selected">
                                        @if ($employee->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div class="alert alert-warning">
                                                Kantor :{{$departments}} <br>
                                                Department :{{$offices}}
                                                <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                 </div>
                                        @elseif($employee->isEmpty())
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
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Usia</th>
                                            <th>Telepon</th>
                                            <th>Email</th>
                                            <th>Posisi</th>
                                            <th>Department</th>
                                            <th>Kantor</th>
                                            <th>Gaji Pokok</th>
                                            <th>Tunjangan Transport</th>
                                            <th>Tunjangan Kesehatan</th>
                                            <th>Tunjangan Lainnya</th>
                                            <th>Total Gaji</th>
                                            <th>Status Aktif</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Resign</th>
                                            <th>Created at</th>
                                            <th>Created by</th>
                                            <th>Updated at</th>
                                            <th>Updated by</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($employee as $emp)
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href="{{route('edit_employee', $emp->id)}}"><i class="fas fa-edit"></i></a>
                                                <a style="size: 12px;" href="#" data-toggle="modal" data-target="#deleteEmployee{{$emp->id}}"><i class="fas fa-trash"></i></a>
                                            </td>
                                            <td>{{$emp->nik}}</td>
                                            <td>{{$emp->name}}</td>
                                            <td>{{$emp->address}}</td>
                                            <td>{{$emp->age}}</td>
                                            <td>{{$emp->phone_number}}</td>
                                            <td>{{$emp->email}}</td>
                                            <td>{{$emp->job_position}}</td>
                                            <td>{{$emp->department_name}}</td>
                                            <td>{{$emp->location_name}}</td>
				                            <td>{{"Rp ". number_format($emp->salary)}}</td>
                                            <td>{{"Rp ". number_format($emp->tunjangan_transport)}}</td>
                                            <td>{{"Rp ". number_format($emp->tunjangan_kesehatan)}}</td>
                                            <td>{{"Rp ". number_format($emp->tunjangan_lainnya)}}</td>
                                            <td>{{"Rp ". number_format($emp->salary_total)}}</td>
                                            <td>{{$emp->is_active}}</td>
                                            <td>{{ old('start_date', $emp->start_date ? \Carbon\Carbon::parse($emp->start_date)->format('d-m-Y'): '') }}</td>
                                            <td>{{ old('resign_date', $emp->resign_date ? \Carbon\Carbon::parse($emp->resign_date)->format('d-m-Y'): '') }}</td>
                                            <td>{{$emp->created_at}}</td>
                                            <td>{{$emp->created_by}}</td>
                                            <td>{{$emp->updated_at}}</td>
                                            <td>{{$emp->updated_by}}</td>
                                            
                                        </tr>

                                        @endforeach
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- modal change status --}}

                @foreach($employee as $emp) 
                <div class="modal fade" id="deleteEmployee{{$emp->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$emp->id}}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel{{$emp->id}}">Hapus Data Karyawan: {{$emp->nik . ' - ' . $emp->name}}</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                
                            <form method="POST" action="{{route('master_employee.destroy', $emp->id)}}">
                                @csrf
                                @method('DELETE')
                                <div style="color: black;" class="modal-body">
                                    Apakah Anda ingin menghapus data Karyawan:
                                    <br>
                                    {{$emp->nik . ' - ' . $emp->name}} ?
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

                {{-- end modal --}}

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
            icon: 'success',
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer:2000
        });
    </script>
    @endif
    <style>
        .col-sm-12{
            overflow-x: scroll;
        }

    </style>

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