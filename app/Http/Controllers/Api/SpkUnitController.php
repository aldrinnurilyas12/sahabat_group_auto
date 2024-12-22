<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SpkUnitModel;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;
use Barryvdh\DomPDF\Facade\Pdf;

class SpkUnitController extends Controller
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

    public function index()
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $sales_manager_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager';

        $plaza_auto = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PLAZA AUTO';
        $permata_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'PERMATA ABADI MOTOR';
        $kurnia_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'KURNIA ABADI MOTOR';
        $mega_abadi_motor = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name == 'MEGA ABADI MOTOR';

        if ($plaza_auto) {
            if ($branch_role || $sales_manager_role) {
                $spk_data = DB::table('v_spk')->where('location_unit', 'PLAZA_AUTO')->orderBy('created_at', 'DESC')->get();
                $all_spk_data = DB::table('v_spk')->where('location_unit', 'PLAZA AUTO')->where('approval_by_head_branch', 'Y')->where('approval_by_sales_manager', 'Y')->orderBy('created_at', 'DESC')->get();
                return view('layouts.admin_views.spk_unit.spk_branch', compact('spk_data', 'all_spk_data', 'grouped_sub_menu', 'sidebar_menu'));
            } else {
                $spk_data = DB::table('v_spk')->where('location_unit', 'PLAZA_AUTO')->orderBy('created_at', 'DESC')->get();
            }
        } elseif ($permata_abadi_motor) {
            if ($branch_role || $sales_manager_role) {
                $spk_data = DB::table('v_spk')->where('location_unit', 'PERMATA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
                $all_spk_data = DB::table('v_spk')->where('location_unit', 'PERMATA ABADI MOTOR')->where('approval_by_head_branch', 'Y')->where('approval_by_sales_manager', 'Y')->orderBy('created_at', 'DESC')->get();
                return view('layouts.admin_views.spk_unit.spk_branch', compact('spk_data', 'all_spk_data', 'grouped_sub_menu', 'sidebar_menu'));
            } else {
                $spk_data = DB::table('v_spk')->where('location_unit', 'PERMATA ABADI ')->orderBy('created_at', 'DESC')->get();
            }
        } elseif ($kurnia_abadi_motor) {
            if ($branch_role || $sales_manager_role) {
                $spk_data = DB::table('v_spk')->where('location_unit', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
                $all_spk_data = DB::table('v_spk')->where('location_unit', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
                return view('layouts.admin_views.spk_unit.spk_branch', compact('spk_data', 'all_spk_data', 'grouped_sub_menu', 'sidebar_menu'));
            } else {
                $spk_data = DB::table('v_spk')->where('location_unit', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
            }
        } else {
            if ($branch_role || $sales_manager_role) {
                $spk_data = DB::table('v_spk')->where('location_unit', 'MEGA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
                $all_spk_data = DB::table('v_spk')->where('location_unit', 'MEGA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
                return view('layouts.admin_views.spk_unit.spk_branch', compact('spk_data', 'all_spk_data', 'grouped_sub_menu', 'sidebar_menu'));
            } else {
                $spk_data = DB::table('v_spk')->where('location_unit', 'MEGA ABADI MOTOR')->orderBy('created_at', 'DESC')->get();
            }
        }
        return view('layouts.admin_views.spk_unit.spk', compact('spk_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function spk_create_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $branch = DB::table('v_branch')->get();
        $vehicle_data = DB::table('v_vehicle as vhcl')
            ->where('vhcl.category_name', '<>', 'Unit Terjual')
            ->get();
        return view('layouts.admin_views.spk_unit.create.spk_create', compact('vehicle_data', 'branch', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function spk_edit_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];


        $spk_data = DB::table('v_spk')->where('id', $request->id)->get();
        $vehicle_data = DB::table('v_vehicle')->where('category_name', '<>', 'Unit Terjual')->get();
        return view('layouts.admin_views.spk_unit.edit.spk_edit', compact('spk_data', 'vehicle_data', 'grouped_sub_menu', 'sidebar_menu'));
    }




    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'vehicle_id' => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {
            SpkUnitModel::create([
                'vehicle_id' => $request->vehicle_id,
                'location_unit' => $request->location_unit,
                'payment_method' => $request->payment_method,
                'price' => $request->price,
                'price_nominal' => $request->price_nominal,
                'down_payment' => $request->down_payment,
                'customer' => $request->customer,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'approval_by_head_branch' => "N",
                'approval_by_sales_manager' => "N",
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('transaksi_spk_unit.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('transaksi_spk_unit.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function getUnit($vehicleId)
    {
        $unit = DB::table('v_vehicle')->find($vehicleId);
        return response()->json([
            'color' => $unit->color,
            'manufacture_year' => $unit->manufacture_year,
            'location_name' => $unit->location_name,
            'price' => $unit->price,
            'credit_price' => $unit->credit_price
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function confirmedSpkUnit(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {

            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations') {
                $updateDataHeadBranch = DB::table('spk_unit')->where('id', $request->id)->update([
                    'approval_by_head_branch' => $request->approval_by_head_branch,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager') {
                $updateDataSalesManager =  DB::table('spk_unit')->where('id', $request->id)->update([
                    'approval_by_sales_manager' => $request->approval_by_sales_manager,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }


            $checking_data_confirmed = DB::table('spk_unit')->first();


            if ($checking_data_confirmed->approval_by_head_branch == 'N' && $checking_data_confirmed->approval_by_sales_manager == 'N') {
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('transaksi_spk_unit.index');
            } elseif ($checking_data_confirmed->approval_by_head_branch == 'N' && $checking_data_confirmed->approval_by_sales_manager == 'Y') {
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('transaksi_spk_unit.index');
            } elseif ($checking_data_confirmed->approval_by_sales_manager == 'N' && $checking_data_confirmed->approval_by_head_branch == 'Y') {
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('transaksi_spk_unit.index');
            } elseif ($checking_data_confirmed->approval_by_head_branch == 'Y' && $checking_data_confirmed->approval_by_head_branch == 'Y') {
                VehicleModel::where('id', $request->vehicle_id)->update([
                    'status_vehicle_id' => 2,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }


            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('transaksi_spk_unit.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('transaksi_spk_unit.index');
        }
    }

    public function download_spk($id)
    {

        $spk_data = DB::table('v_spk')->where('id', $id)->get()->toArray();

        $pdf = Pdf::loadView('layouts.pdf.spk', ['spk_data' => $spk_data]);

        return $pdf->download();
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
