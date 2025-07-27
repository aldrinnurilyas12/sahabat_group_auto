<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\WebVisitor;
use App\Models\TestimonialModel;


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
        $vehicle_total = DB::table('vehicle')->where('status_vehicle_id', '<>', 'Information Technology')->count();
        $vehicle_ads = DB::table('vehicle_advertisement')->where('is_active', 'Y')->count();
        $users_online = DB::table('users')->whereNotNull('last_seen')->count();

        $visitorweb_landingpage = WebVisitor::count();

        $it_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';
        $finance_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Finance';
        $marketing_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Marketing';
        $business_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Business Development';
        $human_resource_department = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Human Resource';

        $plaza_auto = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PLAZA AUTO';
        $permata_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PERMATA ABADI MOTOR';
        $kurnia_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'KURNIA ABADI MOTOR';
        $mega_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'MEGA ABADI MOTOR';


        if ($it_department) {

            $agenda = DB::table('v_agenda')->whereNotIn('department_name', ['Finance', 'Marketing', 'Business Development', 'Human Resource', 'Lainnya'])
                ->where(function ($query) {
                    $query->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)->orWhere('branch', null)
                        ->whereIn('department_name', ['Information Technology', null]);
                })
                ->whereDate('agenda_date', '=', now()->toDateString())
                ->get();
        } elseif ($finance_department) {
            $agenda = DB::table('v_agenda')->whereNotIn('department_name', ['Information Technology', 'Marketing', 'Business Development', 'Human Resource', 'Lainnya'])
                ->where(function ($query) {
                    $query->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)->orWhere('branch', null)
                        ->whereIn('department_name', ['Finance', null]);
                })
                ->whereDate('agenda_date', '=', now()->toDateString())
                ->get();
        } elseif ($marketing_department) {
            $agenda = DB::table('v_agenda')->whereNotIn('department_name', ['Finance', 'Information Technology', 'Business Development', 'Human Resource', 'Lainnya'])
                ->where(function ($query) {
                    $query->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)->orWhere('branch', null)
                        ->whereIn('department_name', ['Marketing', null]);
                })
                ->whereDate('agenda_date', '=', now()->toDateString())
                ->get();
        } elseif ($business_department) {
            $agenda = DB::table('v_agenda')->whereNotIn('department_name', ['Finance', 'Information Technology', 'Marketing', 'Human Resource', 'Lainnya'])
                ->where(function ($query) {
                    $query->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)->orWhere('branch', null)
                        ->whereIn('department_name', ['Business Development', null]);
                })
                ->whereDate('agenda_date', '=', now()->toDateString())
                ->get();
        } elseif ($human_resource_department) {
            $agenda = DB::table('v_agenda')->whereNotIn('department_name', ['Finance', 'Information Technology', 'Marketing', 'Business Development', 'Lainnya'])
                ->where(function ($query) {
                    $query->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)->orWhere('branch', null)
                        ->whereIn('department_name', ['Human Resource', null]);
                })
                ->whereDate('agenda_date', '=', now()->toDateString())
                ->get();
        } else {
            $agenda = DB::table('v_agenda')->get();
        }

        $testimonial_total = TestimonialModel::count();

        // Kirim data ke view
        return view('layouts.admin_views.dashboard', compact('grouped_sub_menu', 'sidebar_menu', 'employee_total', 'vehicle_total', 'vehicle_ads', 'users_online', 'agenda', 'visitorweb_landingpage', 'testimonial_total'));
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
