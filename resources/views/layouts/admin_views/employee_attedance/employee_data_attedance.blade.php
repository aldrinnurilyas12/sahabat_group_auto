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

                    <!-- Content Row -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h5 style="color: black;"><strong>Presensi Karyawan</strong></h5>
                            <div style="display: flex; flex-wrap:wrap; gap:10px;" class="submit-presensi">
                                @if ($checking_data->isEmpty())
                                <a href="{{ route('add_employee_attedance') }}" class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>&nbsp; Isi Presensi
                                </a>
                                @else
                                <p class="btn-hadir">
                                    <i class="fa fa-check"></i>&nbsp; Sudah Presensi
                                </p>
                                @endif

                                @if($employee_attedance->isNotEmpty())
                                <form action="{{route('attendance_export_data')}}" method="POST">
                                    @csrf
                                     <input type="text" name="bulan" value="{{$bulan}}" hidden>  
                                     <input  type="text" name="tahun" value="{{$tahun}}" hidden>  
                                     <button type="submit" class="btn btn-success">
                                        <i class="fas fa-file-excel"></i>
                                        &nbsp; Download
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

                            <div style="display: flex; flex-wrap:wrap; gap:10px; font-family:inter,sans-serif;justify-content:space-between;align-items:center;" class="btn-content">
                                
                                <div style="color: black;" class="form-group">
                                    <form  action="{{route('filter_attedance')}}" method="GET">
                                        <label for=""><strong>Pilih bulan dan tahun untuk melihat history Presensi Anda.</strong></label>
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
                                                @if ($errors->has('month'))
                                                <span class="text-danger">{{ $errors->first('month') }}</span>
                                                @endif
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
                                            @if ($errors->has('year'))
                                            <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                            </div>

                                            <button style="height: 40px; align-self:end;" type="submit" class="btn btn-dark">Pilih</button>
                                            <a href="{{route('master_employee_attedance.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                        </div>
                                        &nbsp;
                                     
                                    </form>
                                    <div style="font-size:14px;" class="result-selected">
                                            @if ($employee_attedance->isNotEmpty())
                                                <strong>
                                                    Data Terpilih :
                                                </strong>
                                                <br>
                                                <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                                <div class="alert alert-warning">
                                                    Bulan : {{\Carbon\Carbon::parse(optional($employee_attedance->first())->attedance_date)->format('F') ?? 'Bulan tidak tersedia'}} <br>

                                                    <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                    Tahun : {{\Carbon\Carbon::parse(optional($employee_attedance->first())->attedance_date)->format('Y') ?? 'Tahun tidak ada'}}   
                                                </div>
                                            @elseif($employee_attedance->isEmpty())
                                            <div class="alert alert-warning">
                                                Tidak ada data presensi.
                                            </div>
                                            @endif  

                                           {{-- {{ dd([$month, $year])}} --}}
                                    </div>
                                    
                                    

                                </div>
                                
                        
                            </div>
                           
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                @if($employee_attedance->isEmpty())
                                <h4 style="text-align: center;">Anda belum melakukan presensi hari ini</h4>  
                                @else      
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Cabang</th>
                                            <th>Tipe Presensi</th>
                                            <th>Alasan</th>
                                            <th>Tanggal Presensi</th>
                                            <th>Foto</th>
                                            <th>Created at</th>
                                            <th>Created by</th>
                                            <th>Updated at</th>
                                            <th>Updated by</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;
                                         date_default_timezone_set('Asia/Jakarta');
                                         $time = (int) date('H');
                                        
                                        ?>
                                        @foreach($employee_attedance as $emp)
                                            @php
                                            // Set zona waktu Jakarta
                                            date_default_timezone_set('Asia/Jakarta');
                                        
                                            // Ambil waktu kedatangan dan pastikan itu adalah objek Carbon
                                            $arrivalTime = \Carbon\Carbon::parse($emp->created_at);  // Parse created_at menjadi Carbon
                                            
                                            // Tentukan waktu batas (08:00 pagi hari ini berdasarkan waktu lokal)
                                            $timeLimitHour = 8;
                                            $timeLimitMinute = 0;
                                        
                                            // Set waktu batas 08:00 di hari yang sama dengan waktu kedatangan
                                            $timeLimit = \Carbon\Carbon::parse($arrivalTime->toDateString() . ' ' . $timeLimitHour . ':' . $timeLimitMinute);
                                        
                                            // Cek apakah waktu kedatangan lebih besar atau sama dengan 08:00 dan tipe kehadiran 'hadir'
                                            if ($arrivalTime >= $timeLimit && $emp->attedance_type == 'hadir') {
                                                // Hitung selisih waktu dalam menit
                                                $delay = $arrivalTime->diff($timeLimit);  // Menggunakan diff untuk mendapatkan objek Interval
                                        
                                                // Mendapatkan jam dan menit dari objek Interval
                                                $delayHours = $delay->h;  // Jam keterlambatan
                                                $delayMinutes = $delay->i;  // Menit keterlambatan
                                            }
                                            @endphp
                                            <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href="{{route('edit_attedance_layout', ['nik' => auth()->user()->nik,'id' => $emp->id])}}"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{$emp->nik}}</td>
                                            <td>{{$emp->name}}</td>
                                            <td>{{$emp->branch}}</td>
                                            <td>
                                            @if($emp->attedance_type == 'izin')
                                                <p class="btn-izin">{{$emp->attedance_type}}</p>
                                            @elseif($emp->attedance_type == 'sakit')
                                                <p class="btn-sakit">{{$emp->attedance_type}}</p>
                                            @elseif($emp->attedance_type == '' && $arivalTime == today())
                                                <p class="btn-alpha">{{$emp->attedance_type}}</p>
                                            @elseif($emp->created_at && \Carbon\Carbon::parse($emp->created_at)->hour >= 8 && $emp->attedance_type == 'hadir')
                                                <p class="btn-hadir">{{$emp->attedance_type}}</p>
                                                @if(isset($delay))
                                                    <p style="font-style: italic; color:red;font-size:12px;">Anda telat {{$delayHours}} jam {{$delayMinutes}} menit</p>
                                                @elseif(isset($delay) && $emp->created_at <=8)
                                                   
                                                @endif
                                            @endif
                                            </td>
                                            <td>{{$emp->reasons}}</td>
                                            <td>{{$emp->attedance_date}}</td>
                                            <td>{{$emp->fotos}}</td>
                                            <td>{{$emp->created_at}}</td>
                                            <td>{{$emp->created_by}}</td>
                                            <td>{{$emp->updated_at}}</td>
                                            <td>{{$emp->updated_by}}</td>
                                        </tr>

                                        @endforeach
                                     
                                    </tbody>
                                </table>
                                @endif
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