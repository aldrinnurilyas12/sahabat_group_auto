<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResponseRequestVehicleMail;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleCustomerRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\AppointmentModel;
use App\Exports\AppointmentExport;
use App\Exports\CustomersRequestExport;
use Maatwebsite\Excel\Facades\Excel;

class MasterAppointment extends Controller
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

        if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
        } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
        } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
        } else {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
        }
        return view('layouts.admin_views.appointment.appointment', compact('appointment_data', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function filter_appointment(Request $request)
    {
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
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();

            if ($bulan) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }
            if ($tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }

            if ($bulan && $tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }

            if ($bulan === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }

            if ($tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PLAZA AUTO')->get();
            }

            return view('layouts.admin_views.appointment.appointment', compact('appointment_data', 'grouped_sub_menu', 'sidebar_menu', 'years', 'months', 'bulan', 'tahun'));
        } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();

            if ($bulan) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }
            if ($tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }

            if ($bulan && $tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }

            if ($tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'PERMATA ABADI MOTOR')->get();
            }
        } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            if ($bulan) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }
            if ($tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }

            if ($bulan && $tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }

            if ($tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'KURNIA ABADI MOTOR')->get();
            }
        } else {
            $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            if ($bulan) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }
            if ($tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }

            if ($bulan && $tahun) {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('YEAR(created_at) = ?', [$tahun])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }

            if ($tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->whereRaw('MONTH(created_at) = ?', [$bulan])
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $appointment_data = DB::table('v_appointment')
                    ->where('id', '!=', '')
                    ->orderBy('created_at', 'DESC')->where('location_unit', '=', 'MEGA ABADI MOTOR')->get();
            }
        }
        return view('layouts.admin_views.appointment.appointment', compact('appointment_data', 'grouped_sub_menu', 'sidebar_menu', 'years', 'months', 'bulan', 'tahun'));
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
    public function sendMailVehicleRequest(Request $request, $id)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $vehicle_data = DB::table('customer_vehicle_request as vr')
            ->select('vr.id', 'vr.name', 'vr.email', 'vr.phone_number', 'vr.vehicle_type', 'vehicle_brand.brand_name', 'vr.year', 'vr.vehicle_color', 'vr.sending_mail', 'vr.description')
            ->leftJoin('vehicle_brand', 'vr.brand', '=', 'vehicle_brand.id')->where('vr.id', $request->id)->get();

        return view('layouts.admin_views.customer_vehicle_request.send_mail_customer_request', compact('vehicle_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function appointment_export(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $fileName = 'Appointment_data_' . $bulan .  '-' . $tahun . '.xlsx';
        return Excel::download(new AppointmentExport($bulan, $tahun), $fileName);
    }

    public function change_appointment(Request $request)
    {

        $change_status = AppointmentModel::where('id', $request->id)->update([
            'appointment_status' => $request->appointment_status
        ]);

        if ($change_status) {
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('customers_appointment.index');
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


    // ======================= SECTION CUSTOMER REQUEST PAGE =======================================

    public function customer_vehicle_request(Request $request): View
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

        $request_vehicle_data = DB::table('customer_vehicle_request as cr')
            ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
            ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->get();
        return view('layouts.admin_views.customer_vehicle_request.customers_request_vehicle', compact('request_vehicle_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    public function filter_request(Request $request)
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

        $request_vehicle_data = DB::table('customer_vehicle_request as cr')
            ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
            ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->get();

        if ($bulan) {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->whereRaw('MONTH(created_at) = ? ', [$bulan])->get();
        }
        if ($tahun) {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->whereRaw('YEAR(created_at) = ? ', [$tahun])->get();
        }

        if ($bulan && $tahun) {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->whereRaw('MONTH(created_at) = ? ', [$bulan])->whereRaw('YEAR(created_at) = ? ', [$tahun])->get();
        }

        if ($bulan === 'alldata') {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->whereRaw('YEAR(created_at) = ? ', [$tahun])->get();
        }

        if ($tahun === 'alldata') {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->whereRaw('MONTH(created_at) = ? ', [$bulan])->get();
        }

        if ($bulan === 'alldata' && $tahun === 'alldata') {
            $request_vehicle_data = DB::table('customer_vehicle_request as cr')
                ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
                ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')->get();
        }


        return view('layouts.admin_views.customer_vehicle_request.customers_request_vehicle', compact('request_vehicle_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    public function vehicle_req_export(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $fileName = 'Data_permintaan_unit' . '-' . $bulan . '-' . $tahun . '-' . '.xlsx';

        return Excel::download(new CustomersRequestExport($bulan, $tahun), $fileName);
    }

    public function response_customers_request(Request $response_request)
    {
        DB::table('customer_vehicle_request')->where('id', $response_request->id)->update([
            'id' => $response_request->id,
            'email' => $response_request->email,
            'sending_mail' => $response_request->sending_mail,
            'description' => $response_request->description,
            'updated_at' => now()
        ]);

        $updated_request = VehicleCustomerRequest::find($response_request->id);

        if ($updated_request) {
            $this->sendResponseCustomersRequest($updated_request);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect('customer_vehicle_request');
        }
    }

    public function sendResponseCustomersRequest(VehicleCustomerRequest $response_request)
    {
        try {
            Mail::to($response_request->email)->send(new ResponseRequestVehicleMail($response_request));
            return response()->json(['message' => 'email successs'], 200);
        } catch (\Exception $e) {
            \Log::error('Email Sending Failed : ' . $e->getMessage());
            return response()->json(['error' => 'Failed_send_email'], 500);
        }
    }
}
