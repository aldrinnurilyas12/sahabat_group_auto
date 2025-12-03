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
use Barryvdh\DomPDF\Facade\Pdf;

class MasterAppointment extends Controller
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

        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        $disallowedData = DB::table('users_privilege as up')
        ->select('disallowed')
        ->leftJoin('submenu as sb', 'up.submenu_id', '=', 'sb.id')
        ->where('submenu_link', $request->segment(1))
        ->get();

        // Ambil semua employee_id yang tidak diizinkan dalam bentuk array
        $disallowedIds = [];

        foreach ($disallowedData as $row) {
            $ids = array_map('trim', explode(',', $row->disallowed));
            $disallowedIds = array_merge($disallowedIds, $ids);
        }

        // Ambil employee_id user yang sedang login
        $currentEmployeeId = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;

        // Cek apakah user termasuk dalam daftar disallowed
        if (in_array($currentEmployeeId, $disallowedIds)) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
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
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];


        $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();

        if ($bulan) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }
        if ($tahun) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan && $tahun) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($tahun === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan === 'alldata' && $tahun === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
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

        $disallowedData = DB::table('users_privilege as up')
        ->select('disallowed')
        ->leftJoin('submenu as sb', 'up.submenu_id', '=', 'sb.id')
        ->where('submenu_link', $request->segment(1))
        ->get();

        // Ambil semua employee_id yang tidak diizinkan dalam bentuk array
        $disallowedIds = [];

        foreach ($disallowedData as $row) {
            $ids = array_map('trim', explode(',', $row->disallowed));
            $disallowedIds = array_merge($disallowedIds, $ids);
        }

        // Ambil employee_id user yang sedang login
        $currentEmployeeId = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;

        // Cek apakah user termasuk dalam daftar disallowed
        if (in_array($currentEmployeeId, $disallowedIds)) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.customer_vehicle_request.send_mail_customer_request', compact('vehicle_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function appointment_export(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $fileName = 'Appointment_data_' . '-' . $branch . '-' . $bulan .  '-' . $tahun . '.xlsx';
        return Excel::download(new AppointmentExport($bulan, $tahun), $fileName);
    }

    public function change_appointment(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                $change_status = AppointmentModel::where('id', $request->id)->update([
                    'appointment_status' => $request->appointment_status
                ]);

                if ($change_status) {
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil disimpan!');
                    return redirect()->route('customers_appointment.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('customers_appointment.index');
            }
        } else {
            $change_status = AppointmentModel::where('id', $request->id)->update([
                'appointment_status' => $request->appointment_status
            ]);

            if ($change_status) {
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('customers_appointment.index');
            }
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

    public function customer_vehicle_request(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $request_vehicle_data = DB::table('customer_vehicle_request as cr')
            ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
            ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')
            ->orderBy('created_at', 'DESC')->get();

        $disallowedData = DB::table('users_privilege as up')
        ->select('disallowed')
        ->leftJoin('submenu as sb', 'up.submenu_id', '=', 'sb.id')
        ->where('submenu_link', $request->segment(1))
        ->get();

        // Ambil semua employee_id yang tidak diizinkan dalam bentuk array
        $disallowedIds = [];

        foreach ($disallowedData as $row) {
            $ids = array_map('trim', explode(',', $row->disallowed));
            $disallowedIds = array_merge($disallowedIds, $ids);
        }

        // Ambil employee_id user yang sedang login
        $currentEmployeeId = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;

        // Cek apakah user termasuk dalam daftar disallowed
        if (in_array($currentEmployeeId, $disallowedIds)) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.customer_vehicle_request.customers_request_vehicle', compact('request_vehicle_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    public function filter_request(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];


        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

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
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $fileName = 'Data_permintaan_unit' . '-' . $branch . '-' . $bulan . '-' . $tahun . '-' . '.xlsx';

        return Excel::download(new CustomersRequestExport($bulan, $tahun), $fileName);
    }


    public function download_appointment_pdf(Request $request)
    {
        // $offices = $request->office;
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $year = date('Y');
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $appointment_data = DB::table('v_appointment')->where('id', '!=', '')->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();

        if ($bulan) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }
        if ($tahun) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan && $tahun) {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('YEAR(created_at) = ?', [$tahun])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($tahun === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        if ($bulan === 'alldata' && $tahun === 'alldata') {
            $appointment_data = DB::table('v_appointment')
                ->where('id', '!=', '')
                ->orderBy('created_at', 'DESC')->where('location_unit', '=', $branch)->get();
        }

        $fileName = 'Data_Appointment_' . $branch . '-' . $bulan . '_' . $tahun . '.pdf';
        $pdf = Pdf::loadView('layouts.pdf.appointment_pdf', [
            'appointment_data' => $appointment_data
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }


    public function download_request_export_pdf(Request $request)
    {
        // $offices = $request->office;
        $branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $year = date('Y');
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $request_vehicle_data = DB::table('customer_vehicle_request as cr')
            ->select('cr.id', 'cr.vehicle_type', 'cr.name', 'vb.brand_name', 'cr.year', 'cr.vehicle_color', 'cr.email', 'cr.phone_number', 'cr.created_at', 'cr.sending_mail', 'cr.description')
            ->leftJoin('vehicle_brand as vb', 'cr.brand', '=', 'vb.id')
            ->orderBy('created_at', 'DESC')->get();

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


        $fileName = 'Data_Appointment_' . $branch . '-' . $bulan . '_' . $tahun . '.pdf';
        $pdf = Pdf::loadView('layouts.pdf.customer_request_pdf', [
            'request_vehicle_data' => $request_vehicle_data
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }


    // vehicle_request
    public function response_customers_request(Request $response_request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {

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
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect('customer_vehicle_request');
            }
        } else {
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
