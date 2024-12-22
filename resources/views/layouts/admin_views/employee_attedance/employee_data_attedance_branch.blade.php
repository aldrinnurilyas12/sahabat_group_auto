<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Presensi Karyawan</title>

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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 style="color: black;margin-bottom:1rem;"><strong>Presensi Karyawan [ {{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik .' - '. app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name}} ]</strong></h5>
                           <div style="display: flex;flex-wrap:wrap; gap:10px;" class="submit-presensi">
                                @if ($checking_data->isEmpty())
                                <a href="{{ route('add_employee_attedance') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>&nbsp; Isi Presensi
                                </a>
                                @else
                                <p class="btn-hadir">
                                    <i class="fa fa-check"></i>&nbsp; Sudah Melakukan Presensi
                                </p>
                                @endif

                                <form action="{{route('attendance_branch_export_data')}}" method="POST">
                                    @csrf
                                    <input  type="text" name="bulan" value="{{$bulan}}" hidden>  
                                    <input  type="text" name="tahun" value="{{$tahun}}" hidden>  
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i>
                                        &nbsp; Download
                                    </button> 
                                    </form>
                         </div>
                           <br>
                           
                            <div class="row">
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                                        Total Presensi</div>
                                                    <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$attedance_total}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                                        Kehadiran</div>
                                                    <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$attedance_present}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                                        Izin</div>
                                                    <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$attedance_izin}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                                        Sakit</div>
                                                    <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$attedance_abnormal}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-md-6 mb-4">
                                    <div style="background-image: linear-gradient(to right, #8E2DE2, #4A00E0);color:white;" class="card shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div style="color: white;" class="text-xs font-weight-bold text-uppercase mb-1">
                                                        Alpha</div>
                                                    <div style="color: white;" class="h5 mb-0 font-weight-bold">{{$attedance_alpha}}</div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-users fa-2x text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 style="color: black;"><strong>Presensi Karyawan {{app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name}}</strong></h5>
                            <p>Tanggal : @php echo date('F Y') @endphp</p>

                            <div style="display: flex; gap:10px; font-family:inter,sans-serif;justify-content:space-between;align-items:center;" class="btn-content">
                                
                                <div style="color: black;" class="form-group">
                                    <form  action="{{route('filter_attedance')}}" method="GET">

                                        <div style="display: flex;gap:10px;" class="grouped-container">
                                            <div style="display: block" class="select-group">
                                                <label for="">Bulan</label>
                                                <select class="form-control" name="month" id="branch">
                                                    <option value="">--- Pilih bulan ---</option>
                                                    <option value="alldata">Semua Data</option>
                                                    @foreach($months as $month)
                                                        <option value="{{$month->id}}">{{$month->month_list}}</option>
                                                    @endforeach
                                                    
                                                </select>
                                            </div>
                                        
                                            <div style="display: block" class="select-group">
                                            <label for="">Tahun</label>
                                            <select class="form-control" name="year" id="status">
                                            <option value="">--- Pilih tahun ---</option>
                                            <option value="alldata">Semua Data</option>
                                            @foreach($years as $year)
                                                <option value="{{$year}}">{{$year}}</option>
                                            @endforeach
                                            
                                            </select>
                                            </div>

                                            <button style="height: 40px; align-self:end;" type="submit" class="btn btn-secondary">Pilih</button>
                                        </div>
                                        &nbsp;
                                     
                                    </form>
                                
                                    <div style="font-size:14px;" class="result-selected">
                                        @if ($employee_attedance->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div class="alert alert-warning">
                                                Bulan : {{$bulan}} <br>

                                                <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                Tahun : {{$tahun}}   
                                            </div>
                                        @elseif($employee_attedance->isEmpty())
                                        <div class="alert alert-warning">
                                            Tidak ada data presensi.
                                        </div>
                                        @endif  
                                    </div>

                                </div>
                               
                           
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                                <th class="fixed-column">Karyawan</th>
                                            @foreach($date_listed as $list)
                                                <th>{{$list->date_list}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @if($employee_attedance->isNotEmpty())
                                            @foreach($employee_data as $emp)
                                            <tr>
                                                <td class="fixed-column">{{$emp->name}}</td>
                                                {{-- Loop through each date and check attendance for this employee --}}
                                                @foreach($date_listed as $list)
                                                    <td>
                                                        @php
                                                            // Get the day from the attendance_date and date_list
                                                        
                                                            $list_day = $list->date_list; // Assuming date_list is in the date_listed array
                                                            $attedance_type = $employee_attedance->first()->attedance_type;
                                                            // Match the attendance data for the employee and the date (only day comparison)
                                                            $matchedAd = $employee_attedance->filter(function($attendance) use ($list_day, $emp) {
                                                                return $attendance->employee_id == $emp->id && date('d', strtotime($attendance->attedance_date)) == $list_day; // Compare days
                                                            });
                                                            $attendanceRecord = $matchedAd->first();
                                                        @endphp
                                    
                                                        @if($attendanceRecord && $attendanceRecord->attedance_type == 'hadir')
                                                            <span style="background:rgba(193, 255, 185, 0.445); color:rgb(0, 255, 60); border-radius:5px;">
                                                                Hadir
                                                            </span>
                                                        @elseif($attendanceRecord && $attendanceRecord->attedance_type == 'izin')
                                                            <span style="background:rgba(246, 255, 0, 0.445); color:rgb(0, 0, 0); border-radius:5px;">
                                                                Izin
                                                            </span>
                                                        @elseif($attendanceRecord && $attendanceRecord->attedance_type == 'sakit')
                                                            <span style="background:rgba(0, 26, 255, 0.445); color:rgb(25, 0, 255); border-radius:5px;">
                                                                Sakit
                                                            </span>
                                                        @else
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                            @endforeach
                                        @else
                                        <h4 style="text-align: center" class="text-danger">Tidak ada data</h4>
                                        @endif
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>

                </div>

                {{-- modal change status --}}

                {{-- @foreach($employee_attedance as $emp) 
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
                
                @endforeach --}}

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

        .btn-hadir {
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(0, 255, 128, 0.429) ;
        color: rgb(0, 150, 60);
    }

    .btn-izin{
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(0, 94, 255, 0.429) ;
        color: rgb(22, 1, 206);
    }

    .btn-sakit{
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(255, 217, 0, 0.429) ;
        color: rgb(0, 0, 0);
    }

    .btn-alpha {
        width:max-content;
        padding: 3px;
        height: max-content;
        font-size: 14px;
        border-radius: 6px;
        background:rgba(255, 13, 0, 0.429) ;
        color: rgb(206, 1, 1);
    }

    .fixed-column {
            position: -webkit-sticky; /* Untuk kompatibilitas browser */
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 1; /* Pastikan kolom waktu berada di atas konten lainnya */
            box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1); /* Memberikan sedikit bayangan agar kolom terlihat lebih jelas */
        }

        .schedule-time {
            overflow-x: auto;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Menghilangkan gap antar kolom */
        }

        th {
            width: 100px;
            position: relative;
            background-color: #f4f4f4; /* Menandai header */
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