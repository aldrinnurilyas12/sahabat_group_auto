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
    <script src="{{url('bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
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

                            {{-- tab --}}
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link active"
                                        id="ex1-tab-1"
                                        href="#ex1-tabs-1"
                                        role="tab"
                                        aria-controls="ex1-tabs-1"
                                        aria-selected="true"
                                    >SPK </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a
                                        data-mdb-tab-init
                                        class="nav-link"
                                        id="ex1-tab-2"
                                        href="#ex1-tabs-2"
                                        role="tab"
                                        aria-controls="ex1-tabs-2"
                                        aria-selected="false"
                                    >All SPK Data</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="ex1-content">
                                <div
                                    class="tab-pane fade show active"
                                    id="ex1-tabs-1"
                                    role="tabpanel"
                                    aria-labelledby="ex1-tab-1">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Status</th>
                                                        <th>PDF</th>
                                                        <th>Tanggal SPK</th>
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
                                                        <td>
                                                            @if(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations' && $spk->approval_by_head_branch == 'Y')
                                                            <p class="text-success">Sudah Konfirmasi</p>
                                                            @elseif(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager' && $spk->approval_by_sales_manager == 'Y')
                                                            <p class="text-success">Sudah Konfirmasi</p>
                                                            @elseif($spk->approval_by_head_branch == 'N' || $spk->approval_by_sales_manager == 'N')
                                                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#confirmedModal{{$spk->id}}">Konfirmasi</a>
                                                            @else
                                                            @endif
                                                        </td>
                                                        <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                            @if($spk->approval_by_head_branch == 'Y' && $spk->approval_by_sales_manager == 'Y')
                                                            <a href="{{route('get_pdf', $spk->id)}}"><i class="fa fa-file"></i></a>
                                                            @else
                                                            <p class="text-secondary">SPK belum dikonfirmasi</p>
                                                            @endif
                                                        </td>
                                                        <td>{{date('d F Y', strtotime($spk->created_at))}}</td>
                                                        <td>{{$spk->unit}}</td>
                                                        <td>{{$spk->location_unit}}</td>
                                                        <td>{{$spk->payment_method}}</td>
                                                        <td>{{"Rp " .number_format($spk->price)}}</td>
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
                                {{-- ALL DATA --}}
                                <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>PDF</th>
                                                        <th>Tanggal SPK</th>
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
                                                    @foreach($all_spk_data as $spk)
                                                    <tr style="width: 200px;">
                                                        <td><?php echo $no++ ?></td>
                                                        <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                            @if($spk->approval_by_head_branch == 'Y' && $spk->approval_by_sales_manager == 'Y')
                                                            <a href="{{route('get_pdf', $spk->id)}}"><i class="fa fa-file"></i></a>
                                                            @else
                                                            <p class="text-secondary">SPK belum dikonfirmasi</p>
                                                            @endif
                                                        </td>
                                                        <td>{{date('d F Y', strtotime($spk->created_at))}}</td>
                                                        <td>{{$spk->unit}}</td>
                                                        <td>{{$spk->location_unit}}</td>
                                                        <td>{{$spk->payment_method}}</td>
                                                        <td>{{"Rp " .number_format($spk->price)}}</td>
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

     @foreach($spk_data as $spk) 
     <div class="modal fade" id="confirmedModal{{$spk->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel{{$spk->id}}" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel{{$spk->id}}">Konfirmasi SPK Unit Kendaraan: <br> {{$spk->unit}}</h5>
                     <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">×</span>
                     </button>
                 </div>
     
                 <form method="POST" action="{{ route('confirmed_status_spk', $spk->id) }}">
                     @csrf
                     @method('PUT')
                     <div style="color: black;" class="modal-body">
                         Apakah Anda ingin Konfirmasi SPK Unit Kendaraan :
                         {{$spk->unit}} ?
                         <br>   
                     </div>
                     <input type="text" name="approval_by_head_branch" value="Y" hidden>
                     <input type="text" name="approval_by_sales_manager" value="Y" hidden>
                     <input type="text" name="vehicle_id" value="{{$spk->vehicle_id}}" hidden>
                     <div class="modal-footer">
                         <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                         <button class="btn btn-primary" type="submit">Konfirmasi</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all tab links
        const tabLinks = document.querySelectorAll('.nav-link');

        // Add click event to each tab link
        tabLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); // Prevent default anchor behavior

                // Remove active class from all links and hide all tab content
                tabLinks.forEach(item => {
                    item.classList.remove('active');
                    item.setAttribute('aria-selected', 'false');
                });
                document.querySelectorAll('.tab-pane').forEach(content => {
                    content.classList.remove('show', 'active');
                });

                // Add active class to the clicked link and show corresponding tab content
                this.classList.add('active');
                this.setAttribute('aria-selected', 'true');
                const target = this.getAttribute('href');
                document.querySelector(target).classList.add('show', 'active');
            });
        });
    });


</script>



</html>