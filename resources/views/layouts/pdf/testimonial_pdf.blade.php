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
        <h3>Data Testimonial Customers PT Sahabat Group Auto</h3>
        <hr>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan :
                {{ \Carbon\Carbon::parse($testimonial->first()->created_at)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($testimonial->first()->created_at)->translatedFormat('Y') }}</span>
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
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th>Testimonial</th>
                        <th>Rating</th>
                        <th>Kritik dan Saran</th>
                        <th>Dibuat pada</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($testimonial as $testi)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td>{{ $testi->customer_name }}</td>
                            @if ($testi->email)
                                <td>{{ $testi->email }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $testi->testimonial }}</td>
                            <td>{{ $testi->rating }}</td>
                            @if ($testi->criticsm_and_suggestion)
                                <td>{{ $testi->criticsm_and_suggestion }}</td>
                            @else
                                <td>-</td>
                            @endif
                            <td>{{ $testi->created_at }}</td>
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
