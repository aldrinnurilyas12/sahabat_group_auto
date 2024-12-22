<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Kirim Email Customer - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            
                            <h5>Data permintaan Jual Unit Kendaraan : {{$customer_request_sale_data->first()->name}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>No.Telepon</th>
                                            <th>Email</th>
                                            <th>Tipe Mobil</th>
                                            <th>Merk</th>
                                            <th>Tahun Kendaraan</th>
                                            <th>Warna</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach($customer_request_sale_data as $customer_request)
                                        <tr style="width: 200px;">
                                            <td>{{$customer_request->name}}</td>
                                            <td>{{$customer_request->phone_number}}</td>
                                            <td>{{$customer_request->email}}</td>
                                            <td>{{$customer_request->vehicle_type}}</td>
                                            <td>{{$customer_request->brand_name}}</td>
                                            <td>{{$customer_request->vehicle_year}}</td>
                                            <td>{{$customer_request->vehicle_color}}</td>
                                        </tr>

                                        @endforeach
                                     
                                    </tbody>
                                </table>
                            </div>


                            
                        </div>
                    </div>
                    <div class="form-group-content">
                    <form class="form_input" method="POST" action="{{route('response_customers_request_sale', $customer_request_sale_data->first()->id)}}" >
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="text" class="form-control" autocomplete="off" name="email" value="{{$customer_request_sale_data->first()->email}}" hidden>
                        </div>
                        <div class="form-group">
                            <input hidden type="text" class="form-control" autocomplete="off" name="sending_email" value="Ya">
                        </div>
                        
                        <div class="form-group">
                            <label>Status</label>
                               <select class="form-control" name="status" id="">
                                <option value="reviewed">Ditinjau</option>
                                <option value="confirmed">Dikonfirmasi</option>
                                <option value="canceled">Tolak</option>
                               </select>
                        </div>

                        <div class="form-group">
                        <label >Berikan penjelasan tentang unit kendaraan</label>
                            <input type="text" class="form-control" autocomplete="off" name="description">
                        </div>
                        <button type="submit" class="btn btn-dark">Kirim Email <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                    </form>
                    </div>
            </div>
                    {{-- end content --}}
           
            @include('layouts.admin_views.footer')
            

        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>

     {{-- modal change status --}}

     {{-- @foreach($branch as $cab) 
     <div class="modal fade" id="deleteUnit{{$cab->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$cab->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$cab->id}}">Hapus data cabang: {{$cab->location_code . ' - ' . $cab->location_name}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('master_branch.destroy', $cab->id) }}">
                     @csrf
                     @method('DELETE')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin menghapus data cabang:
                         {{$cab->location_code . ' - ' . $cab->location_name}} ?
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