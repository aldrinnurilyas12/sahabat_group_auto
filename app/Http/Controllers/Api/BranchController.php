<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BranchModel;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Exports\BranchExport;
use Maatwebsite\Excel\Facades\Excel;

class BranchController extends Controller
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

        $branch = DB::table('v_branch')->get();
        return view('layouts.admin_views.branch.branch', compact('branch', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_branch_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch_head = DB::table('v_employee')->where('job_position', 'Head of Branch Operations')->get();
        $branch = BranchModel::all();
        return view('layouts.admin_views.branch.create.branch_create', compact('branch', 'grouped_sub_menu', 'sidebar_menu', 'branch_head'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'location_code' => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {
            BranchModel::create([
                'location_code' => $request->location_code,
                'location_name' => $request->location_name,
                'address'       => $request->address,
                'branch_head_name'   => $request->branch_head_name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_branch.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_branch.index');
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
    public function edit_branch_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch = DB::table('branch')->where('id', $request->id)->get();
        return view('layouts.admin_views.branch.edit.branch_edit', compact('branch', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('branch')->where('id', $request->id)->update([
                'location_code' => $request->location_code,
                'location_name' => $request->location_name,
                'address'       => $request->address,
                'branch_head_name'   => $request->branch_head_name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_branch.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_branch.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = BranchModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {

            if ($branch) {
                $branch->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_branch.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_branch.index');
        }
    }

    public function branch_export(Request $request)
    {

        $fileName = 'Data_Cabang' . '-' . date('Y') . '.xlsx';
        return Excel::download(new BranchExport, $fileName);
    }
}
