<!-- Topbar -->

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            {{-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                            aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div> --}}
        </li>


        @php
            use Illuminate\Support\Collection;

            $emp_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id;
            $dateNow = date('Y-m-d');

            $newSpk = DB::table('v_spk')
                ->select('id', 'unit', 'spk_confirmation_date as created_at', DB::raw("'spk' as type"))
                ->whereDate('spk_confirmation_date', $dateNow);

            $oldSpk = DB::table('v_spk')
                ->select('id', 'unit', 'spk_confirmation_date as created_at', DB::raw("'spk' as type"))
                ->whereDate('spk_confirmation_date', '<>', $dateNow);

            $agenda_notification = DB::table('agenda as a')
                ->select('a.id', 'a.agenda_name as unit', 'a.created_at', DB::raw("'agenda' as type"))
                ->leftJoin('agenda_guests as ag', 'a.id', '=', 'ag.agenda_id')
                ->where('ag.employee_id', $emp_id);

            // gabung semua query
            $allNotif = $newSpk->unionAll($oldSpk)->unionAll($agenda_notification);

            // bungkus query gabungan dalam collection & urutkan terbaru
            $notifications = DB::query()->fromSub($allNotif, 'notif')->orderBy('created_at', 'DESC')->get();

            $totalNotif = $notifications->count();
        @endphp

        <!-- Nav Item - Alerts -->



        @if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14')
        @else
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <span class="badge badge-danger badge-counter">{{ $totalNotif }}</span>
                </a>
                <div style="height: 500px;overflow:auto;"
                    class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">NOTIFIKASI</h6>

                    @foreach ($notifications as $item)
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-exclamation-triangle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                </div>
                                @if ($item->type == 'spk')
                                    Penjualan SPK unit <span class="font-weight-bold">{{ $item->unit }}</span> telah
                                    berhasil
                                @else
                                    <span class="font-weight-bold">{{ $item->unit }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </li>

        @endif


        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">


                @if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->users_foto)
                    <img src="{{ asset('storage/' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->users_foto) }}"
                        class="img-profile rounded-circle">
                @else
                    <div style="width: 30px; height:30px; background:rgb(152, 135, 214);border-radius:50%;color:rgb(255, 255, 255);display:flex; justify-content:center; align-items:center;"
                        class="cirlce-username">
                        <p class="p-username" style="margin: 0;">
                            {{ app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_name }}</p>
                    </div>
                @endif

            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('profile') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>



                <a class="dropdown-item" href="{{ route('show_payroll') }}">
                    <i class="fas fa-file-invoice-dollar fa-sm fa-fw mr-2 text-gray-400"></i>
                    Payroll
                </a>

                <a class="dropdown-item" href="{{ route('employee_leaves.index') }}">
                    <i class="fas fa-address-book fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cuti
                </a>

                <a class="dropdown-item" href="{{ route('master_eticket.index') }}">
                    <i class="fas fa-ticket-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ticket
                </a>

                @if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology')
                    <a class="dropdown-item" href="{{ route('settings') }}">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                @else
                @endif



                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>

</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- End of Topbar -->

<script src="../assets/js/sb-admin-2.js"></script>
