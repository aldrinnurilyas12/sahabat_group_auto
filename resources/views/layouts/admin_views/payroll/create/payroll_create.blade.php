<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buat Payroll - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

                <section id="cart">

                    <div style="display: flex; flex-wrap:wrap; gap:10px;" class="flex-chart">
                        <div class="col-xl-8 col-lg-7">
                            <a style="margin-bottom: 10px;"
                                href="{{ route('get_employee_detail', $payroll_detail->first()->id) }}"
                                class="btn btn-info"><i class="fas fa-chevron-left"></i> &nbsp;Kembali</a>
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Statistik Presensi Karyawan</h6>

                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div id="revenueChart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Presensi Rate per Month</h6>

                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div style="display: flex; justify-content:center;" id="">
                                        <h1 style="font-size: 72px;" class="text-success">
                                            {{ sprintf('%.0f', $payroll_detail->first()->attendance_rate_permonth) }} %
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section id="info">
                    <div id="content">

                        <h4 style="text-align:center;color:black;font-weight:bold;">Payroll Detail Karyawan</h4>
                        <form action="{{ route('master_payroll.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div style="display: flex; gap:50px;flex-wrap:wrap;" class="form-group-content">

                                @foreach ($employee_data as $emp)
                                    <div style="display: flex; justify-content:center; gap:3rem;width:100%;"
                                        class="dflex-container">
                                        <div class="form_input">
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->nik }}" autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <input hidden type="text" class="form-control" name="employee_id"
                                                    value="{{ $emp->id }}">
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Karyawan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->name }}" autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->email }}" autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Posisi Pekerjaan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->job_position }}" autocomplete="off" readonly
                                                    readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Kantor</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->location_name }}" autocomplete="off" readonly>
                                            </div>

                                        </div>

                                        <div class="form_input">

                                            <div class="form-group">
                                                <label>Bank</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->bank }}" autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>No.Rekening Bank</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $emp->bank_account }}" autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Gaji Pokok</label>
                                                <input type="text" class="form-control"
                                                    value="{{ 'Rp.' . number_format($emp->salary) }}"
                                                    autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Tunjangan Transport</label>
                                                <input type="text" class="form-control"
                                                    value="{{ 'Rp.' . number_format($emp->tunjangan_transport) }}"
                                                    autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Tunjangan Kesehatan</label>
                                                <input type="text" class="form-control"
                                                    value="{{ 'Rp.' . number_format($emp->tunjangan_kesehatan) }}"
                                                    autocomplete="off" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Tunjangan Lainnya</label>
                                                <input type="text" class="form-control"
                                                    value="{{ 'Rp.' . number_format($emp->tunjangan_lainnya) }}"
                                                    autocomplete="off" readonly placeholder="Masukan Alamat Cabang">
                                            </div>

                                            <div class="form-group">
                                                <label>Total Gaji</label>
                                                <input type="text" class="form-control"
                                                    value="{{ 'Rp.' . number_format($emp->salary_total) }}"
                                                    autocomplete="off" readonly>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @php
                                use Carbon\Carbon;

                                $payroll = $payroll_detail->first();
                                $payrollDate =
                                    $payroll && $payroll->payroll_approval_date
                                        ? Carbon::parse($payroll->payroll_approval_date)
                                        : null;

                            @endphp

                            {{-- FIX BUG : JIKA TANGGAL PAYROLL APPROVE SUDAH LEWAT MAKA MUNCULKAN/TAMPILKAN FORM UPLOAD BAYAR UNTUK FINANCE STAFF --}}




                            @if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Finance Staff')
                                <hr>

                                <div style="padding: 40px;" class="attachment-file">

                                    <div style="padding: 40px;" class="attachment-file">
                                        <h5 style="color: black;"><strong> Upload Bukti Pembayaran Payroll</strong>
                                        </h5>
                                        <div style="font-size: 13px;" class="alert alert-warning">
                                            <ul>
                                                <li>Pembayaran Payroll Hanya dilakukan oleh Finance Staff</li>
                                                <li>File harus berektensi : jpg,png,jpeg.</li>
                                            </ul>
                                        </div>


                                        @if ($checking_signature->isNotEmpty())
                                            <input class="form-control" type="file" name="payroll_file"
                                                id="">
                                            <br>
                                            <button type="submit" class="btn btn-primary">Simpan Payroll</button>
                                        @else
                                            <p class="text-danger">*Anda belum upload tanda tangan digital, harap
                                                upload terlebih dahulu.</p>
                                            <a class="btn btn-primary" href="{{ route('profile') }}">Upload Tanda
                                                Tangan</a>
                                        @endif


                                    </div>

                                </div>
                            @else
                            @endif
                        </form>

                        <br>





                    </div>
                    {{-- @else
                    @endif --}}


            </div>
            </section>



        </div>



        {{-- @include('layouts.admin_views.footer') --}}

    </div>
    <!-- End of Content Wrapper -->
    @yield('content')

    </div>
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


    {{-- MODAL SHOW PAYMENT --}}
    @foreach ($payroll_detail as $emp)
        <div class="modal fade" id="showPayment{{ $emp->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $emp->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="color: black;" class="modal-title" id="exampleModalLabel{{ $emp->id }}">
                            Bukti pembayaran Gaji Karyawan {{ $emp->nik . ' - ' . $emp->name }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="img-attachment">
                        <iframe style="height: 600px;width:100%;" src="{{ '../storage/' . $emp->payroll_file }}"
                            alt=""></iframe>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
    {{-- END MODAL --}}


</body>

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


    //  analytics

    let payrollId = <?php echo json_encode($payroll_detail->first()->id); ?>;

    fetch('/get_attendance/' + payrollId)
        .then(response => response.json())
        .then(data => {
            var options = {
                series: [{
                    name: "jumlah",
                    data: [
                        data.total_hadir[0]?.total_hadir || 0,
                        data.total_izin[0]?.total_izin || 0,
                        data.total_sakit[0]?.total_sakit || 0,
                        data.total_alpha_ongoing[0]?.total_alpha_ongoing || 0,
                    ]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight' // Mengubah menjadi 'smooth' untuk tampilan yang lebih baik
                },
                title: {
                    text: 'Statistik Presensi Karyawan ' + new Date().toLocaleString('default', {
                        month: 'long',
                        year: 'numeric'
                    }),
                    align: 'center'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // Mengatur warna baris
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: data.attendance_type // Menggunakan daftar bulan dari server
                }
            };

            var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
            chart.render();
        })
        // console.log(response.json());

        .catch(error => console.error('Error fetching revenue data:', error)); // Menangani error
</script>

</html>
