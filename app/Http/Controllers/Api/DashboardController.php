<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;

class DashboardController extends Controller
{


    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }


    public function index(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'] ?? [];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'] ?? [];

        $employee_total = DB::table('employee')->where('is_active', 'Y')->count();
        $vehicle_total = DB::table('vehicle')->where('status_vehicle_id', '<>', '2')->count();
        $vehicle_ads = DB::table('vehicle_advertisement')->where('is_active', 'Y')->count();
        $users_online = DB::table('users')->whereNotNull('last_seen')->count();



        $it_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';
        $finance_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Finance';
        $marketing_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Marketing';
        $business_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Business Development';
        $human_resource_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Human Resource';

        $plaza_auto = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PLAZA AUTO';
        $permata_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PERMATA ABADI MOTOR';
        $kurnia_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'KURNIA ABADI MOTOR';
        $mega_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'MEGA ABADI MOTOR';

        if ($plaza_auto) {
            if ($it_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Finance', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PLAZA AUTO')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Information Technology', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($finance_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PLAZA AUTO')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Finance', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($marketing_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PLAZA AUTO')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Marketing', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($business_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Marketing', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PLAZA AUTO')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Business Development', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($human_resource_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Marketing'])
                    ->where(function ($query) {
                        $query->where('branch', 'PLAZA AUTO')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Human Resource', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } else {
                echo "Not Have Data";
            }
        } elseif ($permata_abadi_motor) {
            if ($it_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Finance', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PERMATA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Information Technology', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($finance_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PERMATA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Finance', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($marketing_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PERMATA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Marketing', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($business_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Marketing', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'PERMATA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Business Development', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($human_resource_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Marketing'])
                    ->where(function ($query) {
                        $query->where('branch', 'PERMATA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Human Resource', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } else {
                echo "Not Have Data";
            }
        } elseif ($kurnia_abadi_motor) {
            if ($it_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Finance', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'KURNIA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Information Technology', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($finance_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'KURNIA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Finance', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($marketing_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'KURNIA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Marketing', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($business_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Marketing', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'KURNIA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Business Development', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($human_resource_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Marketing'])
                    ->where(function ($query) {
                        $query->where('branch', 'KURNIA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Human Resource', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } else {
                echo "Not Have Data";
            }
        } elseif ($mega_abadi_motor) {
            if ($it_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Finance', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'MEGA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Information Technology', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($finance_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Marketing', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'MEGA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Finance', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($marketing_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'MEGA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Marketing', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($business_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Marketing', 'Human Resource'])
                    ->where(function ($query) {
                        $query->where('branch', 'MEGA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Business Development', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } elseif ($human_resource_department) {
                $agenda = DB::table('agenda')->whereNotIn('department', ['Information Technology', 'Finance', 'Business Development', 'Marketing'])
                    ->where(function ($query) {
                        $query->where('branch', 'MEGA ABADI MOTOR')->orWhere('branch', 'Semua Kantor')
                            ->whereIn('department', ['Human Resource', 'Semua Department']);
                    })
                    ->whereDate('agenda_date', '=', now()->toDateString())
                    ->get();
            } else {
                echo "Not Have Data";
            }
        }


        // Kirim data ke view
        return view('layouts.admin_views.dashboard', compact('grouped_sub_menu', 'sidebar_menu', 'employee_total', 'vehicle_total', 'vehicle_ads', 'users_online', 'agenda'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function settings_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'] ?? [];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'] ?? [];

        return view('layouts.admin_views.settings', compact('grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
