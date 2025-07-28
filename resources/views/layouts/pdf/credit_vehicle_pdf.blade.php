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
        <h3>Data Kredit Unit &nbsp; {{ $credit_simulation->first()->unit }} &nbsp; PT Sahabat Group Auto</h3>
        <hr>
        <p>Unit : {{ $credit_simulation->first()->unit }}</p>
        <p>Tanggal Cetak : {{ date('d-m-Y h:i a') }}</p>
        <!-- Info tambahan bisa ditambahkan kembali jika dibutuhkan -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20px; text-align: center;">No</th>
                        <th>Unit</th>
                        <th>Harga Unit</th>
                        <th>Biaya DP Unit</th>
                        <th>Total Harga DP</th>
                        <th>Asuransi</th>
                        <th>Tenor 12 Bulan</th>
                        <th>Tenor 24 Bulan</th>
                        <th>Tenor 36 Bulan</th>
                        <th>Tenor 48 Bulan</th>
                        <th>Tenor 60 Bulan</th>
                        <th>Tenor 72 Bulan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($credit_simulation as $credit)
                        <tr>
                            <td style="width: 20px; text-align: center; white-space: nowrap;">{{ $no++ }}</td>

                            <td>{{ $credit->unit }}</td>
                            <td>{{ 'Rp ' . number_format($credit->credit_price) }}</td>
                            <td>{{ $credit->down_payment . '%' }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->total_down_payment) }}
                            </td>
                            <td>

                                @if ($credit->insurance_name)
                                    {{ $credit->insurance_name }}
                                @else
                                    <span class="text-secondary">Tidak ada
                                        asuransi</span>
                                @endif
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_12_month) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_24_month) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_36_month) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_48_month) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_60_month) }}
                            </td>
                            <td>{{ 'Rp ' . number_format($credit->tenor_72_month) }}
                            </td>

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
