<?php

namespace App\Http\Controllers\Api;

use App\Exports\SpkUnitExport;
use App\Http\Controllers\Controller;
use App\Models\SpkUnitModel;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;
use function Laravel\Prompts\select;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailSpkNotification;
use PhpParser\Node\Expr\FuncCall;

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

    public function index(Request $request): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $sales_manager_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager';

        $spk_data = DB::table('v_spk')->orderBy('created_at', 'DESC')->get();
        $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('created_at', 'DESC')->get();
        $branch = DB::table('v_branch')->select('location_name')->get();
        $branch_request = $request->branch;
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
        return view('layouts.admin_views.spk_unit.spk', compact('all_spk_data', 'spk_data', 'branch', 'branch_request', 'bulan', 'tahun', 'years', 'months', 'grouped_sub_menu', 'sidebar_menu'));
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
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                SpkUnitModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'location_unit' => $request->location_unit,
                    'payment_method' => $request->payment_method,
                    'price' => $request->price,
                    'price_nominal' => $request->price_nominal,
                    'down_payment' => $request->down_payment,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'approval_by_head_branch' => "Belum Konfirmasi",
                    'approval_by_sales_manager' => "Belum Konfirmasi",
                    'spk_status' => "Belum Konfirmasi",
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
        } else {
            SpkUnitModel::create([
                'vehicle_id' => $request->vehicle_id,
                'location_unit' => $request->location_unit,
                'payment_method' => $request->payment_method,
                'price' => $request->price,
                'price_nominal' => $request->price_nominal,
                'down_payment' => $request->down_payment,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'approval_by_head_branch' => "Belum Konfirmasi",
                'approval_by_sales_manager' => "Belum Konfirmasi",
                'spk_status' => "Belum Konfirmasi",
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
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
    public function confirmedSpkUnit(Request $request, $id)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 22) {

                if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations') {
                    DB::table('spk_unit')->where('id', $request->id)->update([
                        'approval_by_head_branch' => "Sudah Konfirmasi",
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager') {
                    DB::table('spk_unit')->where('id', $request->id)->update([
                        'approval_by_sales_manager' => "Sudah Konfirmasi",
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                }

                $checking_status_spk = SpkUnitModel::find($request->id);

                if ($checking_status_spk && $checking_status_spk->spk_status == 'Sudah Konfirmasi') {
                    return $this->SendEmailNotificationSpk($checking_status_spk);
                }

                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('transaksi_spk_unit.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('transaksi_spk_unit.index');
            }
        } else {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations') {
                DB::table('spk_unit')->where('id', $request->id)->update([
                    'approval_by_head_branch' => "Sudah Konfirmasi",
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Sales Manager') {
                DB::table('spk_unit')->where('id', $request->id)->update([
                    'approval_by_sales_manager' => "Sudah Konfirmasi",
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }

            // code for send email notification
            $checking_status_spk = SpkUnitModel::find($request->id);


            if ($checking_status_spk && $checking_status_spk->spk_status == 'Sudah Konfirmasi') {
                return $this->SendEmailNotificationSpk($checking_status_spk);
            }

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('transaksi_spk_unit.index');
        }
    }


    public function SendEmailNotificationSpk(SpkUnitModel $spk)
    {
        // code for send notification to Finance, Branch and marketing, sales manager:
        //  $ALL_EMAIL = DB::table('employee')->select('email')
        // ->whereIn('job_position', ['1', '2', '4', '6', '9', '10'])->get();

        $ALL_EMAIL = DB::table('employee')->select('email')
            ->whereIn('job_position', ['9', '10'])->get();

        if ($ALL_EMAIL->isEmpty()) {
            return response()->json(['error' => 'No Email found'], 404);
        }

        try {
            foreach ($ALL_EMAIL as $stackholder_email) {
                Mail::to($stackholder_email->email)->send(new SendEmailSpkNotification($spk));
            }
            return response()->json(['message' => 'Email success delivered'], 200);
        } catch (\Exception $e) {
            \Log::error('Sending email failed : ' . $e->getMessage());
            // return response()->json(['error' => 'Failed sending email']);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('transaksi_spk_unit.index');
        }
    }


    public function filter_spk_request(Request $request)
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

        $branch = DB::table('v_branch')->select('location_name')->get();

        $branch_request = $request->branch;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
        $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();

        if ($branch_request) {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->where('location_unit', $branch_request)->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->where('location_unit', $branch_request)
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request && $bulan && $tahun) {
            $spk_data = DB::table('v_spk')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])
                ->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();

            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }

        if ($branch_request === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request === 'alldata' && $bulan === 'alldata' && $tahun === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        return view('layouts.admin_views.spk_unit.spk', compact('all_spk_data', 'spk_data', 'branch', 'branch_request', 'bulan', 'tahun', 'years', 'months', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function download_spk_excel(Request $request)
    {

        $branch_request = $request->branch;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
        $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();

        if ($branch_request) {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->where('location_unit', $branch_request)->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->where('location_unit', $branch_request)
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request && $bulan && $tahun) {
            $spk_data = DB::table('v_spk')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])
                ->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();

            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }

        if ($branch_request === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request === 'alldata' && $bulan === 'alldata' && $tahun === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();
        }
        $fileName = 'Data_SPK_Unit_' . $branch_request . '-' . $bulan .  '-' . $tahun . '.xlsx';
        return Excel::download(new SpkUnitExport($branch_request, $bulan, $tahun), $fileName);
    }

    public function download_spk_pdf(Request $request)
    {

        $branch_request = $request->branch;
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
        $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();

        if ($branch_request) {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->where('location_unit', $branch_request)->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->where('location_unit', $branch_request)
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request && $bulan && $tahun) {
            $spk_data = DB::table('v_spk')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])
                ->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();

            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')->where('location_unit', $branch_request)
                ->whereRaw('MONTH(spk_confirmation_date) = ? ', [$bulan])->whereRaw('YEAR(spk_confirmation_date) = ? ', [$tahun])
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }

        if ($branch_request === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        if ($branch_request === 'alldata' && $bulan === 'alldata' && $tahun === 'alldata') {
            $spk_data = DB::table('v_spk')->orderBy('spk_confirmation_date', 'DESC')->get();
            $all_spk_data = DB::table('v_spk')->where('approval_by_head_branch', 'Sudah Konfirmasi')->where('approval_by_sales_manager', 'Sudah Konfirmasi')->orderBy('spk_confirmation_date', 'DESC')->get();
        }


        $fileName = 'Data_SPK_Unit' . $branch_request . '-' . $bulan . '_' . $tahun . '.pdf';
        $pdf = Pdf::loadView('layouts.pdf.spk_pdf', [
            'all_spk_data' => $all_spk_data
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download($fileName);
    }

    public function download_spk($id)
    {

        $spk_data = DB::table('v_spk')->where('id', $id)->get()->toArray();
        $head_branch_signature = DB::table('employee as e')
            ->select('nik', 'name', 'position_name', 'signature')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->join('employee_signature as es', 'e.id', '=', 'es.employee_id')
            ->where('b.location_name', '=', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->where('jp.position_name', 'Head of Branch Operations');

        $sales_manager_signature = DB::table('employee as e')
            ->select('nik', 'name', 'position_name', 'signature')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->join('employee_signature as es', 'e.id', '=', 'es.employee_id')
            ->where('b.location_name', '=', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
            ->where('jp.position_name', 'Sales Manager');

        $pdf = Pdf::loadView('layouts.pdf.spk', [
            'spk_data' => $spk_data,
            'head_branch_signature' => $head_branch_signature,
            'sales_manager_signature' => $sales_manager_signature
        ]);

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
