<?php

namespace App\Http\Controllers\Api\LandingPage;

use App\Http\Controllers\Api\MasterAppointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleCustomerRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\AppointmentModel;
use App\Models\MasterVehicleAdvertisementModel;
use App\Mail\RequestVehicleMail;
use App\Mail\SendEmailAppointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $vehicle_ads = DB::table('v_vehicle_advertisement')->where('is_active', 'Ya')->limit(10)->get();
        $brand      = DB::table('vehicle_brand')->get();
        $branch = DB::table('v_branch')->get();
        $token  = $request->unique_tokens;
        $vehicle_request = DB::table('customer_vehicle_request')
            ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'description', 'updated_at')
            ->leftJoin('vehicle_brand as vb', 'customer_vehicle_request.brand', '=', 'vb.id')->where('unique_tokens', $token)->get();
        return view('layouts.landing_page.main_page.home_page', compact('vehicle_ads', 'brand', 'branch', 'vehicle_request'));
    }


    public function all_vehicles(Request $request): View
    {

        $lowerprice = $request->lower_price;
        $highprice = $request->high_price;
        $brand = DB::table('vehicle_brand')->where('brand_name', '<>', 'Maserati')->get();
        $vehicle_ads = DB::table('v_vehicle_advertisement')->where('is_active', 'Ya')->paginate(10);
        return view('layouts.landing_page.main_page.all_vehicle', compact('vehicle_ads', 'brand', 'lowerprice', 'highprice'));
    }

    public function filterbyvehiclebrand(Request $request): View
    {
        // Ambil brand yang dipilih dari request
        $brand = $request->input('brand_name');
        $brands = DB::table('vehicle_brand')->get();
        $lowerprice = $request->lower_price;
        $highprice = $request->high_price;
        if (!empty($brand)) {
            $vehicle_ads = DB::table('v_vehicle_advertisement')
                ->where('brand_name', $request->brand_name)->where('is_active', 'Ya')
                ->paginate(10);
        } else {
            // Jika tidak ada brand yang dipilih, tampilkan semua data
            $vehicle_ads = DB::table('v_vehicle_advertisement')->where('is_active', 'Ya')->get();
        }

        return view('layouts.landing_page.main_page.all_vehicle', compact('vehicle_ads', 'brand', 'brands', 'lowerprice', 'highprice'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function vehicle_detail(Request $request): View
    {
        $vehicle_data = DB::table('v_vehicle_advertisement')->where('slug', $request->slug)->get();
        $credit_simulation = DB::table('v_credit_simulation')->where('slug', $request->slug)->get();

        $vehicle_fotos = DB::table('vehicle_fotos as vf')
            ->select('vf.images', DB::raw("LOWER(CONCAT(REPLACE(vb.brand_name, ' ', '-'), '-', v.vehicle_type, '-', v.manufacture_year)) as slug"))
            ->leftJoin('vehicle as v', 'vf.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')
            ->whereRaw(
                "LOWER(CONCAT(REPLACE(vb.brand_name, ' ', '-'), '-', v.vehicle_type, '-', v.manufacture_year)) = ?",
                [$request->slug]  // Menggunakan nilai slug yang diterima dari request
            )
            ->get();
        $media_video = DB::table('v_vehicle_media_player')->where('media_type', 'video')->where('slug', $request->slug)->get();
        $engine_sound = DB::table('v_vehicle_media_player')->where('media_type', 'engine sound')->where('slug', $request->slug)->get();

        $contact = DB::table('employee as e')
            ->select('e.name', DB::raw("REPLACE(e.phone_number, ' ', '') AS phone_number"), 'location_name')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('vehicle as v', 'b.id', '=', 'v.location_branch_vehicle')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')
            ->whereRaw(
                "LOWER(CONCAT(REPLACE(vb.brand_name, ' ', '-'), '-', v.vehicle_type, '-', v.manufacture_year)) = ?",
                [$request->slug]  // Menggunakan nilai slug yang diterima dari request
            )->get();

        return view('layouts.landing_page.main_page.vehicle_detail', compact('vehicle_data', 'vehicle_fotos', 'credit_simulation', 'contact', 'media_video', 'engine_sound'));
    }


    public function clicked_ads(Request $request, $id)
    {

        $ads = DB::table('v_vehicle_advertisement')->where('slug', $request->slug)->first();
        $ads_id = $request->ads_id;
        if ($ads) {

            MasterVehicleAdvertisementModel::where('id', $ads->ads_id)->update([
                'clicked' => $request->clicked += 1
            ]);

            return redirect()->route('vehicle_detail', ['slug' => $ads->slug]);
        }
    }

    public function check_status_request(Request $request)
    {
        // $vehicle_ads = DB::table('v_vehicle_advertisement')->where('is_active', 'Ya')->limit(10)->get();
        // $brand      = DB::table('vehicle_brand')->get();
        // $branch = DB::table('v_branch')->get();
        $request->validate([
            'unique_tokens' => 'required'
        ]);

        $token  = $request->unique_tokens;
        $vehicle_request = DB::table('customer_vehicle_request')
            ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'description', 'updated_at')
            ->leftJoin('vehicle_brand as vb', 'customer_vehicle_request.brand', '=', 'vb.id')->where('unique_tokens', $token)->get();

        if ($token) {
            return response()->json([
                'status' => 'success',
                'message' => 'data berhasil',
                'data' => $vehicle_request
            ]);
        }
    }



    public function appointment_layout(Request $request): View
    {
        $selectlocation = $request->location_unit;
        $vehicle_new = DB::table('v_vehicle_advertisement')
            ->where('category_name', '<>', 'Unit Booked')
            ->get();
        $location = DB::table('branch')->get();
        $schedule_times = DB::table('schedule_times')->get();
        $vehicle_data = DB::table('v_vehicle_advertisement')->where('category_name', '<>', 'Unit Booked')->get();
        $vehicle_ads = DB::table('v_appointment')->where('category_name', '<>', 'Unit Booked')->get();
        // $vehicle_appointment = DB::table('v_appointment')->whereDate('created_at', '=', now()->toDateString())->get();
        return view('layouts.landing_page.main_page.appointment', compact('location', 'schedule_times', 'vehicle_new', 'vehicle_ads', 'vehicle_data', 'selectlocation'));
    }


    public function saveAppointment(Request $request)
    {
        // date_default_timezone_set('Asia/Jakarta');
        // $insertTime = (int) date('H');

        $ads_id = $request->ads_id;
        $schedule_time = $request->schedule_time;
        $date = $request->date;

        $checking_data = DB::table('appointment')
            ->select('ads_id', 'date', 'schedule_time')
            ->where('ads_id', $ads_id)->where('schedule_time', $schedule_time)->whereDate('date', now()->toDateString())->exists();

        if ($checking_data) {
            session()->flash('failed_insert', 'Appointment gagal, data appointment sudah tersedia');
            return redirect()->back();
        }



        $request->validate([
            'ads_id' => 'required',
            'schedule_time' => 'required',
            'date' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required'

        ]);

        $appointment =  AppointmentModel::create([
            'ads_id' => $ads_id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'date' => $date,
            'schedule_time' => $schedule_time,
            'created_at'  => now()
        ]);



        if ($appointment) {
            $this->sendEmailAppointment($appointment);
            session()->flash('message_success', 'Appointment anda berhasil dibuat!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Appointment gagal, mohon lengkapi data dahulu');
            return redirect()->back();
        }
    }

    public function sendEmailAppointment(AppointmentModel $appointment)
    {
        try {
            Mail::to($appointment->email)->send(new SendEmailAppointment($appointment));

            return response()->json(['message' => 'Email sent successfully!'], 200);
        } catch (\Exception $e) {

            \Log::error('Email sending failed: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to send email. Please try again later.'], 500);
        }
    }



    public function vehicle_price_range(Request $request): View
    {

        $lowerprice = $request->lower_price;
        $highprice = $request->high_price;

        if ($lowerprice && $highprice) {
            $vehicle_ads =  DB::table('v_vehicle_advertisement')->whereBetween('price', [$lowerprice, $highprice])->where('is_active', 'Ya')->get();
        } else {
            $vehicle_ads =  DB::table('v_vehicle_advertisement')->where('is_active', 'Ya')->get();
        }

        $brand = DB::table('vehicle_brand')->where('brand_name', '<>', 'Maserati')->get();
        return view('layouts.landing_page.main_page.all_vehicle', compact('vehicle_ads', 'brand', 'lowerprice', 'highprice'));
    }

    public function filter_branch_vehicle(Request $request)
    {

        $vehicle_ads = DB::table('v_appointment')->get();
        $vehicle_data = DB::table('v_vehicle_advertisement')->where('category_name', '<>', 'Unit Booked')->get();
        $selectlocation = $request->location_unit;
        if ($selectlocation) {
            $vehicle_ads = DB::table('v_appointment')
                ->where('location_unit', $selectlocation) // filter berdasarkan location_unit
                ->where('category_name', '<>', 'Unit Booked') // filter berdasarkan category_name
                ->whereDate('date', now()->toDateString())
                ->get();

            $vehicle_new = DB::table('v_vehicle_advertisement')
                ->where('category_name', '<>', 'Unit Booked')
                ->where('location_unit', $selectlocation)->get();
        }

        $location = DB::table('branch')->get();
        $schedule_times = DB::table('schedule_times')->get();
        return view('layouts.landing_page.main_page.appointment', compact('location', 'schedule_times', 'vehicle_ads', 'vehicle_new', 'vehicle_data', 'selectlocation'));
        return redirect()->route('vehicle_appointment') . '#filterBranch';
    }


    public function get_location(Request $request, $vehicle_id)
    {
        $locationData = DB::table('v_vehicle_advertisement')->where('vehicle_id', $vehicle_id)->first();
        return response()->json(['branch_id' => $locationData->branch_id]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    public function vehicle_customer_request(Request $request)
    {
        $uuid = Str::uuid();
        $unique_tokens = 'req-vhcl' . date('dmY') . '-' . $uuid->toString();
        $request->validate([
            'vehicle_type' => 'required',
            'brand'        =>  'required',
            'year'      =>  'required',
            'vehicle_color' => 'required',
            'name'      => 'required',
            'email' =>  'required',
            'phone_number' =>  'required'
        ]);

        $customer_request = VehicleCustomerRequest::create([
            'vehicle_type' => $request->vehicle_type,
            'brand'        =>  $request->brand,
            'year'      =>  $request->year,
            'vehicle_color' => $request->vehicle_color,
            'name'      => $request->name,
            'email' =>  $request->email,
            'phone_number' =>  $request->phone_number,
            'unique_tokens' => $unique_tokens,
            'created_at' => now(),
            'updated_at'  => now()
        ]);

        if ($customer_request) {
            $this->sendEmailVehicleRequest($customer_request);
            session()->flash('message_success', 'Permintaan anda berhasil dikirim!');
            return redirect()->route('sahabatmotor');
        }
    }


    public function sendEmailVehicleRequest(VehicleCustomerRequest $customer_request)
    {
        try {
            Mail::to($customer_request->email)->send(new RequestVehicleMail($customer_request));
            return response()->json(['message' => 'Email berhasil dikirim'], 200);
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed send email'], 500);
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
