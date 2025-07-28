<?php

namespace App\Http\Controllers\Api;

use App\Exports\CreditDataVehicleExport;
use App\Http\Controllers\Controller;
use App\Models\CreditSimulation;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Svg\Tag\Rect;

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

    public function index(Request $request): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle = DB::table('v_credit_simulation')->select('unit', 'vehicle_id')->distinct()->get();
        $credit_simulation = DB::table('v_credit_simulation')->get();
        $request_unit = $request->unit;

        return view('layouts.admin_views.credit_simulation.index', compact('credit_simulation', 'request_unit', 'vehicle', 'grouped_sub_menu', 'sidebar_menu'));
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

        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
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
        } else {
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
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
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
        } else {
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
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditSimulation $CreditSimulation, $id)
    {
        $CreditSimulation = CreditSimulation::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($CreditSimulation) {
                    $CreditSimulation->delete();
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('delete_success', 'Data Kredit Berhasil dihapus!');
                    return redirect()->back();
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->back();
            }
        } else {
            if ($CreditSimulation) {
                $CreditSimulation->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('delete_success', 'Data Kredit Berhasil dihapus!');
                return redirect()->back();
            }
        }
    }


    public function calculation_credit_simulation(Request $request)
    {
        $request->validate([
            'credit_price' => 'required|numeric|min:0',
            'down_payment' => 'required|numeric|min:0|lte:credit_price',
        ]);


        $price_unit = $request->credit_price;
        $down_payment = $request->down_payment;

        $credit_calculations = $price_unit - $down_payment;

        if (!$request->expectsJson()) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'perhitungan data credit',
            'data'  => [
                'tenor_12_month' => round($credit_calculations / 12),
                'tenor_24_month' => round($credit_calculations / 24),
                'tenor_36_month' => round($credit_calculations / 36),
                'tenor_48_month' => round($credit_calculations / 48),
                'tenor_60_month' => round($credit_calculations / 60),
                'tenor_72_month' => round($credit_calculations / 72),
            ]
        ]);
    }


    public function filter_credit(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle = DB::table('v_credit_simulation')->select('unit', 'vehicle_id')->distinct()->get();
        $credit_simulation = DB::table('v_credit_simulation')->get();

        $request_unit = $request->vehicle_id;
        // dd($request_unit);

        if ($request_unit) {
            $credit_simulation = DB::table('v_credit_simulation')->where('vehicle_id', $request_unit)->get();
        }

        if ($request_unit == 'alldata') {
            $credit_simulation = DB::table('v_credit_simulation')->get();
        }

        if ($credit_simulation->isEmpty()) {
            session()->flash('failed_insert', 'Data Kredit tidak ada!');
            return redirect()->back();
        }

        return view('layouts.admin_views.credit_simulation.index', compact('credit_simulation', 'request_unit', 'vehicle', 'grouped_sub_menu', 'sidebar_menu'));
    }




    public function download_excel(Request $request)
    {

        $vehicle_id = $request->vehicle_id;
        $unit = $request->unit;

        $vehicle_unit = DB::table('v_credit_simulation')->select('unit')->distinct()->where('vehicle_id', $vehicle_id)->pluck('unit')->first();

        $filename = 'Data_Kredit'  . '-' . $vehicle_unit . '.xlsx';

        return Excel::download(new CreditDataVehicleExport($vehicle_id), $filename);
    }

    public function download_pdf(Request $request)
    {

        $vehicle_id = $request->vehicle_id;
        $unit = $request->unit;

        $credit_simulation = DB::table('v_credit_simulation')->where('vehicle_id', $vehicle_id)->get();
        $vehicle_unit = DB::table('v_credit_simulation')->select('unit')->distinct()->where('vehicle_id', $vehicle_id)->pluck('unit')->first();


        $request_unit = $request->vehicle_id;
        // dd($request_unit);

        if ($request_unit) {
            $credit_simulation = DB::table('v_credit_simulation')->where('vehicle_id', $request_unit)->get();
        }

        if ($request_unit == 'alldata') {
            $credit_simulation = DB::table('v_credit_simulation')->get();
        }

        $fileName = 'Data_Kredit' . '-' . $vehicle_unit . '.pdf';
        // Generate PDF
        $pdf = Pdf::loadView('layouts.pdf.credit_vehicle_pdf', [
            'credit_simulation' => $credit_simulation
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }
}