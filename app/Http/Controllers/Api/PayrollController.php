<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PayrollApproval;
use App\Models\PayrollModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Helper\Downloader;
use Barryvdh\DomPDF\Facade\Pdf;
use Ramsey\Uuid\Uuid;

use function Laravel\Prompts\select;

class PayrollController extends Controller
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

        $branch_head_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        if ($branch_head_login) {
            $payroll_data = DB::table('v_payroll')
                ->where('emp_branch_id', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {

            $payroll_data = DB::table('v_payroll')->orderBy('created_at', 'desc')->get();
        }

        return view('layouts.admin_views.payroll.payroll', compact('payroll_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * DATE :24/05/25
     * LAKUKAN UPDATE TAMPILKAN TANDA TANGAN HR BY BRANCH EMPLOYEE 
     * 
     */
    public function payroll_detail_layout($id): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $payroll_detail = DB::table('v_payroll')->where('id', $id)->get();
        return view('layouts.admin_views.payroll.create.payroll_create', compact('payroll_detail', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payroll_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('payroll_file')) {
                    $picture = $request->file('payroll_file');
                    $picturePath = $picture->storeAs('payroll_payment_file', uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
                    $sentPayroll = PayrollModel::create([
                        'employee_id' => $request->employee_id,
                        'payroll_code' => Uuid::uuid4()->toString(),
                        'status' => 'Menunggu Konfirmasi',
                        'payroll_file' => $picturePath,
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);

                    if ($sentPayroll) {
                        PayrollApproval::create([
                            'payroll_id' => $sentPayroll->id,
                            'approval_by_head_of_finance' => 'pending',
                            'approval_by_head_of_human_resource' => 'pending',
                            'approval_by_head_of_branch' => 'pending'
                        ]);
                    }
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Payroll Berhasil Disimpan!');
                    return redirect()->route('master_payroll.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_payroll.index');
            }
        } else {
            if ($request->hasFile('payroll_file')) {
                $picture = $request->file('payroll_file');
                $picturePath = $picture->storeAs('payroll_payment_file', uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
                $sentPayroll = PayrollModel::create([
                    'employee_id' => $request->employee_id,
                    'payroll_code' => Uuid::uuid4()->toString(),
                    'status' => 'Menunggu Konfirmasi',
                    'payroll_file' => $picturePath,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);

                if ($sentPayroll) {
                    PayrollApproval::create([
                        'payroll_id' => $sentPayroll->id,
                        'approval_by_head_of_finance' => 'pending',
                        'approval_by_head_of_human_resource' => 'pending',
                        'approval_by_head_of_branch' => 'pending'
                    ]);
                }
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Payroll Berhasil Disimpan!');
                return redirect()->route('master_payroll.index');
            }
        }
    }

    public function payroll_history(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        if (auth()->check() && auth()->user()->nik  !== auth()->user()->nik) {
            abort(403, 'Ooops unauthorized nik');
        }

        $employee = DB::table('v_employee')->where('nik', auth()->user()->nik)->get();
        if ($employee->isEmpty()) {
            abort(403, 'Ooops unauthorized nik');
        }

        $payroll_data = DB::table('v_payroll')->where('nik', auth()->user()->nik)->get();
        return view('layouts.admin_views.payroll.payroll_history', compact('employee', 'payroll_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function download_payroll(Request $request)
    {
        $payroll_data = DB::table('v_payroll')->where('payroll_code', $request->payroll_code)->get();

        $head_of_finance_sign = DB::table('employee_signature as es')
            ->select('es.signature', 'e.name')
            ->join('employee as e', 'es.employee_id', '=', 'e.id')
            ->where('employee_id', '9')->get();

        $head_of_hr_sign = DB::table('employee_signature as es')
            ->select('es.signature', 'e.name')
            ->join('employee as e', 'es.employee_id', '=', 'e.id')
            ->where('employee_id', '11')->get();

        $head_of_branch_sign = DB::table('employee_signature as es')
            ->select('es.signature', 'e.name')
            ->leftjoin('employee as e', 'es.employee_id', '=', 'e.id')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->leftJoin('v_employee_resign as ver', 'b.id', '=', 'ver.branch_head_id')
            ->where('ver.branch_head_id', '=', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id)
            ->where('jp.position_name', 'Head of Branch Operations')->get();


        $pdf = Pdf::loadView('layouts.pdf.payroll', [
            'payroll_data' => $payroll_data,
            'head_of_hr_sign' => $head_of_hr_sign,
            'head_of_finance_sign' => $head_of_finance_sign,
            'head_of_branch_sign' => $head_of_branch_sign
        ]);

        return $pdf->download();
    }


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

    public function confirmed_payroll(Request $request, $payroll_id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        $branch_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {

                if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Finance Operation') {
                    DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                        'payroll_id' => $request->payroll_id,
                        'approval_by_head_of_finance' => $request->approval_by_head_of_finance
                    ]);
                }
                if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Human Resource') {
                    DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                        'payroll_id' => $request->payroll_id,
                        'approval_by_head_of_human_resource' => $request->approval_by_head_of_human_resource
                    ]);
                }
                if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations') {
                    DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                        'payroll_id' => $request->payroll_id,
                        'branch_head_id' => $branch_login,
                        'approval_by_head_of_branch' => $request->approval_by_head_of_branch
                    ]);
                }


                // revised code :
                // $checking_data_confirmed = DB::table('payroll_approval')->first();

                // $finance = $checking_data_confirmed->approval_by_head_of_finance;
                // $hr = $checking_data_confirmed->approval_by_head_of_human_resource;
                // $branch = $checking_data_confirmed->approval_by_head_of_branch;

                // $all_pending = ($finance === 'pending' && $hr === 'pending' && $branch === 'pending');
                // $hr_confirmed_only = ($finance === 'pending' && $hr === 'confirmed' && $branch === 'pending');
                // $finance_confirmed_only = ($finance === 'confirmed' && $hr === 'pending' && $branch === 'pending');
                // $branch_confirmed_only = ($finance === 'pending' && $hr === 'pending' && $branch === 'confirmed');
                // $all_confirmed = ($finance === 'confirmed' && $hr === 'confirmed' && $branch === 'confirmed');

                // if ($all_pending || $hr_confirmed_only || $finance_confirmed_only || $branch_confirmed_only) {
                //     session()->flash('message_success', 'Data Berhasil disimpan!');
                //     return redirect()->route('master_payroll.index');
                // } elseif ($all_confirmed) {
                //     PayrollModel::where('id', $request->payroll_id)->update([
                //         'status' => 'Sudah Konfirmasi New',
                //         'updated_at' => now(),
                //         'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                //     ]);
                // }


                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Payroll berhasil dikonfirmasi!');
                return redirect()->route('master_payroll.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_payroll.index');
            }
        } else {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Finance Operation') {
                DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                    'payroll_id' => $request->payroll_id,
                    'approval_by_head_of_finance' => $request->approval_by_head_of_finance
                ]);
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Human Resource') {
                DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                    'payroll_id' => $request->payroll_id,
                    'approval_by_head_of_human_resource' => $request->approval_by_head_of_human_resource
                ]);
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations') {
                DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                    'payroll_id' => $request->payroll_id,
                    'branch_head_id' => $branch_login,
                    'approval_by_head_of_branch' => $request->approval_by_head_of_branch
                ]);
            }

            // $checking_data_confirmed = DB::table('payroll_approval')->first();

            // $finance = $checking_data_confirmed->approval_by_head_of_finance;
            // $hr = $checking_data_confirmed->approval_by_head_of_human_resource;
            // $branch = $checking_data_confirmed->approval_by_head_of_branch;

            // $all_pending = ($finance === 'pending' && $hr === 'pending' && $branch === 'pending');
            // $hr_confirmed_only = ($finance === 'pending' && $hr === 'confirmed' && $branch === 'pending');
            // $finance_confirmed_only = ($finance === 'confirmed' && $hr === 'pending' && $branch === 'pending');
            // $branch_confirmed_only = ($finance === 'pending' && $hr === 'pending' && $branch === 'confirmed');


            // FIX THIS BUG!!!! date :26/05/2025
            // $all_confirmed = ($finance === 'confirmed' && $hr === 'confirmed' && $branch === 'confirmed');


            // if ($all_confirmed) {
            //     PayrollModel::where('id', $request->payroll_id)->update([
            //         'status' => 'Sudah Konfirmasi New banget',
            //         'updated_at' => now(),
            //         'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            //     ]);
            // }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Payroll berhasil dikonfirmasi!');
            return redirect()->route('master_payroll.index');
        }
    }


    // <!-- bug fixing -->

    public function get_attendance(Request $request, $id)
    {

        $attendance = DB::table('v_payroll')
            ->select('id', 'total_hadir', 'total_izin', 'total_sakit', 'total_alpha_ongoing')
            ->where('id', $request->id)
            ->get();
        $attendance_type = ['Hadir', 'Izin', 'Sakit', 'Alpha']; // Menggunakan pluck untuk mendapatkan array

        return response()->json([
            'total_hadir' => $attendance->isNotEmpty() ? $attendance : [['total_hadir' => 0]], // Mengambil nilai total_hadir
            'total_izin' => $attendance->isNotEmpty() ? $attendance : [['total_izin' => 0]],   // Mengambil nilai total_izin
            'total_sakit' => $attendance->isNotEmpty() ? $attendance : [['total_sakit' => 0]],
            'total_alpha_ongoing' => $attendance->isNotEmpty() ? $attendance : [['total_alpha_ongoing' => 0]], // Mengambil nilai total_sakit
            'attendance_type' => $attendance_type
        ]);
    }
}
