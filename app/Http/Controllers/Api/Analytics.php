<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;

class Analytics extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }


    public function index(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee = DB::table('v_employee')->get();

        $vehicle_brand = DB::table('vehicle_brand as vb')
            ->join('vehicle as v', 'vb.id', '=', 'v.brand')
            ->distinct()
            ->count('v.brand');

        $vehicle_total = DB::table('vehicle')
            ->select('v.id')->count();

        $vehicle_total_clicked = DB::table('vehicle_advertisement as va')
            ->select(DB::raw('concat(vb.brand_name, " ", v.vehicle_type, " ", v.manufacture_year) as unit'), 'va.clicked as total_vehicle_clicked')
            ->leftJoin('vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->where('va.is_active', 'Y')->get();

        $total_clicked = $vehicle_total_clicked->values();

        $vehicle_ads = DB::table('vehicle_advertisement')->where('is_active', 'Y')->count();
        $appointment_total = DB::table('appointment')->count();
        $unit_request = DB::table('customer_vehicle_request')->count();
        $sale_unit_request = DB::table('vehicle_sale_request')->count();

        return view('layouts.admin_views.analytics.analytics', compact('employee', 'grouped_sub_menu', 'sidebar_menu', 'appointment_total', 'unit_request', 'sale_unit_request', 'vehicle_ads', 'vehicle_total_clicked', 'vehicle_total', 'vehicle_brand'));
    }

    public function get_total_vehicle_ads()
    {
        $fetch_data =  DB::table('vehicle_advertisement as va')
            ->select(DB::raw('concat(vb.brand_name, " ", v.vehicle_type, " ", v.manufacture_year) as unit'), 'va.clicked as total_vehicle_clicked')
            ->leftJoin('vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->where('va.is_active', 'Y')->orderBy('va.clicked', 'DESC')->get();

        $unit = $fetch_data->pluck('unit');
        $total_clicked = $fetch_data->pluck('total_vehicle_clicked');

        return response()->json([
            'unit' => $unit,
            'total_vehicle_clicked' => $total_clicked
        ]);
    }

    public function get_brand_total()
    {
        $fetch_data = DB::table('vehicle as v')
            ->select('vb.brand_name as brand_name', \DB::raw('count(vb.brand_name) as brand_total'))
            ->join('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->groupBy('vb.brand_name')->orderBy('brand_total', 'DESC')->get();

        $brand = $fetch_data->pluck('brand_name');
        $brand_total = $fetch_data->pluck('brand_total');

        return response()->json([
            'brand_name' => $brand,
            'brand_total' => $brand_total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
