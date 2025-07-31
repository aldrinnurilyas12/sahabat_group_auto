<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\LeavesAbsences;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PhpParser\Node\Stmt\Return_;
use Ramsey\Uuid\Uuid;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Exports\EmployeeLeavesExport;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeLeaves extends Controller
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

        $branch_login_session = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $hr_login_session = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $branch_id_login_session = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;

        $office = DB::table('branch')->get();


        $departments = $request->department;

        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;

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

        if ($branch_login_session) {
            $employee_leaves = DB::table('v_employee_leaves')->where('branch_id', $branch_id_login_session)->orderBy('created_at', 'desc')->get();
        } elseif ($hr_login_session) {
            $employee_leaves = DB::table('v_employee_leaves')->orderBy('created_at', 'desc')->get();
        } else {
            $employee_leaves = DB::table('v_employee_leaves')->orderBy('created_at', 'desc')->get();
        }


        return view('layouts.admin_views.employee_absences_leaves.employee_leaves_data', compact('employee_leaves', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'bulan', 'tahun', 'months', 'years', 'department', 'departments'));
    }

    public function employee_absences_leaves(Request $request): View
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
        $main_menu = DB::table('v_main_menu')->get();

        $employee = DB::table('v_employee')->where('nik', auth()->user()->nik)->get();
        return view('layouts.admin_views.employee_absences_leaves.create.add_employee_absences', compact('employee', 'grouped_sub_menu', 'sidebar_menu'));
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
            'attachment' => 'required|mimes:pdf|max:10000',
            'type_of_leave' => 'required',
            'reason' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id;

        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('attachment')) {
                    $attachment = $request->file('attachment');
                    $leavesAttachmentPath = $attachment->storeAs('leaves_attachment', uniqid() . '.' . $attachment->getClientOriginalExtension(), 'public');

                    LeavesAbsences::create([
                        'employee_id' => $employee_id,
                        'absences_code' => Uuid::uuid4()->toString(),
                        'type_of_leave' => $request->type_of_leave,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'reason' => $request->reason,
                        'status' => 'belum konfirmasi',
                        'attachment' => $leavesAttachmentPath,
                        'approval_by_branch_head' => 'pending',
                        'approval_by_hr_head' => 'pending',
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);

                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil disimpan!');
                    return redirect()->route('profile');
                } else {
                    session()->flash('failed_upload_pdf', 'Harus upload surat Cuti!');
                    return redirect()->route('employee_absences_leaves');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
                return redirect()->route('profile');
            }
        } else {
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $leavesAttachmentPath = $attachment->storeAs('leaves_attachment', uniqid() . '.' . $attachment->getClientOriginalExtension(), 'public');

                LeavesAbsences::create([
                    'employee_id' => $employee_id,
                    'absences_code' => Uuid::uuid4()->toString(),
                    'type_of_leave' => $request->type_of_leave,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'reason' => $request->reason,
                    'status' => 'belum konfirmasi',
                    'attachment' => $leavesAttachmentPath,
                    'approval_by_branch_head' => 'pending',
                    'approval_by_hr_head' => 'pending',
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            } else {
                LeavesAbsences::create([
                    'employee_id' => $employee_id,
                    'absences_code' => Uuid::uuid4()->toString(),
                    'type_of_leave' => $request->type_of_leave,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'reason' => $request->reason,
                    'status' => 'belum konfirmasi',
                    'approval_by_branch_head' => 'pending',
                    'approval_by_hr_head' => 'pending',
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('profile');
        }
    }


    public function confirm_employee_leaves(Request $request)
    {

        $hr_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Human Resource';
        $head_branch_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $head_branch_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;

        // parameter kondisi jika status approve dan reject :


        $status_reject = $request->status_reject;
        $status_approve = $request->status_approve;

        if ($hr_login) {

            if ($status_approve) {
                DB::table('leave_of_absences')->where('id', $request->id)->update([
                    'approval_by_hr_head' => 'confirmed'
                ]);
            } elseif ($status_reject) {
                DB::table('leave_of_absences')->where('id', $request->id)->update([
                    'approval_by_hr_head' => 'reject',
                    'hr_reason_of_reject' => $request->hr_reason_of_reject
                ]);
            }
        } elseif ($head_branch_login) {
            if ($status_approve) {
                DB::table('leave_of_absences')->where('id', $request->id)->update([
                    'approval_by_branch_head' => 'confirmed'
                ]);
            } elseif ($status_reject) {
                DB::table('leave_of_absences')->where('id', $request->id)->update([
                    'approval_by_branch_head' => 'reject',
                    'branch_head_reason_of_reject' => $request->branch_head_reason_of_reject
                ]);
            }
        }

        $checking_data_confirmed = DB::table('leave_of_absences')->where('id', $request->id)->first();
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
        } elseif ($branch_head_approval === 'confirmed' && $hrd_approval === 'confirmed') {
            LeavesAbsences::where('id', $request->id)->update([
                'status' => 'sudah konfirmasi',
                'updated_at' => now()
            ]);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->back();
        } elseif ($branch_head_approval === 'reject' && $hrd_approval === 'reject') {
            LeavesAbsences::where('id', $request->id)->update([
                'status' => 'cuti ditolak',
                'updated_at' => now()
            ]);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->back();
        }

        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Berhasil disimpan!');
        return redirect()->back();
    }



    public function download_absences_letter($id, Request $request)
    {

        $employee_leaves = DB::table('v_employee_leaves')->where('absences_code', $request->absences_code)->get()->toArray();

        $e_id = $employee_leaves[0] ?? null;

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


        $absences_letter = Pdf::loadView('layouts.pdf.absences_letter', [
            'employee_leaves' => $employee_leaves,
            'head_branch_signature' => $head_branch_signature,
            'head_hr_signature' => $head_hr_signature,
            'employee_signature' => $employee_signature
        ]);

        $first = $employee_leaves[0] ?? null;

        $nik = $first->nik ?? '';
        $name = Str::slug($first->name ?? '');

        $filename = 'surat_cuti_karyawan_' . $nik . '-' . $name . '.pdf';

        return $absences_letter->download($filename);
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


    public function filter_employee_leaves(Request $request)
    {
        $employee = DB::table('v_employee_leaves')->get();
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;
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



        if ($offices && $bulan && $tahun) {
            $employee_leaves = DB::table('v_employee_leaves')->where('location_name', $offices)
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])->get();
        }
        if ($offices === 'alldata') {
            $employee_leaves = DB::table('v_employee_leaves')->get();
        }



        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        return view('layouts.admin_views.employee_absences_leaves.employee_leaves_data', compact('employee_leaves', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'years', 'months', 'tahun', 'bulan'));
    }


    public function employee_export_leaves(Request $request)
    {
        // $departments = $request->department; // Full month name (e.g., January)
        $offices = $request->office; // Current year (e.g., 2024)
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $fileName = 'Data_Cuti_Karyawan' . '-' . $offices . '-' . $bulan .  '-' . $tahun . '.xlsx';

        return Excel::download(new EmployeeLeavesExport($offices, $bulan, $tahun), $fileName);
    }

    public function download_employee_leaves(Request $request)
    {
        $offices = $request->office;
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



        if ($offices && $bulan && $tahun) {
            $leaves = DB::table('v_employee_leaves')->where('location_name', $offices)
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])->get();
        }
        if ($offices === 'alldata') {
            $leaves = DB::table('v_employee_leaves')->get();
        }


        // Nama file PDF
        $fileName = 'Data_Cuti_Karyawan' . '-' . $offices . '-' . $bulan . '-' . $tahun . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('layouts.pdf.employee_leaves_pdf', [
            'leaves' => $leaves
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
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
