<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Appointment</title>
</head>

<body>

    <div class="container-title">
        <h3>Data Appointment PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $appointment_data->first()->location_unit }}</p>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan : {{ \Carbon\Carbon::parse($appointment_data->first()->created_at)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($appointment_data->first()->created_at)->translatedFormat('Y') }}</span>
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
                        <th>Unit</th>
                        <th>Lokasi Cabang</th>
                        <th>Nama Customer</th>
                        <th>Nomor Telepon</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tanggal Appointment</th>
                        <th>Jam</th>
                        <th>Created at</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($appointment_data as $appointment)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td>{{ $appointment->unit }}</td>
                            <td>{{ $appointment->location_unit }}</td>
                            <td>{{ $appointment->name }}</td>
                            <td>{{ $appointment->phone_number }}</td>
                            <td>{{ $appointment->email }}</td>
                            <td style="font-size:16px;">
                                @if ($appointment->appointment_status == 'hadir')
                                    <span class="badge badge-success">
                                        Hadir</span>
                                @elseif($appointment->appointment_status == 'tidak datang')
                                    <span class="badge badge-danger">
                                        Tidak Datang</span>
                                @elseif($appointment->appointment_status == null)
                                    <span class="badge badge-info">
                                        Belum Hadir</span>
                                @endif
                            </td>
                            <td>{{ date('d F Y', strtotime($appointment->date)) }}</td>
                            <td>{{ date('d F Y a', strtotime($appointment->schedule_time)) }}</td>
                            <td>{{ $appointment->created_at }}</td>
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
