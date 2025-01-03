<?php

namespace App\Http\Controllers\Api;

use App\Exports\MaintenanceExport;
use App\Http\Controllers\Controller;
use App\Models\MaintenanceUnit;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MasterMainMenuController;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class MaintenanceUnitController extends Controller
{



    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $months = DB::table('months')->get();
        $years = [
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028'
        ];

        $bulan = $request->bulan;
        $tahun = $request->tahun;



        $maintenance_data = DB::table('maintenance_unit as mtc')
            ->select('vehicle_id', 'unit')
            ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
            ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->groupBy('vehicle_id', 'unit')
            ->get();
        return view('layouts.admin_views.maintenance_unit.maintenance', compact('maintenance_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function insertLogActivityUsers($log_activity)
    {
        DB::table('log_activity_users')->insert([
            'user_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->id,
            'ip_address' => \Request::ip(),
            'log_activity' => $log_activity,
            'created_at' => now(),
            'created_by'   => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
        ]);
    }

    public function maintenance_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $maintenance_data = DB::table('v_vehicle')
            ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->whereNotIn('category_name', ['Unit Terjual', 'Unit Booked'])
            ->get();

        $mechanic = DB::table('v_employee')
            ->where('job_position', 'Mechanic')
            ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->get();

        $maintenance_category = DB::table('maintenance_category')->get();
        return view('layouts.admin_views.maintenance_unit.create.maintenance_create', compact('maintenance_data', 'mechanic', 'maintenance_category', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
            'vehicle_id' => 'required',
            'maintenance_type' => 'required',
            'maintenance_date'  => 'required',
            'cost' => 'required',
            'mechanic_name' => 'required'

        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 21) {
            if ($request->hasFile('foto')) {
                $images = $request->file('foto');
                $folderPath = 'repair_cashbon/' . $request->vehicle_id;
                $path = $images->storeAs($folderPath, uniqid() . '-' . $images->getClientOriginalExtension(), 'public');
                MaintenanceUnit::create([
                    'vehicle_id' => $request->vehicle_id,
                    'maintenance_type' => $request->maintenance_type,
                    'maintenance_detail' => $request->maintenance_detail,
                    'cost' => $request->cost,
                    'maintenance_date' => $request->maintenance_date,
                    'mechanic_name' => $request->mechanic_name,
                    'foto' => $path,
                    'created_by' =>  auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' =>  auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                DB::table('vehicle')->where('id', $request->vehicle_id)->update([
                    'status_vehicle_id' => 4
                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_maintenance_unit.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_maintenance_unit.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function maintenance_edit_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $maintenance_data = DB::table('v_vehicle')
            ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->whereNotIn('category_name', ['Unit Terjual', 'Unit Booked'])
            ->get();

        $mechanic = DB::table('v_employee')
            ->where('job_position', 'Mechanic')
            ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->get();

        $maintenance_data = DB::table('maintenance_unit as mtc')
            ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
            ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
            ->where('mtc.id', $request->id)->get();

        $maintenance_category = DB::table('maintenance_category')->get();
        return view('layouts.admin_views.maintenance_unit.edit.maintenance_edit', compact('maintenance_data', 'mechanic', 'maintenance_category', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 21) {
            DB::table('maintenance_unit')->where('id', $request->id)->update([
                'maintenance_type' => $request->maintenance_type,
                'maintenance_detail' => $request->maintenance_detail,
                'cost' => $request->cost,
                'maintenance_date' => $request->maintenance_date,
                'mechanic_name' => $request->mechanic_name,
                'foto' => $request->foto,
                'updated_at' => now(),
                'updated_by' =>  auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_maintenance_unit.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_maintenance_unit.index');
        }
    }

    public function filter_maintenance(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $months = DB::table('months')->get();
        $years = [
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028'
        ];

        $bulan = $request->bulan;
        $tahun = $request->tahun;




        // execute just a month for all data
        if ($bulan === 'alldata') {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(mtc.created_at) = ?', [$tahun])->orderBy('created_at', 'desc')
                ->get();
        }

        // execute just a year for all data
        if ($tahun === 'alldata') {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$bulan])->orderBy('created_at', 'desc')
                ->get();
        }

        if ($bulan) {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$bulan])->orderBy('created_at', 'desc')
                ->get();
        }

        if ($tahun) {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(mtc.created_at) = ?', [$tahun])->orderBy('created_at', 'desc')
                ->get();
        }

        if ($bulan && $tahun) {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$bulan])->whereRaw('YEAR(mtc.created_at) = ?', [$tahun])->orderBy('created_at', 'desc')
                ->get();
        }

        if ($tahun === 'alldata' && $bulan === 'alldata') {
            $maintenance_data = DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('layouts.admin_views.maintenance_unit.maintenance', compact('maintenance_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }


    public function download_excel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $fileName = 'Data_Maintenance_Unit' . '-' . $bulan . '-' . $tahun . '.xlsx';
        return Excel::download(new MaintenanceExport($bulan, $tahun), $fileName);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function cashbon_detail_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $maintenance_data = DB::table('maintenance_unit as m')
            ->select('vh.unit', 'm.id', 'm.maintenance_type', 'm.maintenance_detail', 'm.cost', 'maintenance_date', 'm.mechanic_name', 'm.foto')
            ->leftJoin('v_vehicle as vh', 'm.vehicle_id', '=', 'vh.id')
            ->where('m.vehicle_id', $request->vehicle_id)
            ->get();


        return view('layouts.admin_views.maintenance_unit.cashbone_detail', compact('maintenance_data', 'sidebar_menu', 'grouped_sub_menu'));
    }
}
