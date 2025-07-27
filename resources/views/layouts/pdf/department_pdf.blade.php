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
        <h3>Data Department PT Sahabat Group Auto</h3>
        <hr>
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
                        <th>Kode Department</th>
                        <th>Nama Department</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>

                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($department as $dept)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td>{{ $dept->department_code }}</td>
                            <td>{{ $dept->department_name }}</td>
                            <td>{{ $dept->created_at }}</td>
                            <td>{{ $dept->created_by }}</td>
                            <td>{{ $dept->updated_at }}</td>
                            <td>{{ $dept->updated_by }}</td>
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
