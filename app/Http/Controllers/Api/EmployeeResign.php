<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmployeeModel;
use App\Models\EmployeeResignModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class EmployeeResign extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;

        $branch_head_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name === 'Head of Branch Operations';
        $hr_head_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name === 'Head of Human Resource';
        $branch_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;

        if ($hr_head_login) {
            $employee_resign = DB::table('v_employee_resign')->get();
        } elseif ($branch_head_login) {
            $employee_resign = DB::table('v_employee_resign')->where('branch_emp_id', $branch_id)->get();
        } else {
            $employee_resign = DB::table('v_employee_resign')->get();
        }


        return view('layouts.admin_views.employee_resign.employee_resign_main', compact('employee_resign', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'department', 'departments'));
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
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'resign_attachment' => 'required|mimes:pdf|max:10000',
            'resign_reasons' => 'required',
            'resign_date'   => 'required'
        ]);

        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id;

        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('resign_attachment')) {
                    $attachment = $request->file('resign_attachment');
                    $resignAttachmentPath = $attachment->storeAs('resign_attachment', uniqid() . '.' . $attachment->getClientOriginalExtension(), 'public');

                    EmployeeResignModel::create([
                        'employee_id' => $employee_id,
                        'resign_reasons' => $request->resign_reasons,
                        'is_active' => $request->is_active,
                        'resign_date' => $request->resign_date,
                        'last_day_of_work' => $request->last_day_of_work,
                        'return_company_property' => $request->return_company_property,
                        'approval_by_branch_head' => 'pending',
                        'approval_by_hr_head' => 'pending',
                        'resign_status' => 'belum konfirmasi',
                        'resign_attachment' => $resignAttachmentPath
                    ]);
                } else {
                    EmployeeResignModel::create([
                        'employee_id' => $employee_id,
                        'resign_reasons' => $request->resign_reasons,
                        'is_active' => $request->is_active,
                        'resign_date' => $request->resign_date,
                        'last_day_of_work' => $request->last_day_of_work,
                        'return_company_property' => $request->return_company_property,
                        'approval_by_branch_head' => 'pending',
                        'approval_by_hr_head' => 'pending',
                        'resign_status' => 'belum konfirmasi'
                    ]);
                }
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('profile');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
                return redirect()->route('profile');
            }
        } else {
            if ($request->hasFile('resign_attachment')) {
                $attachment = $request->file('resign_attachment');
                $resignAttachmentPath = $attachment->storeAs('resign_attachment', uniqid() . '.' . $attachment->getClientOriginalExtension(), 'public');

                EmployeeResignModel::create([
                    'employee_id' => $employee_id,
                    'resign_reasons' => $request->resign_reasons,
                    'is_active' => $request->is_active,
                    'resign_date' => $request->resign_date,
                    'last_day_of_work' => $request->last_day_of_work,
                    'return_company_property' => $request->return_company_property,
                    'approval_by_branch_head' => 'pending',
                    'approval_by_hr_head' => 'pending',
                    'resign_status' => 'belum konfirmasi',
                    'resign_attachment' => $resignAttachmentPath
                ]);
            } else {
                EmployeeResignModel::create([
                    'employee_id' => $employee_id,
                    'resign_reasons' => $request->resign_reasons,
                    'is_active' => $request->is_active,
                    'resign_date' => $request->resign_date,
                    'last_day_of_work' => $request->last_day_of_work,
                    'return_company_property' => $request->return_company_property,
                    'approval_by_branch_head' => 'pending',
                    'approval_by_hr_head' => 'pending',
                    'resign_status' => 'belum konfirmasi'
                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('profile');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     */
    public function confirm_employee_resign(string $id, Request $request)
    {

        $hr_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Human Resource';
        $head_branch_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $head_branch_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;



        if ($hr_login) {
            DB::table('employee_resign')->where('id', $request->id)->update([
                'approval_by_hr_head' => 'confirmed',
                'feedback' => $request->feedback
            ]);
        } elseif ($head_branch_login) {
            DB::table('employee_resign')->where('id', $request->id)->update([
                'approval_by_branch_head' => 'confirmed',
                'branch_head_id' => $head_branch_id
            ]);
        }

        $checking_data_confirmed = DB::table('employee_resign')->where('id', $request->id)->first();
        $emp_id = $checking_data_confirmed->employee_id;

        if (!$checking_data_confirmed) {
            session()->flash('message_error', 'Data tidak ditemukan.');
            return redirect()->back();
        }

        $branch_head_approval = $checking_data_confirmed->approval_by_branch_head;
        $hrd_approval = $checking_data_confirmed->approval_by_hr_head;

        if ($branch_head_approval == 'pending' && $hrd_approval == 'pending') {
            session()->flash('message_success', 'Data berhasil disimpan!');
            return redirect()->back();
        } elseif (
            ($branch_head_approval == 'confirmed' && $hrd_approval == 'pending') ||
            ($branch_head_approval == 'pending' && $hrd_approval == 'confirmed')
        ) {
            session()->flash('message_success', 'Data berhasil disimpan!');
            return redirect()->back();
        } elseif ($branch_head_approval === 'confirmed' && $hrd_approval === 'confirmed') {
            EmployeeResignModel::where('id', $request->id)->update([
                'resign_status' => 'sudah konfirmasi',
                'updated_at' => now()
            ]);

            EmployeeModel::where('id', $emp_id)->update([
                'is_active' => 'N'
            ]);

            // User::where('employee_id', $request->id)->update([
            //     'is_active' => 'N'
            // ]);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->back();
        }

        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Berhasil disimpan!');
        return redirect()->back();
    }

    public function employee_resign_layout(Request $request): View
    {


        if (auth()->user()->nik  !== auth()->user()->nik) {
            abort(403, 'Ooops unauthorized nik');
        }

        $employees = DB::table('v_employee')->where('nik', auth()->user()->nik)->get();
        if ($employees->isEmpty()) {
            abort(403, 'Ooops unauthorized nik');
        }


        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $start_date = Carbon::parse($employees->first()->start_date);

        $employee = DB::table('v_employee')->where('nik', auth()->user()->nik)->get();
        $main_menu = DB::table('v_main_menu')->get();
        return view('layouts.admin_views.employee_resign.edit.employee_resign', compact('employee', 'start_date', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function download_resignation_letter($id)
    {

        $employee_resign = DB::table('v_employee_resign')->where('id', $id)->get()->toArray();

        $e_id = $employee_resign[0] ?? null;

        $emp_id = $e_id->employee_id;

        $head_branch_signature = DB::table('employee as e')
            ->select('e.nik', 'e.name', 'jp.position_name', 'signature')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->leftJoin('v_employee_resign as ver', 'b.id', '=', 'ver.branch_head_id')
            ->join('employee_signature as es', 'e.id', '=', 'es.employee_id')
            ->where('ver.branch_head_id', '=', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id)
            ->where('jp.position_name', 'Head of Branch Operations')->get();

        $head_hr_signature = DB::table('employee as e')
            ->select('e.nik', 'e.name', 'jp.position_name', 'signature')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->join('employee_signature as es', 'e.id', '=', 'es.employee_id')
            ->where('jp.position_name', 'Head of Human Resource')->get();

        $employee_signature = DB::table('employee as e')
            ->select('e.nik', 'e.name', 'jp.position_name', 'signature')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->join('employee_signature as es', 'e.id', '=', 'es.employee_id')
            ->where('e.id', '=', $emp_id)->get();


        $resignation_letter = Pdf::loadView('layouts.pdf.resign_letter', [
            'employee_resign' => $employee_resign,
            'head_branch_signature' => $head_branch_signature,
            'head_hr_signature' => $head_hr_signature,
            'employee_signature' => $employee_signature
        ]);

        $first = $employee_resign[0] ?? null;

        $nik = $first->nik ?? '';
        $name = Str::slug($first->name ?? '');

        $filename = 'surat_resign_karyawan_' . $nik . '-' . $name . '.pdf';

        return $resignation_letter->download($filename);
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
