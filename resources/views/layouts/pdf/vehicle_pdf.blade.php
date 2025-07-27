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
        <h3>Data Kendaraan PT Sahabat Group Auto</h3>
        <hr>
        <p>Cabang : {{ $vehicle->first()->location_unit }}</p>
        <p>Status Kendaraan : {{ $vehicle->first()->status_vehicle }}</p>
        <p>Tanggal Cetak : {{ date('d-m-Y h:i a') }}</p>

    </div>

    <hr>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="dataTable"
                style="font-size: 13px; color: black; width: 100%;">
                <thead class="thead-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Unit</th>
                        <th>No.Pol</th>
                        <th>Status Unit</th>
                        <th>Tipe</th>
                        <th>Merk</th>
                        <th>Tahun</th>
                        <th>Harga</th>
                        <th>Harga Kredit</th>
                        <th>Jenis</th>
                        <th>Model</th>
                        <th>Warna</th>
                        <th>Bahan Bakar</th>
                        <th>Silinder</th>
                        <th>Transmisi</th>
                        <th>Kunci Cadangan</th>
                        <th>Buku Servis</th>
                        <th>No.Rangka</th>
                        <th>No.Mesin</th>
                        <th>No.Coding</th>
                        <th>Warna TNKB</th>
                        <th>Th.Daftar</th>
                        <th>Tgl Pajak</th>
                        <th>No.BPKB</th>
                        <th>Kode Lokasi</th>
                        <th>No.Urut</th>
                        <th>Nama Pemilik</th>
                        <th>Alamat Pemilik</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicle as $no => $cars)
                        <tr>
                            <td class="text-center">{{ $no + 1 }}</td>
                            <td>{{ $cars->brand . ' ' . $cars->vehicle_type . ' ' . $cars->manufacture_year }}</td>
                            <td>{{ $cars->vehicle_registration_number }}</td>
                            <td class="text-center">
                                @php
                                    $statusClass = [
                                        'Unit Terjual' => 'badge-danger',
                                        'Unit Booked' => 'badge-info',
                                        'Unit Ready' => 'badge-success',
                                        'default' => 'badge-warning',
                                    ];
                                    $status = $cars->status_vehicle;
                                    $badgeClass = $statusClass[$status] ?? $statusClass['default'];
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                            </td>
                            <td>{{ $cars->vehicle_type }}</td>
                            <td>{{ $cars->brand }}</td>
                            <td class="text-center">{{ $cars->manufacture_year }}</td>
                            <td class="text-right">{{ 'Rp' . number_format($cars->price) }}</td>
                            <td class="text-right">{{ 'Rp' . number_format($cars->credit_price) }}</td>
                            <td>{{ $cars->vehicle_category }}</td>
                            <td>{{ $cars->model }}</td>
                            <td>{{ $cars->color }}</td>
                            <td>{{ $cars->fuel_type }}</td>
                            <td class="text-center">{{ $cars->cylinder_capacity }} cc</td>
                            <td>{{ $cars->transmission }}</td>
                            <td>
                                @if ($cars->backup_vehicle_key)
                                    {{ $cars->backup_vehicle_key }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($cars->services_book)
                                    {{ $cars->services_book }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $cars->vehicle_identity_number }}</td>
                            <td>{{ $cars->engine_number }}</td>
                            <td>{{ $cars->coding_number }}</td>
                            <td>{{ $cars->licence_plate_color }}</td>
                            <td class="text-center">{{ $cars->registration_year }}</td>
                            <td class="text-center">{{ date('Y-m', strtotime($cars->tax_date)) }}</td>
                            <td>{{ $cars->bpkb_number }}</td>
                            <td>{{ $cars->location_code }}</td>
                            <td>{{ $cars->registration_queue_number }}</td>
                            <td>{{ $cars->name_of_owner }}</td>
                            <td>{{ $cars->address }}</td>
                            <td>{{ \Carbon\Carbon::parse($cars->created_at)->format('Y-m-d H:i') }}</td>
                            <td>{{ $cars->created_by }}</td>
                            <td>{{ \Carbon\Carbon::parse($cars->updated_at)->format('Y-m-d H:i') }}</td>
                            <td>{{ $cars->updated_by }}</td>
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
        font-size: 11px;
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
            font-size: 10px;
        }

        .container-title,
        .card-body {
            page-break-inside: avoid;
        }

        table {
            width: 100%;
            font-size: 10px;
        }

        th,
        td {
            font-size: 10px;
        }

        @page {
            size: A4 landscape;
            /* Agar tabel lebar muat */
            margin: 1cm;
        }
    }
</style>


</html>
