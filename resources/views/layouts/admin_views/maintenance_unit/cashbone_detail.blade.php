<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Bukti Pembayaran Maintenance - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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

                    <div class="card-header py-3">
                        <h5 style="color: black;"><strong>Data Maintenance Unit PT Sahabat Group Auto</strong></h5>
                        <br>
                        <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                            <h5>Total Pengeluaran : {{ 'Rp' . number_format($repair_cost) }}</h5>



                        </div>
                    </div>


                    <div class="card-body">
                        <div style="display: flex;flex-wrap:wrap; justify-content:center;gap:20px;"
                            class="content-image">
                            @foreach ($maintenance_data as $item)
                                <div style="display: block;color:black;width:220px;height:max-content;background:rgba(249, 249, 249, 0.988);padding:10px;"
                                    class="content">
                                    <div style="display: flex; justify-content:space-between;" class="action">
                                        <p style="font-size: 13px;">
                                            {{ \Carbon\Carbon::parse($item->maintenance_date)->format('d F Y') }}</p>
                                        <div style="display:flex; gap:7px;" class="action-delete-update">
                                            <a href="{{ route('maintenance_unit_edit', $item->id) }}"><i
                                                    class="fas fa-edit"></i></a>
                                            <a style="size: 12px;" href="#" data-toggle="modal"
                                                data-target="#deleteCashbon{{ $item->id }}"><i
                                                    class="fas fa-trash"></i></a>
                                        </div>

                                    </div>
                                    <a href="#" data-toggle="modal"
                                        data-target="#showCashbon{{ $item->id }}">
                                        <img style="margin-bottom:10px;" width="200" height="180"
                                            src="{{ asset('storage/' . $item->foto) }}" alt="">
                                    </a>
                                    <h6 style="text-decoration: underline;"> <strong>{{ $item->maintenance_type }}
                                        </strong> </h6>
                                    <p style="margin-bottom:10px;width:210px;">{{ $item->maintenance_detail }}</p>
                                    <p style="margin-bottom:10px;">
                                        <strong>{{ 'Rp' . number_format($item->cost) }}</strong>
                                    </p>
                                    <hr>
                                    <div class="dflex-component">
                                        <div class="mechanic">
                                            <label for="">Mekanik</label>
                                            <p style="font-size: 14px;font-weight:bold;" class="text-main">
                                                {{ $item->mechanic_name }}
                                            </p>
                                        </div>
                                        <div class="repair-shop">
                                            <label for="">Bengkel</label>
                                            <p style="font-size: 14px;font-weight:bold;" class="text-main">
                                                {{ $item->car_repair_shop }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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

    @foreach ($maintenance_data as $mtc)
        <div class="modal fade" id="deleteCashbon{{ $mtc->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $mtc->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $mtc->id }}">Hapus data maintenance:
                            {{ $mtc->unit }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('master_maintenance_unit.destroy', $mtc->id) }}">
                        @csrf
                        @method('DELETE')
                        <div style="color: black;" class="modal-body">
                            Apakah Anda ingin menghapus data maintenance:
                            {{ $mtc->unit }} ?
                            <br>
                            <span style="font-style: italic;color:gray;font-size:12px;">*Data akan terhapus
                                permanen.</span>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- end modal --}}


    {{-- MODAL SHOW CASHBONE --}}
    @foreach ($maintenance_data as $show)
        <div class="modal fade" id="showCashbon{{ $show->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $show->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div style="display: block;" class="modal-header">
                        <div style="display: flex; justify-content:space-between;" class="header-titles">

                            <h5 class="modal-title" id="exampleModalLabel{{ $show->id }}">Kwitansi/Bon perbaikan
                                unit
                                :
                                <br>
                                <span style="color:black;">{{ $show->unit }}
                            </h5></span>

                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>

                        <hr>
                        <div style="display: flex;flex-wrap:wrap; gap:10px;font-size:13px; color:black;"
                            class="info-detail">
                            <p> Tanggal:
                                {{ \Carbon\carbon::parse($show->maintenance_date)->format('d F y') }} </p>
                            <span>|</span>
                            <p>Mekanik : {{ $show->mechanic_name }}</p>
                        </div>
                    </div>

                    <img style="height: 500px;" src="{{ asset('storage/' . $show->foto) }}" frameborder="0"></img>

                </div>
            </div>
        </div>
    @endforeach

    {{-- END --}}
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <style>
        .col-sm-12 {
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
            position: fixed;
            /* Fix posisi spinner */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            /* Spinner disembunyikan saat halaman dimuat */
            justify-content: center;
            /* Horizontal center */
            align-items: center;
            /* Vertical center */
            background-color: rgba(0, 0, 0, 0.517);
            /* Background semi-transparan */
            z-index: 9999;
            /* Pastikan spinner berada di atas konten lainnya */
        }

        .spinner-border {
            color: yellow;
            width: 3rem;
            height: 3rem;
            /* Pastikan tinggi spinner diatur */
        }
    </style>
</body>

<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

@if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
            timer: 2000,
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
            timer: 6000,
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
            timer: 2000,
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
            timer: 2000,
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
            timer: 6000,
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

                loadingSpinnerWrapper.style.display = 'none'; // Sembunyikan spinner setelah 2 detik
            }, 1000); // 2000ms = 2 detik
        } else {
            console.log("Elemen spinner tidak ditemukan!");
        }
    });
</script>


</html>
