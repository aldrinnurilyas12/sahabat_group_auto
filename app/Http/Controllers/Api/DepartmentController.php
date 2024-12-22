<?php

namespace App\Http\Controllers\Api;

use App\Exports\DepartmentExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\DepartmentModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class DepartmentController extends Controller
{


    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $status_category = DB::table('status_category')->get();
        $department = DB::table('department')->get();
        return view('layouts.admin_views.department.department', compact('department', 'grouped_sub_menu', 'sidebar_menu'));
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


    public function department_create_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $status_category = DB::table('status_category')->get();
        $department = DB::table('department')->get();
        return view('layouts.admin_views.department.create.department_create', compact('department', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'department_code' => 'required',
            'department_name' => 'required'
        ]);


        if ($insertTime >= 7  && $insertTime <= 20) {
            DepartmentModel::create([
                'department_code' => $request->department_code,
                'department_name' => $request->department_name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_department.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_department.index');
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
    public function edit_layout(Request $request, string $id): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $status_category = DB::table('status_category')->get();
        $department = DB::table('department')->where('id', $request->id)->get();
        return view('layouts.admin_views.department.edit.department_edit', compact('department', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {

            $update_department = DB::table('department')->where('id', $request->id)->update([
                'department_code' => $request->department_code,
                'department_name' => $request->department_name,
                'updated_by'    => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at'    => now()
            ]);

            if ($update_department) {
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil diperbarui!');
                return redirect()->route('master_department.index');
            } else {
                abort(403, 'Gagal updated data');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_department.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = DepartmentModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($department) {
                $department->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_department.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_department.index');
        }
    }

    public function department_export(Request $request)
    {
        $fileName = 'Data_Department' . '-' .  date('Y') . '.xlsx';
        return Excel::download(new DepartmentExport, $fileName);
    }
}
