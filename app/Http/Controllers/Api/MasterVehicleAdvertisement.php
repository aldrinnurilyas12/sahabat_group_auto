<?php

namespace App\Http\Controllers\Api;

use App\Exports\AdvertisementExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\MasterVehicleAdvertisementModel;
use App\Http\Controllers\Api\MasterMainMenuController;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterVehicleAdvertisement extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
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



    public function index(Request $request): View
    {
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

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle_data = DB::table('v_vehicle_advertisement')->orderBy('created_at', 'desc')->get();
        return view('layouts.admin_views.vehicle_advertisement.main_page', compact('vehicle_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add_advertisement_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle_data = DB::table('v_vehicle_advertisement')->where('vehicle_id', $request->vehicle_id)->get();
        $vehicle_images = DB::table('vehicle_fotos')->where('vehicle_id', $request->vehicle_id)->get();
        return view('layouts.admin_views.vehicle_advertisement.create.add_ads_layout', compact('vehicle_images', 'vehicle_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $checking_data = DB::table('vehicle_advertisement')->where('vehicle_id', $request->vehicle_id)->exists();

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($checking_data) {
                session()->flash('failed_message', 'Data iklan ini sudah terpasang!');
                return redirect()->route('master_vehicle_advertisement.index');
            } else {
                MasterVehicleAdvertisementModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'foto'      => $request->foto,
                    'is_active' => $request->is_active,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_vehicle_advertisement.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->back();
        }
    }

    public function filter_advertisement(Request $request)
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
            $vehicle_data = DB::table('v_vehicle_advertisement')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
        }

        // execute just a year for all data
        if ($tahun === 'alldata') {
            $vehicle_data = DB::table('v_vehicle_advertisement')->whereRaw('YEAR(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
        }

        if ($bulan) {
            $vehicle_data = DB::table('v_vehicle_advertisement')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
        }

        if ($tahun) {
            $vehicle_data = DB::table('v_vehicle_advertisement')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
        }

        if ($bulan && $tahun) {
            $vehicle_data = DB::table('v_vehicle_advertisement')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
        }

        if ($tahun === 'alldata' && $bulan === 'alldata') {
            $vehicle_data = DB::table('v_vehicle_advertisement')->orderBy('created_at', 'desc')->get();
        }
        return view('layouts.admin_views.vehicle_advertisement.main_page', compact('vehicle_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }


    /**
     * Display the specified resource.
     */
    public function advertisement_export(Request $request)
    {
        $month = $request->bulan;
        $year = $request->tahun;

        $fileName = 'Data_Iklan_Unit' . '-' . $month . '-' . $year . '.xlsx';
        return Excel::download(new AdvertisementExport($month, $year), $fileName);
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

    public function update_advertisement_foto(Request $request)
    {

        DB::table('vehicle_advertisement')->where('vehicle_id', $request->vehicle_id)->update([
            'foto' => $request->foto
        ]);

        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Foto Iklan Berhasil diperbarui!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterVehicleAdvertisementModel $MasterVehicleAdvertisementModel, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $MasterVehicleAdvertisementModel = MasterVehicleAdvertisementModel::where('id', $request->id);
        if ($insertTime >= 7 && $insertTime <= 24) {
            if ($MasterVehicleAdvertisementModel) {
                $MasterVehicleAdvertisementModel->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_vehicle_advertisement.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_vehicle_advertisement.index');
        }
    }
}
