<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Appointment Customer - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            <h5 style="color: black;"><strong>Data Appointment (Kunjungan & Test Drive) Customer</strong></h5>
                            
                        <br>
                                 @if($appointment_data->isNotEmpty(0))
                                <form action="{{route('appointment_export')}}" method="POST">
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
                            <br>
                                <hr>
                            <div style="color: black;" class="form-group">
                                <form  action="{{route('filter_appointment')}}" method="GET">

                                    <div style="display: flex;gap:10px;" class="grouped-container">
                                        <div style="display: block" class="select-group">
                                            <label for="">Bulan</label>
                                            <select class="form-control" name="bulan" id="branch">
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
                                        <select class="form-control" name="tahun" id="status">
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
                                        <a href="{{route('customers_appointment.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                    </div>
                                    &nbsp;
                                 
                                </form>
                                <div style="font-size:14px;" class="result-selected">
                                        @if ($appointment_data->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div class="alert alert-warning">
                                                Bulan : {{$bulan}}<br>

                                                <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                Tahun : {{$tahun}}   
                                            </div>
                                        @elseif($appointment_data->isEmpty())
                                        <div class="alert alert-warning">
                                            Tidak ada data Appointment.
                                        </div>
                                        @endif  

                                       {{-- {{ dd([$month, $year])}} --}}
                                </div>
                                
                                

                            </div>
                             
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Ubah status</th>
                                            <th>Unit</th>
                                            <th>Lokasi Cabang</th>
                                            <th>Nama Customer</th>
                                            <th>Nomor Telepon</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Tanggal Appointment</th>
                                            <th>Jam</th>
                                            <th>Created at</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($appointment_data as $appointment)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                @if($appointment->appointment_status == null) 
                                                <a style="font-size: 14px;" class="btn btn-primary" href="#" data-toggle="modal" data-target="#changeStatus{{$appointment->id}}">Ubah</i></a>
                                                @else
                                                <a style="font-size: 14px;" class="btn btn-dark">Sudah</i></a>
                                                @endif
                                            </td>
                                            <td>{{$appointment->unit}}</td>
                                            <td>{{$appointment->location_unit}}</td>
                                            <td>{{$appointment->name}}</td>
                                            <td>{{$appointment->phone_number}}</td>
                                            <td>{{$appointment->email}}</td>
                                            <td>
                                                @if($appointment->appointment_status == 'hadir')
                                                <span class="text-success">{{$appointment->appointment_status}}</span>
                                                @elseif($appointment->appointment_status == 'tidak datang')
                                                <span class="text-danger">{{$appointment->appointment_status}}</span>
                                                @elseif($appointment->appointment_status == null)
                                               <span class="text-secondary">Belum datang</span>
                                                @endif
                                               </td>
                                            <td>{{date('d-m-Y', strtotime($appointment->date))}}</td>
                                            <td>{{$appointment->schedule_time}}</td>
                                            <td>{{$appointment->created_at}}</td>
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

     @foreach($appointment_data as $appointment) 
     <div class="modal fade" id="changeStatus{{$appointment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$appointment->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$appointment->id}}">Ubah kehadiran Customer Appointment {{$appointment->location_unit . ' - ' . $appointment->unit}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('change_appointment_status', $appointment->id) }}">
                     @csrf
                     @method('PUT')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin mengubah status kehadiran appointment pada customer
                        <strong>{{$appointment->name}}</strong> dan unit <strong>{{$appointment->unit}}</strong> ?
                         <br>
                       
                         <br> 
                         <div style="display: block;" class="form-group">
                            <label for="">Status Kehadiran Customer :</label>
                            <input type="radio" value="hadir" name="appointment_status" id=""> Hadir
                            <br>
                            <input type="radio" value="tidak datang" name="appointment_status" id=""> Tidak Datang
                         </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                 </form>
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