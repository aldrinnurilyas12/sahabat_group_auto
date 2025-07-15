<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings - SAHABAT GROUP AUTO ADMINISTRATOR</title>
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

                <div class="card shadow mb-4">
                    <div style="color:black;" class="card-header py-3">
                        <h5><strong>Settings Web Administrator</strong></h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <form action="{{ route('setting_time') }}" method="POST">
                                @method('PUT')
                                @csrf
                                <h5 style="color:black;"> Jam Operasional Web Administrator</h5>
                                <select class="form-control" name="open_schedule_time" id="">
                                    <option value="#">==== Pilih ====</option>
                                    <option value="on">ON</option>
                                    <option value="off">OFF</option>
                                </select>
                                <p>
                                    @if ($setting_time->open_schedule_time == 'on')
                                        <p>Setting Time : <span class="text-success">Aktif</span></p>
                                    @else
                                        <p>Setting Time : <span class="text-secondary">Tidak Aktif</span></p>
                                    @endif
                                    <br>
                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                            </form>

                        </div>
                    </div>
                </div>


                @if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology')
                    <div class="card shadow mb-4">
                        <div style="color:black;" class="card-header py-3">
                            <h5><strong>Settings Under Development</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <form action="{{ route('setting_development') }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    <div style="display: block;" class="form-group">
                                        <label style="color:black;" for="">Pilih Web</label>
                                        <div style="display: flex;gap:10px;" class="input-group">
                                            <input type="checkbox" name="admin_web" value="Ya"
                                                {{ $setting_app->admin_web == 'Ya' ? 'Checked' : '' }}>Admin Web
                                            <input type="checkbox" name="landing_page_web" value="Ya"
                                                {{ $setting_app->landing_page_web == 'Ya' ? 'Checked' : '' }}>Landing
                                            Page
                                        </div>
                                    </div>

                                    <label style="color:black;" for="">Deskripsi Development</label>
                                    <div class="form-group">
                                        <input class="form-control" value="{{ $setting_app->description }}"
                                            type="text" name="description" placeholder="Masukkan Deskripsi"
                                            autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Tanggal Mulai Maintenance</label>
                                        <input class="form-control" value="{{ $setting_app->description }}"
                                            type="date" name="start_date_maintenance">
                                        <br>
                                        <label for="">Jam Mulai Maintenance</label>
                                        <input class="form-control" value="{{ $setting_app->description }}"
                                            type="time" name="time_start_date_maintenance">
                                    </div>
                                    <br>

                                    <div class="form-group">
                                        <label for="">Tanggal Akhir Maintenance</label>
                                        <input class="form-control" value="{{ $setting_app->description }}"
                                            type="date" name="end_date_maintenance">
                                        <br>
                                        <label for="">Jam Akhir Maintenance</label>
                                        <input class="form-control" value="{{ $setting_app->description }}"
                                            type="time" name="time_end_date_maintenance">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @else
                @endif

                <div class="card shadow mb-4">
                    <div style="color:black;" class="card-header py-3">
                        <h5><strong>Status Maintenance</strong></h5>
                    </div>
                    <div style="background: rgb(255, 255, 255);" class="card-body">
                        <div class="table-responsive">
                            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Web Admin</th>
                                        <th>Landing Page Web</th>
                                        <th>Deskripsi</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Jam Mulai</th>
                                        <th>Tanggal Akhir</th>
                                        <th>Jam Akhir</th>
                                        <th>Dibuat pada</th>
                                        <th>Dibuat oleh</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($settings_data as $setting)
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td>
                                                @if ($setting->admin_web == 'Ya')
                                                    <span style="height: max-content;font-size:14px;"
                                                        class="badge badge-success">
                                                        Ya</span>
                                                @else
                                                    <span style="height: max-content;font-size:14px;"
                                                        class="badge badge-danger">
                                                        Tidak</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($setting->landing_page_web == 'Ya')
                                                    <span style="height: max-content;font-size:14px;"
                                                        class="badge badge-success">
                                                        Ya</span>
                                                @else
                                                    <span style="height: max-content;font-size:14px;"
                                                        class="badge badge-danger">
                                                        Tidak</span>
                                                @endif
                                            </td>
                                            <td>{{ $setting->description }}</td>
                                            <td>{{ $setting->start_date_maintenance }}</td>
                                            <td>{{ $setting->time_start_date_maintenance }}</td>
                                            <td>{{ $setting->end_date_maintenance }}</td>
                                            <td>{{ $setting->time_end_date_maintenance }}</td>
                                            <td>{{ $setting->updated_at }}</td>
                                            <td>{{ $setting->created_by }}</td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            @include('layouts.admin_views.footer')


        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>

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

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        /* Hide default HTML checkbox */
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        /* The slider */
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

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

    @if (Session::has('failed_insert'))
        <script>
            Swal.fire({
                title: 'Gagal',
                text: "{{ Session::get('failed_insert') }}",
                icon: "error",
                timer: 2000,
                confirmButtonText: 'OK'
            });
        </script>
    @elseif(Session::has('message_success'))
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
</body>

</html>
