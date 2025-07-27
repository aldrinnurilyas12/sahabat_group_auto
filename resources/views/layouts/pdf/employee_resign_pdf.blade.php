<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

    <div class="container-title">
        <h3>Data Resign Karyawan PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $employee_resign->first()->location_name }}</p>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan : {{ \Carbon\Carbon::parse($employee_resign->first()->resign_date)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($employee_resign->first()->resign_date)->translatedFormat('Y') }}</span>
            </p>
        </span>
        <p>Tanggal Cetak : {{ date('d-m-Y h:i a') }}</p>


    </div>

    <hr>

    <div class="card-body">
        <div class="table-responsive">
            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Status Resign</th>
                        <th>Cabang</th>
                        <th>Attachment</th>
                        <th>Posisi</th>
                        <th>Department</th>
                        <th>Alasan Resign</th>
                        <th>Tanggal Resign</th>
                        <th>Approval by Branch</th>
                        <th>Approval by HR</th>
                        <th>Tanggal terakhir kerja</th>
                        <th>Barang perusahaan yang dikembalikan</th>
                        <th>Tanggal dibuat</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($employee_resign as $emp)
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>{{ $emp->nik }}</td>
                            <td>{{ Str::upper($emp->name) }}</td>
                            <td style="font-size: 16px;">
                                @if ($emp->resign_status == 'sudah konfirmasi')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @elseif ($emp->resign_status == 'belum konfirmasi')
                                    <span class="badge badge-info">
                                        Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge badge-danger">
                                        Ditolak</span>
                                @endif

                            </td>
                            <td>{{ $emp->location_name }}</td>
                            <td>
                                @if ($emp->resign_attachment)
                                    <span>Ada</span>
                                @else
                                    <span class="text-danger">Belum upload</span>
                                @endif
                            </td>
                            <td>{{ $emp->position_name }}</td>
                            <td>{{ $emp->department_name }}</td>
                            <td>{{ $emp->resign_reasons }}</td>
                            <td>{{ \Carbon\Carbon::parse($emp->resign_date)->translatedFormat('d F Y') }}
                            </td>

                            <td>
                                @if ($emp->approval_by_branch_head == 'confirmed')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @else
                                    <span class="badge badge-info">
                                        Menunggu Konfirmasi</span>
                                @endif

                            </td>

                            <td>
                                @if ($emp->approval_by_hr_head == 'confirmed')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @else
                                    <span class="badge badge-info">
                                        Menunggu Konfirmasi</span>
                                @endif

                            </td>
                            <td>{{ $emp->last_day_of_work }}</td>
                            <td>{{ $emp->return_company_property }}</td>
                            <td>{{ $emp->created_at }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>


</body>

<style>
    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 3px;
        /* Kecilkan font agar muat */
    }

    table {
        width: 100%;
        table-layout: fixed;
        /* Pastikan kolom tidak terlalu lebar */
        word-wrap: break-word;
    }

    @media print {
        body {
            margin: 0;
        }

        .container-title,
        .card-body {
            page-break-inside: avoid;
        }

        table {
            width: 100%;
        }

        th,
        td {}

        @page {
            size: A4 landscape;
            /* Agar tabel lebar muat */
            margin: 1cm;
        }
    }
</style>

</html>
