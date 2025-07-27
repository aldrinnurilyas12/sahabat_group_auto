<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Permintaan Jual Unit Pelanggan</title>
</head>

<body>

    <div class="container-title">
        <h3>Data Permintaaan Jual Unit Kendaraan Pencarian Unit</h3>
        <hr>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan :
                {{ \Carbon\Carbon::parse($customer_request_sale_data->first()->created_at)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($customer_request_sale_data->first()->created_at)->translatedFormat('Y') }}</span>
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
                        <th>Nama</th>
                        <th>No.Telepon</th>
                        <th>Email</th>
                        <th>Tipe Mobil</th>
                        <th>Merk</th>
                        <th>Tahun Kendaraan</th>
                        <th>Warna</th>
                        <th>Kilometer saat ini</th>
                        <th>Status Email</th>
                        <th>Status</th>
                        <th>Deskripsi Email</th>
                        <th>Tanggal Permintaan</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($customer_request_sale_data as $customer_request)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td>{{ $customer_request->name }}</td>
                            <td><a
                                    href="https://wa.me/{{ $customer_request->phone_number }}">{{ $customer_request->phone_number }}</a>
                            </td>
                            <td>{{ $customer_request->email }}</td>
                            <td>{{ $customer_request->vehicle_type }}</td>
                            <td>{{ $customer_request->brand_name }}</td>
                            <td>{{ $customer_request->vehicle_year }}</td>
                            <td>{{ $customer_request->vehicle_color }}</td>
                            <td>{{ $customer_request->current_km }}</td>
                            <td style="font-size: 16px;">

                                @if ($customer_request->sending_email == 'Ya')
                                    <span class="badge badge-success">
                                        sudah</span>
                                @else
                                    <span class="badge badge-secondary">
                                        belum</span>
                                @endif

                            </td>

                            <td style="font-size: 16px;">
                                @if ($customer_request->status == 'pending')
                                    <span class="badge badge-secondary">
                                        pending</span>
                                @elseif ($customer_request->status == 'reviewed')
                                    <span class="badge badge-info">
                                        sedang ditinjau</span>
                                @elseif ($customer_request->status == 'confirmed')
                                    <span class="badge badge-success">
                                        dikonfirmasi</span>
                                @elseif ($customer_request->status == 'canceled')
                                    <span class="badge badge-danger">
                                        ditolak</span>
                                @endif
                            </td>
                            <td>
                                @if ($customer_request->description)
                                    <span>{{ $customer_request->description }}</span>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td>{{ $customer_request->created_at }}</td>
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
