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
        <h3>Data Perbaikan Unit Kendaraan PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $maintenance_data->first()->location_name }}</p>
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
                        <th>Status Unit</th>
                        <th>Total Biaya Perbaikan</th>

                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($maintenance_data as $maintenance)
                        <tr>

                            <td style="width: 60px;"><?php echo $no++; ?></td>
                            <td>{{ $maintenance->unit }}</td>
                            <td style="font-size: 16px;">
                                @if ($maintenance->status_vehicle == 'Unit Ready')
                                    <span class="badge badge-success">Unit Ready</span>
                                @elseif($maintenance->status_vehicle == 'Unit Booked')
                                    <span class="badge badge-info">Unit Not Ready</span>
                                @elseif($maintenance->status_vehicle == 'Unit Terjual')
                                    <span class="badge badge-danger">Unit Terjual</span>
                                @else
                                    <span class="badge badge-warning">Unit Dalam Perbaikan</span>
                                @endif
                            </td>
                            <td>{{ 'Rp' . number_format($maintenance->total_cost) }}</td>
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
