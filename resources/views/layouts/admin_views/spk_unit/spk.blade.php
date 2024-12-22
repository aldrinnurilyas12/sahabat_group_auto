<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data SPK Unit - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            <h5 style="color: black;"><strong>Data SPK Unit Kendaraan PT Sahabat Group Auto</strong></h5>
                            <br>
                            <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                            <a href="{{ route('spk_create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>&nbsp;Buat SPK Unit
                             </a>

                             <a class="btn btn-success" href="{{route('branch_export')}}">
                                <i class="fas fa-file-excel"></i>
                                                &nbsp; Download
                             </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Unit</th>
                                            <th>Lokasi Unit</th>
                                            <th>Metode Bayar</th>
                                            <th>Harga</th>
                                            <th>Terbilang</th>
                                            <th>DP</th>
                                            <th>Customer</th>
                                            <th>Alamat</th>
                                            <th>No.Telepon</th>
                                            <th>Email</th>
                                            <th>Approve by Head Branch</th>
                                            <th>Approve by Sales Manager</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                           
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($spk_data as $spk)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href=""><i class="fa fa-file"></i></a>
                                                <a href="{{route('spk_edit',['id'=> $spk->id])}}"><i class="fas fa-edit"></i></a>
                                            </td>
                                            <td>{{$spk->unit}}</td>
                                            <td>{{$spk->location_unit}}</td>
                                            <td>{{$spk->payment_method}}</td>
                                            <td>{{$spk->price}}</td>
                                            <td>{{$spk->price_nominal}}</td>
                                            <td>{{$spk->down_payment}}</td>
                                            <td>{{$spk->customer}}</td>
                                            <td>{{$spk->address}}</td>
                                            <td>{{$spk->phone_number}}</td>
                                            <td>{{$spk->email}}</td>
                                            <td>
                                                @if( $spk->approval_by_head_branch == 'N')
                                                <p class="text-danger">Belum Konfirmasi</p>
                                                @elseif($spk->approval_by_head_branch == 'Y')
                                                <p class="text-success">Sudah Konfirmasi</p>
                                                @else
                                                @endif
                                            </td>
                                            <td> 
                                                @if( $spk->approval_by_sales_manager == 'N')
                                                <p class="text-danger">Belum Konfirmasi</p>
                                                @elseif($spk->approval_by_sales_manager == 'Y')
                                                <p class="text-success">Sudah Konfirmasi</p>
                                                @else
                                                @endif</td>
                                            <td>{{$spk->created_at}}</td>
                                            <td>{{$spk->created_by}}</td>
                                            <td>{{$spk->updated_at}}</td>
                                            <td>{{$spk->updated_by}}</td>
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

     {{-- @foreach($agenda as $agendas) 
     <div class="modal fade" id="deleteUnit{{$agendas->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$agendas->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$agendas->id}}">Hapus data Agenda: {{$agendas->agenda_name}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('master_agenda.destroy', $agendas->id) }}">
                     @csrf
                     @method('DELETE')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin menghapus data Agenda:
                         {{$agendas->agenda_name}} ?
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