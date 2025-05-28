<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<title>Cuti Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>

<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">PERNYATAAN CUTI KARYAWAN</h4>
                <div class="form-group-content">

                    @foreach ($employee as $emp)
                        <form class="form_input" method="POST" action="{{ route('employee_leaves.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" class="form-control" value="{{ $emp->nik }}" readonly
                                    autocomplete="off">

                            </div>
                            <div class="form-group">
                                <label>Nama Karyawan </label>
                                <input type="text" class="form-control" value="{{ $emp->name }}" readonly
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Cabang</label>
                                <input type="text" class="form-control" value="{{ $emp->location_name }}" readonly
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control" value="{{ $emp->department_name }}" readonly
                                    autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label>Posisi Pekerjaan </label>
                                <input type="text" class="form-control" value="{{ $emp->job_position }}" readonly
                                    autocomplete="off">
                            </div>
                            <hr>
                            <h5 style="color: black;"><strong>Silahkan isi form Pengajuan Cuti Karyawan</strong></h5>
                            <hr>

                            <div class="form-group">
                                <label for="">Tipe Cuti<span style="color: red">*</span></label>
                                <select class="form-control" name="type_of_leave">
                                    <option value="">-- Pilih Alasan Cuti --</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="izin_keluarga">Keperluan Keluarga</option>
                                    <option value="melahirkan">Cuti Melahirkan</option>
                                    <option value="menikah">Menikah</option>
                                    <option value="urusan_pribadi">Urusan Pribadi</option>
                                    <option value="berduka">Keluarga Meninggal Dunia</option>
                                    <option value="cuti_tahunan">Cuti Tahunan</option>
                                    <option value="cuti_besar">Cuti Besar</option>
                                    <option value="ibadah">Ibadah (misalnya Umrah/Haji)</option>
                                    <option value="pendidikan">Keperluan Pendidikan</option>
                                    <option value="force_majeure">Keadaan Darurat / Force Majeure</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alasan Cuti </label>
                                <textarea class="form-control" name="reason" id="" cols="30" rows="3"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mulai Cuti<span style="color: red">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    autocomplete="off">
                                @if ($errors->has('start_date'))
                                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Tanggal Akhir Cuti<span style="color: red">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="end_date"
                                    autocomplete="off">
                                @if ($errors->has('end_date'))
                                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="">Upload Surat Cuti (Format Surat : PDF) <span
                                        style="color: red">*</span></label>
                                <input class="form-control" type="file" name="attachment">
                                @if ($errors->has('attachment'))
                                    <span class="text-danger">{{ $errors->first('attachment') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="checkbox"> Dengan ini saya menyatakan pengajuan Cuti diri saya
                                dan serta menandatangani surat pernyataan Cuti Karyawan
                                kepada perusahaan PT Sahabat Group Auto.
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    @endforeach

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


@if (session('alert'))
    <script type="text/javascript">
        alert('{{ session('alert') }}');
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
