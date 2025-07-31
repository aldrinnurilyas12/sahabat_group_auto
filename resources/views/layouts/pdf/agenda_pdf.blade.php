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
        <h3>Data Agenda/Meeting PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $agenda->first()->branch }}</p>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan : {{ \Carbon\Carbon::parse($agenda->first()->agenda_date)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($agenda->first()->agenda_date)->translatedFormat('Y') }}</span>
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
                        <th>Department</th>
                        <th>Kantor</th>
                        <th>Pemimpin Meeting</th>
                        <th>Agenda</th>
                        <th>Tanggal Agenda</th>
                        <th>Jam Mulai</th>
                        <th>Jam Akhir</th>
                        <th>Status Agenda</th>
                        <th>Alasan</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>

                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($agenda as $agendas)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>

                            @if ($agendas->department_name == null)
                                <td>Semua Department</td>
                            @else
                                <td>{{ $agendas->department_name }}</td>
                            @endif

                            @if ($agendas->branch == null)
                                <td>Semua Kantor</td>
                            @else
                                <td>{{ $agendas->branch }}</td>
                            @endif

                            @if ($agendas->meeting_leader == null)
                                <td>-</td>
                            @else
                                <td>{{ $agendas->name }}</td>
                            @endif
                            <td>{{ $agendas->agenda_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendas->agenda_date)->format('d F Y') }}
                            </td>
                            <td>{{ $agendas->start_time }}</td>
                            <td>{{ $agendas->end_time }}</td>
                            <td>{{ $agendas->status }}</td>
                            <td>
                                @if ($agendas->reasons)
                                    <span>{{ $agendas->reasons }}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>{{ $agendas->created_at }}</td>
                            <td>{{ $agendas->created_by }}</td>
                            <td>{{ $agendas->updated_at }}</td>
                            <td>{{ $agendas->updated_by }}</td>
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
