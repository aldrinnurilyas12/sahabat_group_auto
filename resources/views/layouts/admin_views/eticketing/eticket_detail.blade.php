<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit data E-Ticket - SAHABAT GROUP AUTO ADMINISTRATOR</title>

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

                {{-- content --}}


                <div id="content">


                    @foreach ($eticket_data as $ticket)
                        <div class="form-group-content">

                            <form class="form_input">
                                <h4 style="color:black;"><strong>Detail Tiket</strong></h4>
                                <hr>
                                <input hidden type="text" class="form-control" value="{{ $ticket->id }}"
                                    name="id" autocomplete="off" readonly>

                                <div class="form-group">
                                    <label>Nomor E-Tiket</label>
                                    <input type="text" class="form-control" value="{{ $ticket->eticket_code }}"
                                        autocomplete="off" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" value="{{ $ticket->title }}"
                                        autocomplete="off" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Permasalahan</label>
                                    <textarea readonly class="form-control" name="main_issue" id="" cols="30" rows="4">{{ $ticket->main_issue }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Kategori Tiket</label>
                                    <input type="text" class="form-control" value="{{ $ticket->eticket_category }}"
                                        autocomplete="off" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="">Attachment File</label>
                                    @if ($ticket->attachment_files)
                                        <img width="90" height="90"
                                            src="{{ asset('storage/' . $ticket->attachment_files) }}" alt="">
                                        <a class="btn btn-primary" href="#" href="#" data-toggle="modal"
                                            data-target="#showFile{{ $ticket->id }}">Lihat foto</a>
                                    @else
                                        -
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Tanggal Tiket</label>
                                    <input type="text" class="form-control"
                                        value="{{ date('d F Y', strtotime($ticket->created_at)) }}" autocomplete="off"
                                        readonly>
                                </div>

                                <br>
                                <br>
                                <h4 style="color: black;"><strong>Progress Timeline</strong></h4>
                                <hr>

                                <div style="overflow-x:auto;" class="progress-timeline">
                                    <table style="font-size: 14px; color:black;" class="table table-bordered"
                                        id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Progress</th>
                                                <th>Secheduled</th>
                                                <th>Status Approval By IT</th>
                                                <th>Tanggal Selesai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 16px;">
                                                    @if ($ticket->status == 'done')
                                                        <span class="badge badge-success">Selesai</span>
                                                    @elseif($ticket->status == 'menunggu konfirmasi')
                                                        <span class="badge badge-warning">{{ $ticket->status }}</span>
                                                    @else
                                                        <span class="badge badge-info">{{ $ticket->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket->scheduled)
                                                        {{ date('d F Y', strtotime($ticket->scheduled)) }}
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </td>
                                                <td style="font-size: 16px;">
                                                    @if ($ticket->approval_by_it == 'sudah konfirmasi')
                                                        <span class="badge badge-success">Sudah Konfirmasi</span>
                                                    @elseif($ticket->approval_by_it == 'menunggu konfirmasi')
                                                        <span class="badge badge-warning">{{ $ticket->status }}</span>
                                                    @else
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($ticket->task_complete_date)
                                                        {{ date('d F Y', strtotime($ticket->task_complete_date)) }}
                                                    @else
                                                        <p>-</p>
                                                    @endif
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </form>
                    @endforeach
                </div>


            </div>

        </div>
        @include('layouts.admin_views.footer')
    </div>
    <!-- End of Content Wrapper -->
    @yield('content')

    @foreach ($eticket_data as $ticket)
        <div class="modal fade" id="showFile{{ $ticket->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel{{ $ticket->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div style="padding:10px;color:black;" class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel{{ $ticket->id }}">E-Ticket:
                            {{ $ticket->eticket_category }}</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <p>Nomor E-Tiket : {{ $ticket->id }}</p>
                    <img style="width:100%;height:500px;" src="{{ asset('storage/' . $ticket->attachment_files) }}"
                        alt="">
                </div>
            </div>
        </div>
    @endforeach

    </div>
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
