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
        <h3>Data Cabang PT Sahabat Group Auto</h3>
        <hr>
        <p>Tanggal Cetak : {{ date('d-m-Y h:i a') }}</p>
        <!-- Info tambahan bisa ditambahkan kembali jika dibutuhkan -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Lokasi</th>
                        <th>Nama Cabang</th>
                        <th>Alamat</th>
                        <th>Kepala Cabang</th>
                        <th>Total Karyawan</th>
                        <th>Data Unit Cabang</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($branch as $cab)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $cab->location_code }}</td>
                            <td>{{ $cab->location_name }}</td>
                            <td>{{ $cab->address }}</td>
                            <td>{{ $cab->branch_head }}</td>
                            <td class="text-center">{{ $cab->employee_total }}</td>
                            <td style="width: 400px;">
                                <table class="nested-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;">Total</th>
                                            <th style="width: 20%;">Ready</th>
                                            <th style="width: 20%;">Sold</th>
                                            <th style="width: 20%;">Kredit</th>
                                            <th style="width: 20%;">Perbaikan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $cab->vehicle_total }}</td>
                                            <td>{{ $cab->vehicle_ready }}</td>
                                            <td>{{ $cab->vehicle_sold }}</td>
                                            <td>{{ $cab->vehicle_application_credit }}</td>
                                            <td>{{ $cab->vehicle_in_repair }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td>{{ $cab->created_at }}</td>
                            <td>{{ $cab->created_by }}</td>
                            <td>{{ $cab->updated_at }}</td>
                            <td>{{ $cab->updated_by }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
<style>
    body {
        font-family: Arial, sans-serif;
        color: black;
        font-size: 13px;
    }

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        vertical-align: top;
    }

    table {
        width: 100%;
        table-layout: fixed;
        word-wrap: break-word;
    }

    .nested-table th,
    .nested-table td {
        font-size: 12px;
        padding: 3px;
        text-align: center;
    }

    @media print {
        body {
            margin: 0;
        }

        .container-title,
        .card-body {
            page-break-inside: avoid;
        }

        @page {
            size: A4 landscape;
            margin: 1cm;
        }
    }
</style>

</html>
