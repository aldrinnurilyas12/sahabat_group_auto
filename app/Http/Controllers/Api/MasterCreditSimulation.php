<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CreditSimulation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class MasterCreditSimulation extends Controller
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

    public function index(): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        // $vehicle = DB::table('v_vehicle')->get();
        $credit_simulation = DB::table('v_credit_simulation')->get();
        return view('layouts.admin_views.credit_simulation.index', compact('credit_simulation', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_credit_simulation_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $insurance = DB::table('insurance')->get();
        $vehicle = DB::table('v_vehicle')->where('id', $request->id)->get();
        $status_category = DB::table('status_category')->get();
        return view('layouts.admin_views.credit_simulation.create.add_credit_simulation', compact('insurance', 'vehicle', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function edit_credit_simulation_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $insurance = DB::table('insurance')->get();
        $credit_simulation = DB::table('v_credit_simulation')->where('id', $request->id)->get();
        $status_category = DB::table('status_category')->get();
        return view('layouts.admin_views.credit_simulation.edit.edit_credit_simulation', compact('insurance', 'credit_simulation', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');


        $request->validate([
            'vehicle_id' => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {

            CreditSimulation::create([
                'vehicle_id' => $request->vehicle_id,
                'normal_price' => $request->normal_price,
                'down_payment' => $request->down_payment,
                'insurance_id' => $request->insurance_id,
                'tenor_12_month' => $request->tenor_12_month,
                'tenor_24_month' => $request->tenor_24_month,
                'tenor_36_month' => $request->tenor_36_month,
                'tenor_48_month' => $request->tenor_48_month,
                'tenor_60_month' => $request->tenor_60_month,
                'tenor_72_month' => $request->tenor_72_month,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('detail_vehicle', $request->vehicle_id);
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->back();
        }
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
    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('credit_simulation')->where('id', $request->id)->update([
                'vehicle_id' => $request->vehicle_id,
                'down_payment' => $request->down_payment,
                'insurance_id' => $request->insurance_id,
                'tenor_12_month' => $request->tenor_12_month,
                'tenor_24_month' => $request->tenor_24_month,
                'tenor_36_month' => $request->tenor_36_month,
                'tenor_48_month' => $request->tenor_48_month,
                'tenor_60_month' => $request->tenor_60_month,
                'tenor_72_month' => $request->tenor_72_month,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('detail_vehicle',  $request->vehicle_id);
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->back();
        }

        return redirect()->route('master_credit_simulation.index')->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditSimulation $CreditSimulation, $id)
    {
        $CreditSimulation = CreditSimulation::find($id);

        if ($CreditSimulation) {
            $CreditSimulation->delete();
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('delete_success', 'Data Berhasil dihapus!');
            return redirect()->route('master_credit_simulation.index');
        }
    }
}
