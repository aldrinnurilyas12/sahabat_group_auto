<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Payroll - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            <h5 style="color: black;"><strong>Data Kantor Cabang PT Sahabat Group Auto</strong></h5>
                            <br>
                            <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                            <a href="{{ route('branch_create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>&nbsp;Tambah Cabang
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
                                            <th>NIK</th>
                                            <th>Nama Karyawan</th>
                                            <th>Kantor</th>
                                            <th>Email</th>
                                            <th>Posisi</th>
                                            <th>Gaji Pokok</th>
                                            <th>Tunj.Transport</th>
                                            <th>Tunj.Kesehatan</th>
                                            <th>Tunj.Lainnya</th>
                                            <th>Total Gaji</th>
                                            <th>Status Payroll</th>
                                            <th>Detail Presensi</th>
                                            <th>Approve Head of Finance</th>
                                            <th>Approve Head of Human Resource</th>
                                            <th>Created At</th>
                                            <th>Created By</th>                                   
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($payroll_data as $payroll)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td>
                                                @if($payroll->status == 'Sudah Konfirmasi')
                                                <a class="btn btn-secondary" style="size: 12px;" href="{{route('get_payroll_detail', $payroll->id)}}">Approved</a>
                                                @else
                                                <a class="btn btn-primary" style="size: 12px;" href="{{route('get_payroll_detail', $payroll->id)}}">Approve</a>
                                                @endif
                                            </td>
                                            <td>{{$payroll->nik}}</td>
                                            <td>{{$payroll->name}}</td>
                                            <td>{{$payroll->location_name}}</td>
                                            <td>{{$payroll->email}}</td>
                                            <td>{{$payroll->position_name}}</td>
                                            <td>{{"Rp.".number_format($payroll->salary)}}</td>
                                            <td>{{"Rp.".number_format($payroll->tunjangan_transport)}}</td>
                                            <td>{{"Rp.".number_format($payroll->tunjangan_kesehatan)}}</td>
                                            <td>{{"Rp.".number_format($payroll->tunjangan_lainnya)}}</td>
                                            <td>{{"Rp.".number_format($payroll->salary_total)}}</td>
                                            <td>{{$payroll->status}}</td>
                                            <td>

                                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                                          
                                                  <tr>
                            
                                                    <th>Total Hadir</th>
                                                    <th>Total Izin</th>
                                                    <th>Total Sakit</th>
                                          
                                                  </tr>
                                          
                                                  <tr>
                                                    <td>{{$payroll->total_hadir}}</td>
                                                    <td>{{$payroll->total_izin}}</td>
                                                    <td>{{$payroll->total_sakit}}</td>
                                                  </tr>
                                          
                                                </table>
                                          
                                              </td>
                                            <td>
                                                @if($payroll->approval_by_head_of_finance == 'confirmed')
                                                <p class="text-success">Confirmed</p>
                                                @else 
                                                <p class="text-danger">Pending</p>
                                                @endif
                                            <td>
                                                @if($payroll->approval_by_head_of_human_resource == 'confirmed')
                                                <p class="text-success">Confirmed</p>
                                                @else 
                                                <p class="text-danger">Pending</p>
                                                @endif
                                            </td>
                                            <td>{{$payroll->created_at}}</td>
                                            <td>{{$payroll->created_by}}</td>
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