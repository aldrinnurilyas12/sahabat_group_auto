<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Kredit Unit - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
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

                {{-- content --}}
                <div class="container-fluid">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="header">
                                {{-- <a href="{{ route('add_credit_simulation', ['id' => $credit_simulation->first()->id]) }}"
                                    class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>&nbsp;Simulasi Kredit
                                </a> --}}

                                <div style="font-size: 13px;" class="alert alert-info">
                                    <ul>
                                        <li>Info! </li>
                                        <li>Untuk melakukan penambahan Data Kredit untuk unit kendaraan hanya ada di
                                            menu Master Data Unit Kendaraan.</li>
                                        <li>Menu Master > pilih "Unit Kendaraan" > klik "Detail" > pilih menu "Simulasi
                                            Kredit" .</li>

                                    </ul>
                                </div>

                                <div style="display: flex; gap:10px; class="center-download">
                                    <form action="{{ route('export_credit_excel') }}" method="POST">
                                        @csrf
                                        <input type="text" name="vehicle_id" value="{{ $request_unit }}" hidden>

                                        <input type="text" name="unit" value="{{ $request_unit }}" hidden>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-file-excel"></i>
                                            &nbsp; Excel
                                        </button>
                                    </form>

                                    <form action="{{ route('export_credit_pdf') }}" method="POST">
                                        @csrf
                                        <input type="text" name="vehicle_id" value="{{ $request_unit }}" hidden>
                                        <input type="text" name="unit" value="{{ $request_unit }}" hidden>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-file"></i>
                                            &nbsp; PDF
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <br>
                            {{-- FILTER DATA --}}
                            <div style="display: flex;flex-wrap:wrap;gap:10px;justify-content:space-between;align-items:center;"
                                class="container-btn">
                                <div style="color: black;" class="form-group">
                                    <form action="{{ route('filter_credit_data') }}" method="GET">

                                        <div style="display: flex;gap:10px;" class="grouped-container">
                                            <div style="display: block" class="select-group">
                                                <label style="font-weight:bold; color:black;" for="">Pilih Unit
                                                    Kendaraan</label>
                                                <select class="form-control" name="vehicle_id" id="branch">
                                                    <option value="">--- Pilih Unit ---</option>
                                                    <option value="alldata">Semua Unit</option>
                                                    @foreach ($vehicle as $item)
                                                        <option value="{{ $item->vehicle_id }}">
                                                            {{ $item->unit }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <button style="height: 40px; align-self:end;" type="submit"
                                                class="btn btn-primary">Pilih</button>
                                            <a href="{{ route('master_credit_simulation.index') }}"
                                                style="height: 40px; align-self:end;"
                                                class="btn btn-secondary">Reset</a>
                                        </div>
                                        &nbsp;

                                    </form>

                                    <div style="font-size:14px;" class="result-selected">
                                        @if ($credit_simulation->isNotEmpty())
                                            <strong>
                                                Data terpilih:
                                            </strong>
                                            <br>
                                            <!-- Memastikan bahwa $month adalah objek dan mengakses propertinya, misalnya 'name' -->
                                            <div class="alert alert-warning">
                                                Data Kredit Unit Kendaraan : {{ $request_unit }}
                                                <br>

                                            </div>
                                        @elseif($credit_simulation->isEmpty())
                                            <div class="alert alert-warning">
                                                Tidak ada data.
                                            </div>
                                        @endif


                                    </div>

                                </div>


                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable"
                                    width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Unit</th>
                                            <th>Harga Unit</th>
                                            <th>Biaya DP</th>
                                            <th>Total Harga DP</th>
                                            <th>Bunga Pinjaman (%)</th>
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
                                        <?php $no = 1; ?>
                                        @foreach ($credit_simulation as $credit)
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <div style="display:flex; justify-content:center;gap:8px; "
                                                        class="action">
                                                        <a href="{{ route('edit_credit_simulation', $credit->id) }}"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a style="size: 12px;" href="#" data-toggle="modal"
                                                            data-target="#deleteCredit{{ $credit->id }}"><i
                                                                class="fas fa-trash"></i></a>
                                                </td>
                                                <td>{{ $credit->unit }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->credit_price) }}</td>
                                                <td>{{ $credit->down_payment . '%' }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->total_down_payment) }}
                                                </td>
                                                <td>
                                                    @if ($credit->interest_rate)
                                                        {{ $credit->interest_rate }}
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $credit->insurance_name }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_12_month) }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_24_month) }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_36_month) }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_48_month) }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_60_month) }}</td>
                                                <td>{{ 'Rp ' . number_format($credit->tenor_72_month) }}</td>

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


    @foreach ($credit_simulation as $credit)
        <div class="modal fade" id="deleteCredit{{ $credit->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $credit->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $credit->id }}">Hapus data cabang:
                            {{ $credit->unit }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form action="{{ route('master_credit_simulation.destroy', $credit->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div style="color: black;" class="modal-body">
                            Apakah Anda ingin menghapus data kredit:
                            {{ $credit->unit }} ?
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


    <!-- Page level plugins -->
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

    @if (Session::has('failed_insert'))
        <script>
            Swal.fire({
                title: 'Gagal',
                text: "{{ Session::get('failed_insert') }}",
                icon: "error",
                timer: 3000,
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
                timer: 2000
            });
        </script>
    @endif


    @if (Session::has('delete_success'))
        <script>
            Swal.fire({
                title: 'Berhasil',
                text: "{{ Session::get('delete_success') }}",
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

</body>



</html>
