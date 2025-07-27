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
        <h3>Data E-Ticket PT Sahabat Group Auto</h3>
        <hr>
        <span class="date-center" style="display: flex; gap:20px;">
            <p>Bulan : {{ \Carbon\Carbon::parse($eticket_data->first()->created_at)->translatedFormat('F') }}
                &nbsp; <span>Tahun :
                    {{ \Carbon\Carbon::parse($eticket_data->first()->created_at)->translatedFormat('Y') }}</span>
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
                        <th>Aksi</th>
                        <th>Attachment File</th>
                        <th>Kode E-Ticket</th>
                        <th>Nama</th>
                        <th>Judul</th>
                        <th>Kategori Tiket</th>
                        <th>Permasalahan</th>
                        <th>Status</th>
                        <th>Approval By IT</th>
                        <th>Jadwal</th>
                        <th>Tanggal Selesai</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Updated At</th>
                        <th>Updated By</th>

                    </tr>
                </thead>

                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($eticket_data as $ticket)
                        <tr style="width: 200px;">
                            <td><?php echo $no++; ?></td>
                            <td>
                                <div style="display:block; justify-content:center;gap:8px; " class="action">
                                    @if ($ticket->approval_by_it == 'sudah konfirmasi' && $ticket->status == 'on progress')
                                        <a class="btn btn-primary" href="#" data-toggle="modal"
                                            data-target="#konfirmasiTicketStatus{{ $ticket->eticket_code }}">Ubah
                                            Status</a>
                                    @elseif($ticket->approval_by_it == 'sudah konfirmasi' && $ticket->status == 'done')
                                        <a class="btn btn-secondary" href="#">Selesai</a>
                                    @else
                                        <a class="btn btn-primary" href="#" data-toggle="modal"
                                            data-target="#konfirmasiTicket{{ $ticket->eticket_code }}">Proccess</a>
                                    @endif
                            </td>
                            <td>
                                @if ($ticket->attachment_files)
                                    <span>Ada</span>
                                @else
                                    <p>-</p>
                                @endif

                            </td>
                            <td>{{ $ticket->eticket_code }} </td>
                            <td>{{ $ticket->name }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->eticket_category }}</td>
                            <td>{{ $ticket->main_issue }}</td>
                            <td style="font-size: 16px;">
                                @if ($ticket->status == 'menunggu konfirmasi')
                                    <span class="badge badge-warning">{{ $ticket->status }}</span>
                                @elseif($ticket->status == 'done')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-info">{{ $ticket->status }}</span>
                                @endif
                            </td>
                            <td style="font-size: 16px;">
                                @if ($ticket->approval_by_it == 'menunggu konfirmasi')
                                    <span class="badge badge-warning">{{ $ticket->approval_by_it }}</span>
                                @elseif($ticket->approval_by_it == 'sudah konfirmasi')
                                    <span class="badge badge-success">Sudah Konfirmasi</span>
                                @else
                                    <span class="badge badge-info">{{ $ticket->approval_by_it }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($ticket->scheduled)
                                    {{ date('d F Y', strtotime($ticket->scheduled)) }}
                                @else
                                    <p>-</p>
                                @endif
                            </td>
                            <td>
                                @if ($ticket->task_complete_date)
                                    {{ date('d F Y', strtotime($ticket->task_complete_date)) }}
                                @else
                                    <p>-</p>
                                @endif
                            </td>
                            <td>{{ $ticket->created_at }}</td>
                            <td>{{ $ticket->created_by }}</td>
                            <td>{{ $ticket->updated_at }}</td>
                            <td>{{ $ticket->updated_by }}</td>
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
