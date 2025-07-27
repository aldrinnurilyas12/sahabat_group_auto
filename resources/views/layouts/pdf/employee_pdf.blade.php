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
        <h3>Data Karyawan PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $employee->first()->location_name }}</p>
        <p>Department : {{ $employee->first()->department_name }}</p>
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
                        <th>Alamat</th>
                        <th>Usia</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Posisi</th>
                        <th>Level Posisi</th>
                        <th>Department</th>
                        <th>Tipe Pekerjaan</th>
                        <th>Kantor</th>
                        <th>Gaji Pokok</th>
                        <th>Tunjangan Transport</th>
                        <th>Tunjangan Kesehatan</th>
                        <th>Tunjangan Lainnya</th>
                        <th>Total Gaji</th>
                        <th>Status Aktif</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Akhir</th>
                        <th>Created at</th>
                        <th>Created by</th>
                        <th>Updated at</th>
                        <th>Updated by</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($employee as $emp)
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>{{ $emp->nik }}</td>
                            <td>{{ Str::upper($emp->name) }}</td>
                            <td>{{ $emp->address }}</td>
                            <td>{{ $emp->age }}</td>
                            <td>{{ $emp->phone_number }}</td>
                            <td>{{ $emp->email }}</td>
                            <td>{{ $emp->job_position }}</td>
                            @if ($emp->level_position_name)
                                <td>{{ $emp->level_position_name }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $emp->department_name }}</td>
                            <td>
                                @if ($emp->type_of_employee == 'permanent')
                                    Karyawan Tetap
                                @elseif($emp->type_of_employee == 'contract')
                                    Karyawan Kontrak
                                @elseif($emp->type_of_employee == 'internship')
                                    Karyawan Magang
                                @elseif($emp->type_of_employee == 'freelance')
                                    Karyawan Freelance
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $emp->location_name }}</td>
                            <td>{{ 'Rp ' . number_format($emp->salary) }}</td>
                            <td>{{ 'Rp ' . number_format($emp->tunjangan_transport) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($emp->tunjangan_kesehatan) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($emp->tunjangan_lainnya) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($emp->salary_total) }}</td>
                            <td>{{ $emp->is_active }}</td>
                            <td>{{ old('start_date', $emp->start_date ? \Carbon\Carbon::parse($emp->start_date)->format('d-m-Y') : '') }}
                            </td>
                            <td>{{ old('end_date', $emp->end_date ? \Carbon\Carbon::parse($emp->end_date)->format('d-m-Y') : '') }}
                            </td>
                            <td>{{ $emp->created_at }}</td>
                            <td>{{ $emp->created_by }}</td>
                            <td>{{ $emp->updated_at }}</td>
                            <td>{{ $emp->updated_by }}</td>

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
