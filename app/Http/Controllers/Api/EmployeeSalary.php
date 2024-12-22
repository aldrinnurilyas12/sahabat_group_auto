<?php

namespace App\Http\Controllers\Api;

use App\Exports\EmployeeSalary as ExportsEmployeeSalary;
use App\Exports\EmployeeSalaryExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Api\MasterMainMenuController;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeSalaryModel;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeSalary extends Controller
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
        $departments = $request->department;
        $department = DB::table('department')->get();
        $show_employee = DB::table('employee')
            ->select('job_position.id as jb_id', 'employee.id as employee_id', 'employee.nik', 'employee.name', 'employee.phone_number', 'b.location_name', 'job_position.position_name')
            ->leftJoin('branch as b', 'employee.branch_id', '=', 'b.id')
            ->leftJoin('job_position', 'employee.job_position', '=', 'job_position.id')
            ->whereRaw('job_position.id', $request->jb_id)->get();

        $employee_salary = DB::table('v_employee_salary')->get();
        return view('layouts.admin_views.employee_salary.employee_salary', compact('employee_salary', 'grouped_sub_menu', 'show_employee', 'sidebar_menu', 'department', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_emp_salary_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $department = DB::table('department')->get();
        return view('layouts.admin_views.employee_salary.create.employee_salary_create', compact('grouped_sub_menu', 'sidebar_menu', 'department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'position_name' => 'required',
            'department_id' => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {

            EmployeeSalaryModel::create([
                'department_id' => $request->department_id,
                'position_name' => $request->position_name,
                'salary'    => $request->salary,
                'tunjangan_transport' => $request->tunjangan_transport,
                'tunjangan_kesehatan' => $request->tunjangan_kesehatan,
                'tunjangan_lainnya'  => $request->tunjangan_lainnya,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_employee_salary.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee_salary.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $employee_salary = DB::table('v_employee_salary')->where('id', $request->id)->get();
        $department = DB::table('department')->get();
        return view('layouts.admin_views.employee_salary.edit.employee_salary_edit', compact('employee_salary', 'grouped_sub_menu', 'sidebar_menu', 'department'));
    }


    public function filter_salary(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];


        $employee_salary = DB::table('v_employee_salary')->get();
        $department = DB::table('department')->get();
        $show_employee = DB::table('employee')
            ->select('job_position.id as jb_id', 'employee.id as employee_id', 'employee.nik', 'employee.name', 'employee.phone_number', 'b.location_name', 'job_position.position_name')
            ->leftJoin('branch as b', 'employee.branch_id', '=', 'b.id')
            ->leftJoin('job_position', 'employee.job_position', '=', 'job_position.id')
            ->whereRaw('job_position.id', $request->jb_id)->get();
        $departments = $request->department;



        if ($departments == 'alldata') {
            $employee_salary = DB::table('v_employee_salary')->get();
        } else {
            $employee_salary = DB::table('v_employee_salary')->where('department_name', $departments)->get();
        }
        return view('layouts.admin_views.employee_salary.employee_salary', compact('employee_salary', 'grouped_sub_menu', 'show_employee', 'sidebar_menu', 'department', 'departments'));
    }

    public function employee_salary_export(Request $request)
    {

        $departments = $request->department;

        $fileName = 'Data_Posisi_Pekerjaan' . '-' . $departments . date('Y') . '.xlsx';

        return Excel::download(new EmployeeSalaryExport($departments), $fileName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {

            DB::table('job_position')->where('id', $request->id)->update([
                'department_id' => $request->department_id,
                'position_name' => $request->position_name,
                'salary'    => $request->salary,
                'tunjangan_transport' => $request->tunjangan_transport,
                'tunjangan_kesehatan' => $request->tunjangan_kesehatan,
                'tunjangan_lainnya'  => $request->tunjangan_lainnya,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_employee_salary.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee_salary.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $emp_salary = EmployeeSalaryModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {

            if ($emp_salary) {
                $emp_salary->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_employee_salary.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee_salary.index');
        }
    }
}
