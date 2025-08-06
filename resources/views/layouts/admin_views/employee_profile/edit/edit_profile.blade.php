<link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
<!-- Custom styles for this template-->
<link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<title>Edit data Karyawan - SAHABAT GROUP AUTO ADMINISTRATOR</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<body>
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div style="background: white;">
                @include('layouts.admin_views.header')
                <h4 style="text-align:center;color:black;font-weight:bold;">Profil Pengguna
                    [{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name }}]
                </h4>
                <div style="display: flex; flex-wrap:wrap;gap:30px;justify-content:center;width:100%;"
                    class="form-group-content">

                    <div class="card-shadow-profile">
                        <div class="card-header py-3">
                            <h6 class="mb-2 font-weight-bold text-primary">Informasi akun</h6>
                        </div>
                        <div class="card-body">
                            <div style="display: flex; justify-content:center;" class="profile-image-content">

                                @if ($user_picture->isNotEmpty())
                                    <img style="border-radius:50%;"
                                        src="{{ asset('storage/' . $user_picture->first()->users_foto) }}"
                                        width="200" height="200" title="Foto Profil">
                                @else
                                    <div style="width: 100px; height:100px; background:rgb(152, 135, 214);border-radius:50%;color:rgb(255, 255, 255);display:flex; justify-content:center; align-items:center;"
                                        class="cirlce-username">
                                        <h3>{{ $username->first()->user_name }}</h3>
                                    </div>
                                @endif
                            </div>
                            <br>
                            <div style="display:flex;justify-content:center;" class="qr-code">
                                @if ($qr_code_employee->first()->qr_code_path == null)
                                    <form method="POST"
                                        action="{{ route('generate_qr_code', $employee->first()->nik) }}">
                                        @csrf
                                        @method('PUT')

                                        <button type="submit" id="generateqr" class="btn btn-primary"><i
                                                class="fa fa-qrcode" style="font-size:15px"></i> Generate Kode
                                            QR</button>
                                    </form>
                                @else
                                    <img src="{{ asset('storage/' . $qr_code_employee->first()->qr_code_path) }}"
                                        width="80" height="80" title="Kode QR">
                                @endif
                            </div>
                            <br>
                            <h4 style="font-size: 14px;color:rgb(1, 1, 1);text-align:center;">
                                <strong>{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name }}</strong>
                            </h4>
                            <h4 style="font-size: 14px;color:rgb(178, 178, 178);text-align:center;font-style:italic;">
                                {{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name }}
                            </h4>
                            <h4 style="font-size: 14px;color:rgb(0, 0, 0);text-align:center;font-style:italic;">
                                {{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name }}
                            </h4>
                            <hr>

                            @if ($qr_code_employee->first()->qr_code_path == null)
                            @else
                                <div style="display: flex; justify-content:center;" class="id-card">
                                    <a class="btn btn-primary" href="#" id="openIdCardBtn">
                                        <i class='fas fa-id-card-alt'></i> ID Card
                                    </a>
                                </div>
                            @endif
                            <hr>
                            @if ($user_picture->isNotEmpty())
                                <div style="display: block; gap:10px;" class="button-component">
                                    <form action="{{ route('update_picture', $employee->first()->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <label style="color: black;" for=""><strong>Ubah Foto</strong></label>
                                        <input type="text" name="user_id"
                                            value="{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id }}"
                                            hidden>
                                        <input type="file" name="users_foto">
                                        <br>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Simpan Foto</button>
                                        <button type="button" id="deleteFoto" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            @else
                                <form action="{{ route('users_picture') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <label style="color: black;" for=""><strong>Pasang Foto</strong></label>
                                    <input type="text" name="user_id"
                                        value="{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id }}"
                                        hidden>
                                    <input type="file" name="users_foto">
                                    <br>
                                    <br>
                                    <button type="submit" class="btn btn-primary">Simpan Foto</button>
                                </form>
                            @endif
                            <br>
                            <hr>
                            <div class="signature-img">
                                @if ($signature_employee->isNotEmpty())
                                    <div style="display: flex;justify-content:center;" class="center-signature">
                                        <img src="{{ asset('storage/' . $signature_employee->first()->signature) }}"
                                            width="80" height="80" alt="">
                                    </div>
                                @else
                                    <strong class="text-danger">*Belum Upload Tanda Tangan</strong>
                                @endif

                                @if ($signature_employee->isNotEmpty())
                                    <div style="display: flex;justify-content:space-between;"
                                        class="signature-component">

                                        <div class="form-update-signature">
                                            <label style="color: black;" for=""><strong>Ubah Tanda
                                                    Tangan</strong></label>
                                            <form
                                                action="{{ Route('upload_update_signature', $employee->first()->id) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="file" name="signature">
                                                <br>
                                                <br>
                                                <button class="btn btn-primary">Upload</button>
                                                <a class="btn btn-danger" href="#" data-toggle="modal"
                                                    data-target="#deleteSignature">Hapus</a>
                                            </form>
                                        </div>


                                    </div>
                                @else
                                    <form action="{{ Route('upload_signature') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <label style="color: black;" for=""><strong>Upload Tanda Tangan
                                                Digital</strong></label>
                                        <input type="file" name="signature">
                                        <br>
                                        <br>
                                        <button class="btn btn-primary">Upload</button>
                                    </form>
                                @endif
                            </div>
                            <br>
                            <hr>


                            <div class="signature-img">
                                <label style="color: black;" for=""><strong>Payroll</strong></label>
                                <br>
                                <a class="btn btn-primary" href="{{ route('show_payroll') }}">Lihat Payroll Anda</a>
                            </div>

                            <br>
                            <hr>


                            <div class="signature-img">
                                <label style="color: black;" for=""><strong>Pengajuan Cuti
                                        Karyawan</strong></label>
                                <br>


                                @php
                                    use Carbon\Carbon;
                                    $absence = $checking_absences_status;
                                    $endDate = $absence ? Carbon::parse($absence->end_date) : null;
                                @endphp

                                @if ($checking_absences_status)


                                    @if ($endDate && $endDate->lt(Carbon::today()))
                                        <div style="display: flex; gap:7px;" class="dflex-cuti">

                                            <a class="btn btn-primary"
                                                href="{{ route('employee_absences_leaves') }}">Ajukan
                                                Cuti</a>

                                            <a style="color: black;" class="btn btn-warning"
                                                href="{{ asset('assets/word_files/SuratCutiKaryawanSahabatGroupAuto.docx') }}"
                                                download><i class="fas fa-file-word"></i> Surat Cuti</a>
                                        </div>
                                    @else
                                        <div style="display: flex; gap:5px;" class="pdf-resign-download">
                                            <a class="btn btn-secondary" href="">Sudah Pengajuan Cuti</a>

                                            @if ($checking_absences_status->status == 'sudah konfirmasi')
                                                <a class="btn btn-primary"
                                                    href="{{ route('get_absences_letter', $checking_absences_status->absences_code) }}"><i
                                                        class="fa fa-file"></i>&nbsp;<span>Unduh</span></a>
                                            @else
                                            @endif
                                        </div>
                                        <br>

                                        <div style="display: flex;flex-wrap:wrap; gap:20px;" class="resign-date">
                                            <span style="color: black;font-size:13px;">Tanggal Mulai Cuti :
                                                <br>
                                                <strong>
                                                    {{ \Carbon\Carbon::parse($checking_absences_status->start_date)->translatedFormat('d F Y') }}</strong></span>

                                            <span style="color: black;font-size:13px;">Tanggal Akhir Cuti :
                                                <br>
                                                <strong>
                                                    {{ \Carbon\Carbon::parse($checking_absences_status->end_date)->translatedFormat('d F Y') }}</strong></span>

                                            <span style="color: black;font-size:13px;">Cuti Attachment :
                                                @if ($checking_absences_status->attachment)
                                                    <br><strong>Ada </strong>
                                                @else
                                                    <br><strong><span class="text-danger">-</span></strong>
                                                @endif
                                            </span>

                                            @if ($checking_absences_status->status == 'sudah konfirmasi')
                                                <span style="color:black;font-size:13px;">Status Cuti :
                                                    <br><strong> <span
                                                            class="text-success">{{ $checking_absences_status->status }}</span></strong>
                                                </span>
                                            @else
                                                <span style="color:black;font-size:13px;">Status Cuti :
                                                    <br>
                                                    <strong><span
                                                            class="text-danger">{{ $checking_absences_status->status }}</span></strong>
                                                </span>
                                            @endif

                                            <span style="color: black;font-size:13px;">HR Confirmed :
                                                <br><strong>{{ $checking_absences_status->approval_by_hr_head }}
                                                </strong>
                                            </span>

                                            <span style="color: black;font-size:13px;">Branch Confirmed :
                                                <br><strong>{{ $checking_absences_status->approval_by_branch_head }}</strong>
                                            </span>


                                            <span style="color: black;font-size:13px;">Tanggal buat :
                                                <br>
                                                <strong>{{ \Carbon\Carbon::parse($checking_absences_status->created_at)->translatedFormat('d F Y | h:m ') }}</strong>
                                            </span>

                                            <span style="color: black;font-size:13px;">Tanggal Konfirmasi :
                                                <br><strong>{{ \Carbon\Carbon::parse($checking_absences_status->updated_at)->translatedFormat('d F Y | h:m ') }}</strong>
                                            </span>

                                            @if ($checking_absences_status->status == 'cuti ditolak')
                                                <span style="color: black;font-size:13px;">alasan HR Head :
                                                    <br><strong>{{ $checking_absences_status->hr_reason_of_reject }}</strong>
                                                </span>

                                                <span style="color: black;font-size:13px;">alasan Branch Head :
                                                    <br><strong>{{ $checking_absences_status->branch_head_reason_of_reject }}</strong>
                                                </span>
                                            @else
                                            @endif

                                        </div>
                                        <br>
                                        @if ($checking_absences_status)
                                            <a class="btn btn-info" href="{{ route('employee_leaves.index') }}">Lihat
                                                Data
                                                Cuti </a>
                                        @else
                                        @endif
                                    @endif
                                @else
                                    <div style="display: flex; gap:7px;" class="dflex-cuti">

                                        <a class="btn btn-primary"
                                            href="{{ route('employee_absences_leaves') }}">Ajukan
                                            Cuti</a>

                                        <a style="color: black;" class="btn btn-warning"
                                            href="{{ asset('assets/word_files/SuratCutiKaryawanSahabatGroupAuto.docx') }}"
                                            download><i class="fas fa-file-word"></i> Surat Cuti</a>
                                    </div>
                                @endif

                            </div>

                            <br>
                            <hr>

                            <div class="resign-employee">
                                <label style="color: black;" for=""><strong>Pengajuan Resign Karyawan
                                    </strong></label>
                                <br>
                                @if ($checking_employee_resign_status->isNotEmpty())
                                    <div style="display: flex; gap:5px;" class="pdf-resign-download">
                                        <a class="btn btn-secondary" href="">Sudah Pengajuan Resign</a>

                                        @if ($checking_employee_resign_status->first()->resign_status == 'sudah konfirmasi')
                                            <a class="btn btn-primary"
                                                href="{{ route('get_resignation_letter', $checking_employee_resign_status->first()->resign_code) }}"><i
                                                    class="fa fa-file"></i>&nbsp;<span>Unduh</span></a>
                                        @else
                                        @endif
                                    </div>
                                    <br>

                                    <div style="display: flex;flex-wrap:wrap; gap:20px;" class="resign-date">
                                        <span style="color: black;font-size:13px;">Tanggal Resign :
                                            <br>
                                            <strong>
                                                {{ \Carbon\Carbon::parse($checking_employee_resign_status->first()->resign_date)->translatedFormat('d F Y') }}</strong></span>

                                        <span style="color: black;font-size:13px;">Tanggal buat :
                                            <br>
                                            <strong>{{ \Carbon\Carbon::parse($checking_employee_resign_status->first()->created_at)->translatedFormat('d F Y | h:m ') }}</strong>
                                        </span>

                                        <span style="color: black;font-size:13px;">Resign Attachment :
                                            @if ($checking_employee_resign_status->first()->resign_attachment)
                                                <br><strong>Sudah Upload </strong>
                                            @else
                                                <br><strong><span class="text-danger">belum upload</span></strong>
                                            @endif
                                        </span>

                                        <span style="color: black;font-size:13px;">Status Resign :
                                            <br><strong>{{ $checking_employee_resign_status->first()->resign_status }}</strong>
                                        </span>


                                        <span style="color: black;font-size:13px;">HR Confirmed :
                                            <br><strong>{{ $checking_employee_resign_status->first()->approval_by_hr_head }}
                                            </strong>
                                        </span>

                                        <span style="color: black;font-size:13px;">Branch Confirmed :
                                            <br><strong>{{ $checking_employee_resign_status->first()->approval_by_branch_head }}</strong>
                                        </span>


                                        <span style="color: black;font-size:13px;">Tanggal Konfirmasi :
                                            <br><strong>{{ \Carbon\Carbon::parse($checking_employee_resign_status->first()->updated_at)->translatedFormat('d F Y | h:m ') }}</strong>
                                        </span>

                                    </div>
                                @else
                                    <div style="display: flex; gap:7px;" class="dflex-cuti">

                                        <a class="btn btn-primary" href="{{ route('resign_employee') }}">Ajukan
                                            Resign</a>

                                        <a style="color: black;" class="btn btn-warning"
                                            href="{{ asset('assets/word_files/SuratResignKaryawanSahabatGroupAuto.docx') }}"
                                            download><i class="fas fa-file-word"></i> Surat Resign</a>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="container-content">
                        <div style="padding:8px;width:100%;" class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="mb-2 font-weight-bold text-primary">Informasi Data Diri</h6>
                                <h5 style="font-size: 14px; color:black;font-weight:bold;">
                                    {{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name }}
                                </h5>
                            </div>
                            <div class="card-body">
                                @foreach ($employee as $emp)
                                    <form class="form_input" style="width:100%; margin-bottom:50px;" method="POST"
                                        action="{{ route('user_update', $emp->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label>NIK <span style="color: red">*</span></label>
                                            <input type="text" class="form-control" name="nik"
                                                value="{{ $emp->nik }}" autocomplete="off">
                                            @if ($errors->has('nik'))
                                                <span class="text-danger">{{ $errors->first('nik') }}</span>
                                            @endif

                                        </div>
                                        <div class="form-group">
                                            <label>Nama Karyawan</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $emp->name }}" autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Alamat</label>
                                            <input type="text" class="form-control" name="address"
                                                value="{{ $emp->address }}" autocomplete="off">
                                        </div>
                                        <div class="form-group">
                                            <label for="">No.Telepon</label>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">+62</div>
                                                </div>
                                                <input type="text" class="form-control" name="phone_number"
                                                    value="{{ $emp->cleaned_phone }}" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $emp->email }}" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="birth_date"
                                                value="{{ old('birth_date', $emp->birth_date ? $birth_date->format('Y-m-d') : null) }}"
                                                autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label>Kantor</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->location_name }}" autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Department</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->department_name }}" autocomplete="off" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Posisi</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->job_position }}" autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Level Posisi</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->level_position_name ?: 'belum pilih level posisi' }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipe Pekerjaan Karyawan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->type_of_employee == 'contract'
                                                    ? 'Karyawan Kontrak'
                                                    : ($emp->type_of_employee == 'permanent'
                                                        ? 'Karyawan Tetap'
                                                        : ($emp->type_of_employee == 'freelance'
                                                            ? 'Pekerja Lepas'
                                                            : ($emp->type_of_employee == 'internship'
                                                                ? 'Karyawan Magang'
                                                                : 'belum pilih tipe perkejaan'))) }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Status Karyawan</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->is_active == 'Ya' ? 'Aktif' : 'Tidak Aktif' }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" class="form-control" value="{{ $emp->bank }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Rekening Akun Bank</label>
                                            <input type="text" class="form-control"
                                                value="{{ $emp->bank_account }}" autocomplete="off" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label>Tanggal Mulai Bekerja</label>
                                            <input type="text" class="form-control" id="start_date"
                                                value="{{ old('start_date', $emp->start_date ? $start_date->format('Y-m-d') : null) }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        @if ($emp->type_of_employee == 'permanent')
                                        @else
                                            <div class="form-group">
                                                <label>Tanggal Akhir Bekerja <span
                                                        style="font-size: 13px; color:rgb(21, 21, 21);">*(Hanya Untuk
                                                        Karyawan Kontrak,Freelance, dan Internship)</span>
                                                </label>
                                                <input type="text" class="form-control" id="start_date"
                                                    value="{{ old('end_date', $emp->end_date ? $end_date->format('Y-m-d') : null) }}"
                                                    autocomplete="off" readonly>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label>Status Akun</label>
                                            <input type="text" class="form-control" id="start_date"
                                                value="{{ $emp->is_active == 'Ya' ? 'Aktif' : 'Tidak Aktif (akun anda tidak dapat digunakan setelah 10 Menit Resign diSetujui)' }}"
                                                autocomplete="off" readonly>
                                        </div>

                                        @if ($emp->is_active == 'Ya')
                                            <span class="text-secondary">*Jika anda ingin merubah seluruh data, maka
                                                lakukan perubahan di <a style="text-decoration: underline;"
                                                    href="{{ route('edit_employee', $emp->nik) }}"> Data Master
                                                    Karyawan</a></span>
                                            <br>
                                            <br>
                                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                                        @else
                                            <span class="text-secondary">*Saat ini anda tidak bisa merubah informasi
                                                data diri anda karena akun anda sudah tidak aktif</span>
                                        @endif

                                    </form>
                                @endforeach
                            </div>
                        </div>

                        {{-- UPDATE PASSWORD --}}
                        <div class="container-content">
                            <div style="padding:8px;width:100%;" class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="mb-2 font-weight-bold text-primary">Ubah Password</h6>
                                </div>

                                <div class="card-body">
                                    <form style="width: 100%;" class="form_input" method="post"
                                        action="{{ route('password.update') }}">
                                        @csrf
                                        @method('put')


                                        <div class="form-group">
                                            <label>Password saat ini</label>
                                            <input id="update_password_current_password" type="password"
                                                class="form-control" name="current_password" type="password"
                                                autocomplete="off">
                                        </div>


                                        <div class="form-group">
                                            <label>Password baru</label>
                                            <input class="form-control" id="update_password_password" name="password"
                                                type="password" autocomplete="off">
                                        </div>

                                        <div class="form-group">
                                            <label>Konfirmasi password baru</label>
                                            <input class="form-control" id="update_password_password_confirmation"
                                                name="password_confirmation" type="password" autocomplete="off">
                                        </div>

                                        @if ($emp->is_active == 'Ya')
                                            <div class="flex items-center gap-4">
                                                <button class="btn btn-primary">Ubah Password</button>

                                                @if (session('status') === 'password-updated')
                                                    <div class="alert alert-success" role="alert">
                                                        <p x-data="{ show: true }" x-show="show" x-transition
                                                            x-init="setTimeout(() => show = false, 2000)">
                                                            {{ __('Password anda berhasil diperbarui.') }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-secondary">*Saat ini anda tidak bisa merubah password
                                                anda karena akun anda sudah tidak aktif</span>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Show ID CARD --}}

            <div class="modal-id-card" id="showIdCard">
                <div class="modal-dialog-content" role="idcard">

                    <div style="text-align: center;" class="modal-header">
                        <h5 style="color:black;font-size:15px;font-weight:bold;" class="modal-title"
                            id="showIdCardTitle">
                            Kartu Karyawan PT Sahabat Group Auto
                        </h5>
                        <button class="close close-modal" type="button" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; justify-content:center; gap:20px;align-items:center;"
                            class="profile-image-content">
                            @if ($user_picture->isNotEmpty())
                                <img style="border-radius:10px;"
                                    src="{{ asset('storage/' . $user_picture->first()->users_foto) }}" width="150"
                                    height="150" title="Foto Profil">
                            @else
                                <h5>Anda belum upload foto</h5>
                            @endif

                            @if ($qr_code_employee->isNotEmpty())
                                <div style="display:flex;justify-content:center;" class="qr-code">
                                    <img src="{{ asset('storage/' . $qr_code_employee->first()->qr_code_path) }}"
                                        width="130" height="130" title="Kode QR">
                                </div>
                            @else
                                <h5>Anda belum Generate Kode QR</h5>
                            @endif
                        </div>

                        <br>
                        <hr>
                        <h4 style="font-size: 14px;color:rgb(1, 1, 1);text-align:center;">
                            <strong>{{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik . ' - ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name }}</strong>
                        </h4>
                        <h4 style="font-size: 14px;color:rgb(11, 11, 11);text-align:center;font-style:italic;">
                            {{ $employee->first()->job_position }}
                        </h4>
                        <div class="dept-name">
                            <h4 style="font-size: 14px;color:rgb(255, 255, 255);text-align:center;margin:0;">
                                {{ $employee->first()->department_name }}
                            </h4>
                        </div>
                    </div>

                </div>
            </div>

            {{-- END MODAL ID CARD --}}
            @include('layouts.admin_views.footer')
        </div>

        {{-- MOdal delete user picture --}}

        <div id="myModal" class="modal-new">
            <!-- Tambahkan style display: none untuk menyembunyikan modal saat pertama kali dimuat -->
            <div class="modal-content-new">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSignatures">Hapus foto profile?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span class="close" id="closeModalBtn">&times;</span>
                    </button>
                </div>

                <br>
                <form method="POST" action="{{ route('delete_foto', $employee->first()->id) }}">
                    @csrf
                    @method('DELETE')
                    <br>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>

        </div>
        {{-- end --}}

        {{-- modal delete signature --}}
        <div class="modal fade" id="deleteSignature" tabindex="-1" role="dialog"
            aria-labelledby="deleteSignatures" aria-hidden="true">
            <div class="modal-dialog" role="signature">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteSignatures">Hapus tanda tangan digital</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('delete_signature', $employee->first()->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>
</body>

<style>
    .card-shadow-profile {
        width: 320px;
        box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
        height: max-content;
    }


    @media only screen and (max-width: 475px) {

        .card-shadow-profile {
            width: 100%;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
        }

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

@if (Session::has('nik_uknown'))
    <script>
        Swal.fire({
            title: 'UKNOWN NIK!',
            text: "{{ Session::get('nik_uknown') }}",
            icon: 'error',
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
            showConfirmButton: false,
            timer: 2000
        });
    </script>
@endif

@if (session('alert'))
    <script type="text/javascript">
        alert('{{ session('alert') }}');
    </script>
@endif

<script>
    window.addEventListener('load', function() {
        var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');

        if (loadingSpinnerWrapper) {
            loadingSpinnerWrapper.style.display = 'flex';
            setTimeout(function() {
                loadingSpinnerWrapper.style.display = 'none'; // Sembunyikan spinner setelah 2 detik
            }, 1000); // 2000ms = 2 detik
        } else {
            console.log("Elemen spinner tidak ditemukan!");
        }
    });

    //    script for modal

    document.addEventListener("DOMContentLoaded", function() {
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("deleteFoto");
        var span = document.getElementById("closeModalBtn");

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    });




    // scricpt for open modal id card

    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('openIdCardBtn');
        const modal = document.getElementById('showIdCard');
        const closeBtn = modal.querySelector('.close-modal');

        // Buka modal saat tombol diklik
        openBtn.addEventListener('click', function(e) {
            modal.style.display = 'block'; // pastikan pakai flex (sesuai CSS)
        });

        // Tutup modal saat klik tombol "×"
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
        });

        // Tutup modal saat klik area luar konten modal
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
</script>
