<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Maintenence Unit - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                            <h5 style="color: black;"><strong>Data Maintenance Unit PT Sahabat Group Auto</strong></h5>
                            <br>
                            <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                            <a href="{{ route('maintenance_unit_create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>&nbsp;Tambah Maintenance Unit
                             </a>

                            
                             <form action="{{route('maintenance_export')}}" method="POST">
                                @csrf
                                <input type="text" name="bulan" value="{{$bulan}}" hidden>
                                <input type="text" name="tahun" value="{{$tahun}}" hidden>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-file-excel"></i>
                                    &nbsp; Download Excel
                                </button> 
                            </form>
                            </div>
                            <br>

                            <div style="color: black;" class="form-group">
                                <form  action="{{route('filter_maintenance')}}" method="GET">

                                    <div style="display: flex;gap:10px;" class="grouped-container">
                                        
                                        <div style="display: block" class="select-group">
                                        <label for="">Bulan</label>
                                        <select class="form-control" name="bulan" id="status">
                                            <option value="">--- Pilih Bulan ---</option>
                                            <option value="alldata">Semua Bulan</option>
                                            @foreach($months as $month)
                                                <option value="{{$month->id}}">{{$month->month_list}}</option>
                                            @endforeach
                                           
                                        </select>
                                        @if ($errors->has('year'))
                                        <span class="text-danger">{{ $errors->first('year') }}</span>
                                        @endif
                                        </div>
                                        
                                        <div style="display: block" class="select-group">
                                            <label for="">Tahun</label>
                                            <select class="form-control" name="tahun" id="status">
                                                <option value="">--- Pilih Tahun ---</option>
                                                <option value="alldata">Semua Tahun</option>
                                                @foreach($years as $yrs)
                                                    <option value="{{$yrs}}">{{$yrs}}</option>
                                                @endforeach
                                               
                                            </select>
                                            @if ($errors->has('year'))
                                            <span class="text-danger">{{ $errors->first('year') }}</span>
                                            @endif
                                            </div>

                                        <button style="height: 40px; align-self:end;" type="submit" class="btn btn-dark">Pilih</button>
                                        <a href="{{route('master_maintenance_unit.index')}}" style="height: 40px; align-self:end;" class="btn btn-secondary">Reset</a>
                                    </div>
                                    &nbsp;
                                 
                                </form>
                                <div style="font-size:14px;" class="result-selected">
                                        @if ($maintenance_data->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div style="width:50%;" class="alert alert-warning">
                                                Bulan :  {{$bulan}}
                                                <br>
                                                Tahun : {{$tahun}}
                                                <!-- Menampilkan tahun yang dipilih dari array $year -->
                                                 </div>
                                        @elseif($maintenance_data->isEmpty())
                                        <div class="alert alert-warning">
                                            Tidak ada data.
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
                                            <th>Unit</th>
                                            <th>Tipe Perawatan</th>
                                            <th>Detail</th>
                                            <th>Biaya</th>
                                            <th>Tanggal Perawatan</th>
                                            <th>Nama Mekanik</th>
                                            <th>Foto</th>
                                            <th>Created At</th>
                                            <th>Created By</th>
                                            <th>Updated At</th>
                                            <th>Updated By</th>
                                           
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($maintenance_data as $maintenance)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href="{{route('maintenance_unit_edit', $maintenance->id)}}"><i class="fas fa-edit"></i></a>
                                                {{-- <a style="size: 12px;" href="#" data-toggle="modal" data-target="#deleteUnit{{$maintenance->id}}"><i class="fas fa-trash"></i></a> --}}
                                            </td>
                                            <td>{{$maintenance->unit}}</td>
                                            <td>{{$maintenance->maintenance_type}}</td>
                                            <td><textarea cols="30" rows="5" readonly>{{$maintenance->maintenance_detail}}</textarea></td>
                                            <td>{{"Rp." . number_format($maintenance->cost)}}</td>
                                            <td>{{$maintenance->maintenance_date}}</td>
                                            <td>{{$maintenance->mechanic_name}}</td>
                                            <td>{{$maintenance->foto}}</td>
                                            <td>{{$maintenance->created_at}}</td>
                                            <td>{{$maintenance->created_by}}</td>
                                            <td>{{$maintenance->updated_at}}</td>
                                            <td>{{$maintenance->updated_by}}</td>
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