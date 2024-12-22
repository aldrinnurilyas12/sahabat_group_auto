<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Simulasi Kredit - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
                        <div  class="card-header py-3">
                            <a href="{{ route('add_credit_simulation',['id' => $credit_simulation->first()->id ]) }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>&nbsp;Tambah Data Simulasi Kredit
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Unit</th>
                                            <th>Harga Unit</th>
                                            <th>Biaya DP Unit</th>
                                            <th>Asuransi</th>
                                            <th>Tenor 12 Bulan</th>
                                            <th>Tenor 24 Bulan</th>
                                            <th>Tenor 36 Bulan</th>
                                            <th>Tenor 48 Bulan</th>
                                            <th>Tenor 60 Bulan</th>
                                            <th>Tenor 72 Bulan</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        <?php $no = 1;  ?>
                                        @foreach($credit_simulation as $credit)
                                        <tr>
                                            <td><?php echo $no++ ?></td>
                                            <td><div style="display:flex; justify-content:center;gap:8px; " class="action">
                                                <a href="{{route('edit_credit_simulation',  $credit->id)}}"><i class="fas fa-edit"></i></a>
                                                <form action="{{route('master_credit_simulation.destroy', $credit->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button style="width:25px;justify-content:center;display:flex;" class="btn btn-primary" type="submit"><i  class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                            <td>{{$credit->unit}}</td>
                                            <td>{{"IDR " . number_format($credit->price)}}</td>
                                            <td>{{"IDR " . number_format($credit->down_payment)}}</td>
                                            <td>{{$credit->insurance_name}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_12_month)}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_24_month)}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_36_month)}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_48_month)}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_60_month)}}</td>
                                            <td>{{"IDR " . number_format($credit->tenor_72_month)}}</td>

                                        </tr>

                                        @endforeach
                                     
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

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

    
    
    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js')}}"></script>

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

    @if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer:2000
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

</body>



</html>