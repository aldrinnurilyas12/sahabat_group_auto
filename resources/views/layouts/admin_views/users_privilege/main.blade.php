<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Hak Akses/Privilege Web Pengguna - SAHABAT GROUP AUTO ADMINISTRATOR</title>


<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->

            @include('layouts.admin_views.header')
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h5 style="color: black;"><strong>Hak Akses Web Admin PT Sahabat Group Auto</strong></h5>
                        <br>
                        {{-- <a href="{{ route('menu_create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i>&nbsp;Tambah Menu Utama
                        </a> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable"
                                width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Aksi</th>
                                        <th>Nama Menu</th>
                                        <th>Allowed (Employee ID)</th>
                                        <th>Disallowed (Employee ID)</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Updated At</th>
                                        <th>Updated By</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach ($users_privilege as $main)
                                        <tr style="width: 200px;">
                                            <td><?php echo $no++; ?></td>
                                            <td style="text-align: center;"> <a style="size: 12px;" href="#"
                                                    data-toggle="modal"
                                                    data-target="#editRole{{ $main->submenu_id }}"><i
                                                        class="fas fa-edit"></i></a></td>
                                            <td>{{ $main->submenu_link }}</td>
                                            <td>
                                                @if ($main->allowed)
                                                    {{ $main->allowed }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($main->disallowed)
                                                    {{ $main->disallowed }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $main->created_at }}</td>
                                            <td>{{ $main->created_by }}</td>
                                            <td>{{ $main->updated_at }}</td>
                                            <td>{{ $main->updated_by }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- modal change status --}}







                @foreach ($users_privilege as $main)
                    @php
                        $allowedColumn = DB::table('users_privilege')
                            ->where('submenu_id', $main->submenu_id)
                            ->value('allowed');

                        $disallowedColumn = DB::table('users_privilege')
                            ->where('submenu_id', $main->submenu_id)
                            ->value('disallowed');

                        $allowedData = $allowedColumn ? array_map('intval', explode(',', $allowedColumn)) : [];

                        $disallowedData = $disallowedColumn ? array_map('intval', explode(',', $disallowedColumn)) : [];

                    @endphp

                    <div class="modal fade" id="editRole{{ $main->submenu_id }}" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel{{ $main->submenu_id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="color: black;" class="modal-title"
                                        id="exampleModalLabel{{ $main->submenu_id }}">Pengaturan
                                        Hak Akses
                                        Menu: {{ $main->submenu_name }}</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{ route('add_users_privilege', $main->submenu_id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div style="color: black;" class="modal-body">
                                        <div class="table-responsive">

                                            <div style="display: flex; gap:20px;" class="btn-permission">
                                                <button type="button" class="btn btn-primary"
                                                    onclick="checkAllAllowed()">Izinkan Semua</button>


                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="cancelClear()">Bersihkan Semua</button>
                                            </div>
                                            <br>

                                            <table style="font-size: 14px; color:black;" class="table table-bordered"
                                                id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Karyawan</th>
                                                        <th>Izinkan</th>
                                                        <th>Tidak Izinkan</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <?php $no = 1; ?>
                                                    @foreach ($employee as $emp)
                                                        <tr style="width: 200px;">
                                                            <td><?php echo $no++; ?></td>
                                                            <td>{{ '[' . $emp->nik . '] ' . $emp->name . ' - ' . $emp->job_position }}
                                                            </td>
                                                            <td>
                                                                <input class="allowed-checkbox" type="checkbox"
                                                                    name="allowed[]" value="{{ $emp->id }}"
                                                                    {{ in_array($emp->id, $allowedData) ? 'checked' : '' }}>
                                                            </td>

                                                            <td>
                                                                <input class="disallowed-checkbox" type="checkbox"
                                                                    name="disallowed[]" value="{{ $emp->id }}"
                                                                    {{ in_array($emp->id, $disallowedData) ? 'checked' : '' }}>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- end modal --}}
            </div>

            @include('layouts.admin_views.footer')
        </div>


    </div>

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
</body>

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
            icon: 'error',
            timer: 2000,
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (Session::has('delete_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_success') }}",
            icon: 'success',
            timer: 2000,
            confirmButtonText: 'OK'
        });
    </script>
@endif
<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

<script>
    window.addEventListener('load', function() {
        var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');

        // Log elemen untuk memastikan spinner ditemukan
        console.log(loadingSpinnerWrapper); // Cek apakah elemen ditemukan

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



    // SCRIPT FOR BUTTON ALL ALLOWED :
    function checkAllAllowed() {
        document.querySelectorAll('.allowed-checkbox').forEach(cb => cb.checked = true);
        document.querySelectorAll('.disallowed-checkbox').forEach(cb => cb.checked = true);
    }

    function cancelClear() {
        document.querySelectorAll('.allowed-checkbox').forEach(cb => cb.checked = false);
        document.querySelectorAll('.disallowed-checkbox').forEach(cb => cb.checked = false);
    }
</script>
