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
        <h3>Data SPK Unit PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $all_spk_data->first()->location_unit }} </p>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan :
                {{ \Carbon\Carbon::parse($all_spk_data->first()->spk_confirmation_date)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($all_spk_data->first()->spk_confirmation_date)->translatedFormat('Y') }}</span>
            </p>
        </span>
        <p>Tanggal Cetak : {{ date('d-m-Y h:i a') }}</p>
        <!-- Info tambahan bisa ditambahkan kembali jika dibutuhkan -->
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable" width="100%"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>SPK Status</th>
                        <th>Tanggal SPK</th>
                        <th>Unit</th>
                        <th>Lokasi Unit</th>
                        <th>Metode Bayar</th>
                        <th>Harga</th>
                        <th>Terbilang</th>
                        <th>DP</th>
                        <th>Customer</th>
                        <th>Alamat</th>
                        <th>No.Telepon</th>
                        <th>Email</th>
                        <th>Approve by Head Branch</th>
                        <th>Approve by Sales Manager</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1;
                    ?>
                    @foreach ($all_spk_data as $spk)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td style="font-size:16px;">
                                @if ($spk->spk_status == 'Belum Konfirmasi')
                                    <span class="badge badge-info">
                                        Belum Konfirmasi</span>
                                @else
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @endif
                            </td>
                            <td>{{ $spk->spk_confirmation_date }}</td>
                            <td>{{ $spk->unit }}</td>
                            <td>{{ $spk->location_unit }}</td>
                            <td>{{ $spk->payment_method }}</td>
                            <td>{{ 'Rp ' . number_format($spk->price) }}</td>
                            <td>{{ $spk->price_nominal }}</td>
                            <td>{{ $spk->down_payment }}</td>
                            <td>{{ $spk->name }}</td>
                            <td>{{ $spk->address }}</td>
                            <td>{{ $spk->phone_number }}</td>
                            <td>{{ $spk->email }}</td>
                            <td style="font-size: 16px;">
                                @if ($spk->approval_by_head_branch == 'Belum Konfirmasi')
                                    <span class="badge badge-info">
                                        Belum Konfirmasi</span>
                                @elseif($spk->approval_by_head_branch == 'Sudah Konfirmasi')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @else
                                @endif
                            </td>
                            <td style="font-size: 16px;">
                                @if ($spk->approval_by_sales_manager == 'Belum Konfirmasi')
                                    <span class="badge badge-info">
                                        Belum Konfirmasi</span>
                                @elseif($spk->approval_by_sales_manager == 'Sudah Konfirmasi')
                                    <span class="badge badge-success">
                                        Sudah Konfirmasi</span>
                                @else
                                @endif
                            </td>
                            <td>{{ $spk->created_at }}</td>
                            <td>{{ $spk->created_by }}</td>
                            <td>{{ $spk->updated_at }}</td>
                            <td>{{ $spk->updated_by }}</td>
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
