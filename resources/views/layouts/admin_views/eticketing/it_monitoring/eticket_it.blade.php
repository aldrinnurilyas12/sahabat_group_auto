<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Kantor Cabang - SAHABAT GROUP AUTO ADMINISTRATOR</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/form.css') }}">
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Inter:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.admin_views.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                @include('layouts.admin_views.header')

                <!-- DataTable -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h5 style="color: black;"><strong>Data E-Ticket</strong></h5>
                        <br>
                        <div style="display: flex; flex-wrap:wrap; gap:10px;" class="component">
                            {{-- <a href="{{ route('eticket_create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i>&nbsp;Buat E-Ticket
                             </a> --}}

                            {{-- <a class="btn btn-success" href="{{route('branch_export')}}">
                                <i class="fas fa-file-excel"></i>
                                                &nbsp; Download
                             </a> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table style="font-size: 14px; color:black;" class="table table-bordered" id="dataTable"
                                width="100%" cellspacing="0">
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
                                                <div style="display:block; justify-content:center;gap:8px; "
                                                    class="action">
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
                                                    <a style="color: black;" class="btn btn-warning" href="#"
                                                        data-toggle="modal"
                                                        data-target="#showFile{{ $ticket->eticket_code }}"><i
                                                            class="fa fa-eye" aria-hidden="true"></i> Lihat</a>
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
                                                    <span
                                                        class="badge badge-warning">{{ $ticket->approval_by_it }}</span>
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
                </div>
                {{-- end content --}}
            </div>

            @include('layouts.admin_views.footer')


        </div>
        <!-- End of Content Wrapper -->
        @yield('content')

    </div>

    {{-- modal change status --}}

    @foreach ($eticket_data as $ticket)
        <div class="modal fade" id="konfirmasiTicket{{ $ticket->eticket_code }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $ticket->eticket_code }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $ticket->eticket_code }}">Konfirmasi E-Ticket:
                            {{ $ticket->eticket_category }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form style="padding: 5px;" method="POST"
                        action="{{ route('confirmed_eticket', $ticket->eticket_code) }}">
                        @csrf
                        @method('PUT')
                        <div style="color: black;" class="modal-body">
                            <p style="color: black;">E-Ticket Number : #{{ $ticket->eticket_code }}</p
                                style="color: black;">

                            <div class="form-group">
                                <label for="">Jadwalkan Proses Tiket</label>
                                <input class="form-control" type="date" name="scheduled">
                            </div>

                            <div class="form-group">
                                <input class="form-control" type="text" value="sudah konfirmasi" hidden
                                    name="approval_by_it" readonly>
                            </div>

                            <div class="form-group">
                                <label for="">Status E-Tiket</label>
                                <select class="form-control" name="status" id="">
                                    <option value="">=== Pilih Status ===</option>
                                    <option value="on progress">On Progress</option>
                                    <option value="done">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Modal Konfirmasi tiket selesai --}}
    @foreach ($eticket_data as $ticket)
        <div class="modal fade" id="konfirmasiTicketStatus{{ $ticket->eticket_code }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalLabel{{ $ticket->eticket_code }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $ticket->eticket_code }}">Konfirmasi
                            E-Ticket:
                            {{ $ticket->eticket_category }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <form style="padding: 5px;" method="POST"
                        action="{{ route('confirmed_eticket_done', $ticket->eticket_code) }}">
                        @csrf
                        @method('PUT')
                        <div style="color: black;" class="modal-body">
                            <p style="color: black;">E-Ticket Number : #{{ $ticket->eticket_code }}</p
                                style="color: black;">

                            <div class="form-group">
                                <input class="form-control" type="text" name="status" hidden value="done">
                            </div>

                            <div class="form-group">
                                <label for="">Tanggal Selesai</label>
                                <input class="form-control" type="date" name="task_complete_date">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Konfirmasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- end modal --}}

    {{-- modal show files --}}
    @foreach ($eticket_data as $ticket)
        <div class="modal fade" id="showFile{{ $ticket->eticket_code }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $ticket->eticket_code }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div style="padding:10px;color:black;" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $ticket->eticket_code }}">E-Ticket:
                            {{ $ticket->eticket_category }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <P>Nomor E-Tiket : {{ $ticket->eticket_code }}</P>
                    <img style="width:100%;height:500px;" src="{{ asset('storage/' . $ticket->attachment_files) }}"
                        alt="">
                </div>
            </div>
        </div>
    @endforeach

    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    {{-- spinner --}}
    <div id="loadingSpinnerWrapper">
        <div class="spinner-border" role="status">
        </div>
    </div>

    <style>
        #loadingSpinnerWrapper {
            position: fixed;
            /* Fix posisi spinner */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            /* Spinner disembunyikan saat halaman dimuat */
            justify-content: center;
            /* Horizontal center */
            align-items: center;
            /* Vertical center */
            background-color: rgba(0, 0, 0, 0.517);
            /* Background semi-transparan */
            z-index: 9999;
            /* Pastikan spinner berada di atas konten lainnya */
        }

        .spinner-border {
            color: yellow;
            width: 3rem;
            height: 3rem;
            /* Pastikan tinggi spinner diatur */
        }
    </style>
</body>

<!-- Page level plugins -->
<script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('assets/js/demo/datatables-demo.js') }}"></script>

@if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
            timer: 2000,
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (Session::has('failed_insert'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: "{{ Session::get('failed_insert') }}",
            icon: "error",
            timer: 6000,
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (Session::has('delete_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('delete_success') }}",
            icon: "success",
            timer: 2000,
            confirmButtonText: 'OK'
        });
    </script>
@endif





@if (Session::has('message_success'))
    <script>
        Swal.fire({
            title: 'Berhasil',
            text: "{{ Session::get('message_success') }}",
            icon: 'success',
            timer: 2000,
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (Session::has('failed_insert'))
    <script>
        Swal.fire({
            title: 'Gagal',
            text: "{{ Session::get('failed_insert') }}",
            icon: "error",
            timer: 6000,
            confirmButtonText: 'OK'
        });
    </script>
@endif

<script>
    window.addEventListener('load', function() {
        var loadingSpinnerWrapper = document.getElementById('loadingSpinnerWrapper');

        // Log elemen untuk memastikan spinner ditemukan
        // Cek apakah elemen ditemukan

        if (loadingSpinnerWrapper) {
            // Menampilkan spinner saat halaman dimuat
            loadingSpinnerWrapper.style.display = 'flex';


            // Menyembunyikan spinner setelah 2 detik (2000ms)
            setTimeout(function() {

                loadingSpinnerWrapper.style.display = 'none'; // Sembunyikan spinner setelah 2 detik
            }, 1000); // 2000ms = 2 detik
        } else {
            console.log("Elemen spinner tidak ditemukan!");
        }
    });
</script>


</html>
