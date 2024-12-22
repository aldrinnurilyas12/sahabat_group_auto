<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendNotificationSaleRequest;
use App\Models\VehicleCarSaleRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


class VehicleSalesRequest extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $brand = DB::table('vehicle_brand')->get();
        $token = $request->unique_tokens;
        $vehicle_sale_request = DB::table('vehicle_sale_request')
            ->select('vehicle_type', 'vb.brand_name', 'vehicle_year', 'current_km', 'vehicle_color', 'status', 'unique_tokens')
            ->leftJoin('vehicle_brand as vb', 'vehicle_sale_request.brand_id', '=', 'vb.id')
            ->where('unique_tokens', $token)->get();

        return view('layouts.landing_page.main_page.vehicle_sale_request', compact('brand', 'vehicle_sale_request'));
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
        $uuid = Str::uuid();
        $unique_tokens = 'request' . date('dmY') . '-' . $uuid->toString();
        $request->validate([
            'vehicle_type' => 'required',
            'brand_id' => 'required',
            'vehicle_year' => 'required',
            'current_km' => 'required',
            'vehicle_color' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required'

        ]);

        $save_request = VehicleCarSaleRequest::create([
            'vehicle_type' => $request->vehicle_type,
            'brand_id' => $request->brand_id,
            'vehicle_year' => $request->vehicle_year,
            'current_km' => $request->current_km,
            'vehicle_color' => $request->vehicle_color,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'unique_tokens' => $unique_tokens
        ]);

        if ($save_request) {
            $this->notificationVehicleRequest($save_request);
            session()->flash('message_success', 'Appointment anda berhasil dibuat!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Appointment gagal, mohon lengkapi data dahulu');
            return redirect()->back();
        }
    }

    public function notificationVehicleRequest(VehicleCarSaleRequest $save_request)
    {
        try {
            Mail::to($save_request->email)->send(new SendNotificationSaleRequest($save_request));
            return response()->json(['message' => 'Email berhasil dikirim'], 200);
        } catch (\Exception $e) {
            \Log::error('Email sending failed : ' .  $e->getMessage());
            return response()->json(['error' => 'failed to send email'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function check_status(Request $request)
    {

        $token = $request->unique_tokens;
        $vehicle_sale_request = DB::table('vehicle_sale_request')
            ->select('vehicle_type', 'vb.brand_name', 'vehicle_year', 'name', 'current_km', 'vehicle_color', 'status', 'unique_tokens', 'description', 'updated_at')
            ->leftJoin('vehicle_brand as vb', 'vehicle_sale_request.brand_id', '=', 'vb.id')
            ->where('unique_tokens', $token)->get();

        if ($token) {
            return response()->json([
                'status' => 'success',
                'message' => 'berhasil get data',
                'data' => $vehicle_sale_request
            ]);
        }
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
