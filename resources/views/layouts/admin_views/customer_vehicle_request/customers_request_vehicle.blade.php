<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Permintaan Unit Kendaraan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            <h5 style="color: black;"><strong>Data Permintaan unit Kendaraan Customer</strong></h5>
                            <br>
                            @if($request_vehicle_data->isNotEmpty())
                            <form action="{{route('vehicle_req_export')}}" method="POST">
                                @csrf
                                <input type="text" value="{{$bulan}}" name="bulan" hidden>
                                <input type="text" value="{{$tahun}}" name="tahun" hidden>
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

                            <br>
                            <hr>
                            <div style="display: flex; flex-wrap:wrap; gap:10px; font-family:inter,sans-serif;justify-content:space-between;align-items:center;" class="btn-content">
                             
                            <div style="color: black;" class="form-group">
                                <form  action="{{route('filter_request')}}" method="GET">

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
                                        <a href="{{route('master_employee_attedance.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                    </div>
                                    &nbsp;
                                 
                                </form>
                                <div style="font-size:14px;" class="result-selected">
                                        @if ($request_vehicle_data->isNotEmpty())
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
                                        @elseif($request_vehicle_data->isEmpty())
                                        <div class="alert alert-warning">
                                            Tidak ada data.
                                        </div>
                                        @endif  

                                       {{-- {{ dd([$month, $year])}} --}}
                                </div>
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
                                            <th>Nama</th>
                                            <th>No.Telepon</th>
                                            <th>Email</th>
                                            <th>Tipe Mobil</th>
                                            <th>Merk</th>
                                            <th>Tahun Kendaraan</th>
                                            <th>Warna</th>
                                            <th>Status Email</th>
                                            <th>Deskripsi Email</th>
                                            <th>Tanggal Permintaan</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($request_vehicle_data as $customer_request)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td> 
                                                <div class="dflex">
                                                    @if($customer_request->sending_mail)
                                                    <a href="#" class="btn btn-dark">Sudah</a>
                                                    @else
                                                    <a href="{{route('customer_vehicle_sale_mail', $customer_request->id)}}" class="btn btn-primary">Email</a>
                                                    @endif
                                                   
                                                </div>
                                            </td>
                                            <td>{{$customer_request->name}}</td>
                                            <td><a href="https://wa.me/{{$customer_request->phone_number}}">{{$customer_request->phone_number}}</a></td>
                                            <td>{{$customer_request->email}}</td>
                                            <td>{{$customer_request->vehicle_type}}</td>
                                            <td>{{$customer_request->brand_name}}</td>
                                            <td>{{$customer_request->year}}</td>
                                            <td>{{$customer_request->vehicle_color}}</td>
                                            <td>
                                                @if($customer_request->sending_mail == 'Ya')
                                                <span class="text-success">Sudah</span>
                                                @else
                                                <span class="text-danger">Belum</span>
                                                @endif
                                               </td>
                                            <td>{{$customer_request->description}}</td>
                                            <td>{{$customer_request->created_at}}</td>
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

     {{-- @foreach($appointment_data as $appointment) 
     <div class="modal fade" id="deleteUnit{{$appointment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$appointment->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$appointment->id}}">Hapus data cabang: {{$appointment->location_code . ' - ' . $appointment->location_name}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('master_branch.destroy', $appointment->id) }}">
                     @csrf
                     @method('DELETE')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin menghapus data cabang:
                         {{$appointment->location_code . ' - ' . $appointment->location_name}} ?
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