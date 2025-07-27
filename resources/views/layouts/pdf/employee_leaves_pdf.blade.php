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
        <h3>Data Cuti Karyawan PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $leaves->first()->location_name }}</p>
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
                        <th>Attachment</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Posisi</th>
                        <th>Cabang</th>
                        <th>Department</th>
                        <th>Tanggal Mulai Cuti</th>
                        <th>Tanggal Akhir Cuti</th>
                        <th>Durasi Cuti</th>
                        <th>Alasan Cuti</th>
                        <th>Status Cuti</th>
                        <th>Aproved by Branch Head</th>
                        <th>Approved by HR</th>
                        <th>Created at</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($leaves as $emp)
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                @if ($emp->attachment)
                                    <span>Ada</span>
                                @else
                                    <span class="text-danger">Belum upload</span>
                                @endif
                            </td>
                            <td>{{ $emp->nik }}</td>
                            <td>{{ Str::upper($emp->name) }}</td>
                            <td>{{ $emp->position_name }}</td>
                            <td>{{ $emp->location_name }}</td>
                            <td>{{ $emp->department_name }}</td>
                            <td>{{ old('start_date', $emp->start_date ? \Carbon\Carbon::parse($emp->start_date)->format('d-m-Y') : '') }}
                            </td>
                            <td>{{ old('end_date', $emp->end_date ? \Carbon\Carbon::parse($emp->end_date)->format('d-m-Y') : '') }}
                            </td>
                            <td>{{ $emp->duration_of_leaves . ' Hari' }}</td>
                            <td>{{ $emp->reason }}</td>

                            <td style="font-size:18px;">
                                @if ($emp->status == 'sudah konfirmasi')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @elseif($emp->status == 'belum konfirmasi')
                                    <span class="badge badge-info">
                                        Belum Konfirmasi</span>
                                @else
                                    <span class="badge badge-danger">
                                        Ditolak</span>
                                @endif
                            </td>

                            @if ($emp->approval_by_branch_head == 'confirmed')
                                <td>
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                </td>
                            @elseif($emp->approval_by_branch_head == 'pending')
                                <td><span class="badge badge-info">
                                        Menunggu Konfirmasi</span></td>
                            @else
                                <td><span class="badge badge-danger">
                                        Ditolak</span></td>
                            @endif

                            @if ($emp->approval_by_hr_head == 'confirmed')
                                <td><span class="badge badge-success">
                                        Sudah Konfirmasi</span></td>
                                </td>
                            @elseif($emp->approval_by_hr_head == 'pending')
                                <td><span class="badge badge-info">
                                        Menunggu Konfirmasi</span></td>
                            @else
                                <td><span class="badge badge-danger">
                                        Ditolak</span></td>
                            @endif
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
