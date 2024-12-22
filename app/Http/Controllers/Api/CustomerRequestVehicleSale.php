<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ResponseRequestVehicleSaleMail;
use App\Models\VehicleCarSaleRequest;
use Illuminate\Support\Facades\Mail;

class CustomerRequestVehicleSale extends Controller
{


    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }


    public function index(Request $request): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $customer_request_sale_data = DB::table('vehicle_sale_request as vsr')
            ->select('vsr.id', 'vehicle_type', 'vb.brand_name', 'vehicle_year', 'current_km', 'vehicle_color', 'name', 'email', 'phone_number', 'status', 'sending_email', 'description', 'vsr.created_at')
            ->leftJoin('vehicle_brand as vb', 'vsr.brand_id', '=', 'vb.id')->get();
        $bulan = $request->bulan;
        $tahun = $request->tahun;
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

        return view('layouts.admin_views.customer_vehicle_sale.customer_vehicle_sale', compact('customer_request_sale_data', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    // function untuk mendapatkan method activity
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


    public function sendMailVehicleSaleRequest(Request $request, $id)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $customer_request_sale_data = DB::table('vehicle_sale_request as vsr')
            ->select('vsr.id', 'vehicle_type', 'vb.brand_name', 'vehicle_year', 'current_km', 'vehicle_color', 'name', 'email', 'phone_number', 'status', 'sending_email', 'description', 'vsr.created_at')
            ->leftJoin('vehicle_brand as vb', 'vsr.brand_id', '=', 'vb.id')->where('vsr.id', $request->id)->get();

        return view('layouts.admin_views.customer_vehicle_sale.send_mail_customer_request_sale', compact('customer_request_sale_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function response_customers_request(Request $request_data)
    {
        DB::table('vehicle_sale_request')->where('id', $request_data->id)->update([
            'id' => $request_data->id,
            'email' => $request_data->email,
            'sending_email' => $request_data->sending_email,
            'status' => $request_data->status,
            'description' => $request_data->description,
            'updated_at' => now()
        ]);

        $updated_request = VehicleCarSaleRequest::find($request_data->id);

        if ($updated_request) {
            $this->sendResponseCustomersSaleRequest($updated_request);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect('master_vehicle_sale');
        }
    }

    public function sendResponseCustomersSaleRequest(VehicleCarSaleRequest $request_data)
    {
        try {
            Mail::to($request_data->email)->send(new ResponseRequestVehicleSaleMail($request_data));
            return response()->json(['message' => 'email successs'], 200);
        } catch (\Exception $e) {
            \Log::error('Email Sending Failed : ' . $e->getMessage());
            return response()->json(['error' => 'Failed_send_email'], 500);
        }
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
