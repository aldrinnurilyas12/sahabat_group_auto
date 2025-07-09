<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Tambah data Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Tambah Data Karyawan</h4>
                <div class="form-group-content">


                    <form class="form_input" method="POST" action="{{ route('master_employee.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>NIK <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="nik" value="{{ old('nik') }}"
                                placeholder="Masukan 16 digit angka NIK" autocomplete="off">
                            <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label>Nama Karyawan <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Masukan nama karyawan [Gunakan Huruf Kapital]" autocomplete="off">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="form-group">
                            <label>Tanggal Lahir <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="birth_date" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Alamat <span style="color: red">*</span></label>
                            <input type="text" class="form-control" value="{{ old('address') }}" name="address"
                                placeholder="Masukan alamat" autocomplete="off">
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label for="">No.Telepon <span style="color: red">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text" class="form-control" name="phone_number"
                                    value="{{ old('phone_number') }}" placeholder="Masukan nomor telepon/hp karyawan"
                                    autocomplete="off">
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="email" value="{{ old('email') }}"
                                placeholder="Masukan email" autocomplete="off">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div class="form-group">
                            <label for="">Cabang <span style="color: red">*</span></label>

                            <select class="form-control" name="branch_id" id="">
                                <option value="">--- pilih cabang ---</option>
                                @foreach ($branch as $cabang)
                                    <option value="{{ $cabang->id }}">
                                        {{ $cabang->location_code . ' - ' . $cabang->location_name }}</option>
                                @endforeach
                                <x-input-error :messages="$errors->get('branch_id')" class="mt-2" />
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="">Posisi Pekerjaan <span style="color: red">*</span></label>

                            <select class="form-control" name="job_position" id="">
                                <option value="">--- pilih posisi pekerjaan---</option>
                                @foreach ($job_position as $job)
                                    <option value="{{ $job->id }}">{{ $job->position_name }}</option>
                                @endforeach
                                <x-input-error :messages="$errors->get('job_position')" class="mt-2" />
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="">Posisi Level Pekerjaan <span style="color: red">*</span></label>

                            <select class="form-control" name="job_level_position" id="">
                                <option value="">--- pilih level posisi ---</option>
                                @foreach ($job_level_position as $level)
                                    <option value="{{ $level->id }}">
                                        {{ $level->level_position_name }}</option>
                                @endforeach
                                <x-input-error :messages="$errors->get('job_level_position')" class="mt-2" />
                            </select>

                        </div>

                        <div class="form-group">
                            <label for="">Jenis Pekerjaan Karyawan<span style="color: red">*</span></label>

                            <select class="form-control" name="type_of_employee" id="">
                                <option value="">=== Pilih Tipe Karyawan ===</option>
                                <option value="permanent">Karyawan Tetap</option>
                                <option value="contract">Karyawan Kontrak</option>
                                <option value="freelance">Karwayan Freelance</option>
                                <option value="internship">Karyawan Magang</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Mulai Bekerja <span style="color: red">*</span></label>
                            <input type="date" class="form-control" name="start_date" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label>Tanggal Akhir Bekerja (Hanya untuk Karyawan Kontrak & Internship) <span
                                    style="color: red">*</span></label>
                            <input type="date" class="form-control" name="end_date" autocomplete="off">
                        </div>

                        <hr>
                        <div class="form-group">
                            <label for="">Bank</span></label>

                            <select class="form-control" name="bank_id" id="">
                                <option value="">--- pilih Bank ---</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="form-group">
                            <label>Nomor Rekening Karyawan</label>
                            <input type="text" class="form-control" name="bank_account"
                                value="{{ old('bank_account') }}" placeholder="Masukan No.Rekening Karyawan"
                                autocomplete="off">
                        </div>
                        <hr>


                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>

                </div>
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
