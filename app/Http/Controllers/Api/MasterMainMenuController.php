<?php

namespace App\Http\Controllers\Api;

use App\Exports\SubmenuExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\MainMenuModel;
use App\Models\RoleModel;
use App\Models\EmployeeModel;
use App\Models\SubmenuModel;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Event\Telemetry\System;
use App\Http\Controllers\Api\MasterVehicleData;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\isTrue;

class MasterMainMenuController extends Controller
{

    public function index(): View
    {
        $master_menus = $this->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $main_menu = DB::table('v_main_menu')->get();
        return view('layouts.admin_views.menus_admin.main_menu', compact('main_menu', 'grouped_sub_menu', 'sidebar_menu'));
    }

    // contoh menjalankan function master display menus

    public function menus_create_layout(): View
    {

        $master_menus = $this->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        return view('layouts.admin_views.menus_admin.create.main_menu_create', compact('sidebar_menu', 'grouped_sub_menu'));
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $validator =  Validator::make($request->all(), [
            'menu_name' => 'required|unique:main_menu',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if ($insertTime >= 7 && $insertTime <= 18) {
            $data = MainMenuModel::create([
                'menu_name' => $request->menu_name,
                'menu_icon' => $request->menu_icon,
                'location'  => $request->location,
                'is_active' => $request->is_active,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_main_menus.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_main_menus.index');
        }
    }

    // script untuk menjalankan submenu main menus
    public function master_display_menus()
    {
        $finance_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '1' || app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '11';
        $humanResource_role = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '12' || app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '13';
        $admin_role = auth()->user()->role == '1';
        $superadmin_role = auth()->user()->role == '2';
        $head_branch = auth()->user()->role == '3';

        if ($finance_role || $humanResource_role) {
            if ($admin_role) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('admin_role', '<>', 'N')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            } elseif ($head_branch) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('admin_role', '<>', 'N')->where('branch_head_role', '<>', 'N')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            } elseif ($superadmin_role) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('admin_role', 'Y')->orWhere('superadmin_role', 'Y')->orWhere('branch_head_role', 'Y')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            }
        } else {
            if ($admin_role) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('id', '<>', '18')->where('admin_role', '<>', 'N')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            } elseif ($head_branch) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('admin_role', '<>', 'N')->where('branch_head_role', '<>', 'N')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            } elseif ($superadmin_role) {
                $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
                $sub_menu = DB::table('submenu')->where('id', '<>', '18')->orderBy('submenu_name', 'asc')->get();
                $grouped_sub_menu = $sub_menu->groupBy('parent_id');
                return compact('grouped_sub_menu', 'sidebar_menu');
            }
        }



        return [
            'sidebar_menu' => [],
            'grouped_sub_menu' => [],
        ];
    }

    public function show($id)
    {
        $show = MainMenuModel::whereId($id)->first();

        if ($show) {
            $master_menus = $this->master_display_menus();
            $sidebar_menu = $master_menus['sidebar_menu'];
            $grouped_sub_menu = $master_menus['grouped_sub_menu'];
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            $main_menu =  DB::table('v_main_menu')->where('id', $id)->get();
            return view('layouts.admin_views.menus_admin.edit.main_menu_edit', compact('roles', 'employees', 'main_menu', 'grouped_sub_menu', 'sidebar_menu'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function menus_edit_layout(): View
    {
        $master_menus = $this->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        return view('layouts.admin_views.menus_admin.edit.main_menu_edit', compact('grouped_sub_menu', 'sidebar_menu'));
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        Validator::make($request->all(), [
            'location' => 'required'

        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {

            $update = DB::table('main_menu')->where('id', $request->id)->update([
                'menu_name' => $request->menu_name,
                'menu_icon' => $request->menu_icon,
                'location' => $request->location,
                'is_active' => $request->is_active,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_main_menus.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_main_menus.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MainMenuModel $main_menu, $id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $main_menu = MainMenuModel::find($id);
        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($main_menu) {
                $main_menu->delete();
                DB::table('log_activity_users')->insert([
                    'user_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->id,
                    'ip_address' => \Request::ip(),
                    'log_activity' => __METHOD__,
                    'created_at'  => now(),
                    'created_by'   => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('delete_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_main_menus.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_main_menus.index');
        }
    }

    // =========================SUBMENU===========================><><><><><><><><>


    // show menu detail submenu

    public function submenu_save(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $validator =  Validator::make($request->all(), [
            'submenu_name' => 'required|unique:submenu',
            'parent_id' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($insertTime >= 7 && $insertTime <= 18) {
            SubmenuModel::create([
                'submenu_name' => $request->submenu_name,
                'submenu_icons' => $request->submenu_icons,
                'submenu_link'  => $request->submenu_link,
                'parent_id' => $request->parent_id,
                'admin_role' => $request->admin_role,
                'superadmin_role' => $request->superadmin_role,
                'branch_head_role' => $request->branch_head_role,
                'is_active' => $request->is_active,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data submenu berhasil disimpan!');
            return redirect()->route('submenu_detail', ['id' => $request->parent_id]);
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 17.00 wib');
            return redirect()->route('submenu_detail', ['id' => $request->parent_id]);
        }
    }


    public function submenu_detail_data(Request $request)
    {
        $submenu = DB::table('v_submenu')->where('parent_id', $request->id)->get();
        $main_menus = DB::table('v_main_menu')->where('id', $request->id)->get();

        // Ambil master menus
        $master_menus = $this->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $roles = RoleModel::all();
        $employees = EmployeeModel::all();

        // Cek apakah ada submenu yang ditemukan
        if ($submenu->isNotEmpty()) {
            return view('layouts.admin_views.menus_admin.submenu', compact('roles', 'employees', 'main_menus', 'submenu', 'grouped_sub_menu', 'sidebar_menu'));
        } else {
            // Jika tidak ada submenu, kirimkan pesan ke view
            return view('layouts.admin_views.menus_admin.submenu', compact('roles', 'employees', 'main_menus', 'submenu', 'grouped_sub_menu', 'sidebar_menu'))
                ->with('message', 'Tidak ada submenu ditemukan untuk parent_id yang diberikan.');
        }
    }


    public function submenu_create_layout(Request $request): View
    {
        $show = DB::table('submenu')->where('parent_id', $request->id)->first();
        $main_menus = DB::table('main_menu')->where('id', $request->id)->get();

        if ($show) {
            $master_menus = $this->master_display_menus();
            $sidebar_menu = $master_menus['sidebar_menu'];
            $grouped_sub_menu = $master_menus['grouped_sub_menu'];
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            $submenu =  DB::table('submenu')->where('parent_id', $request->id)->get();
            $main_menu =  DB::table('main_menu')->where('id', $request->id)->get();
            return view('layouts.admin_views.menus_admin.create.submenu_create', compact('roles', 'employees', 'main_menu', 'grouped_sub_menu', 'sidebar_menu'));
        } elseif ($main_menus) {
            $master_menus = $this->master_display_menus();
            $sidebar_menu = $master_menus['sidebar_menu'];
            $grouped_sub_menu = $master_menus['grouped_sub_menu'];
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            $main_menu =  DB::table('main_menu')->where('id', $request->id)->get();
            return view('layouts.admin_views.menus_admin.create.submenu_create', compact('roles', 'employees', 'main_menu', 'main_menus', 'grouped_sub_menu', 'sidebar_menu'));
        }
    }


    public function submenu_update_layout(Request $request): View
    {
        $master_menus = $this->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $check___role = DB::table('submenu')
            ->select('superadmin_role', 'admin_role', 'branch_head_role')->where('id', $request->id)->first();
        $usr_role = [
            'superadmin_role' => $check___role->superadmin_role,
            'admin_role' => $check___role->admin_role,
            'branch_head_role' => $check___role->branch_head_role
        ];
        $show = DB::table('submenu')->where('id', $request->id)->first();

        if ($show) {
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            $submenu =  DB::table('submenu')->where('id', $request->id)->get();
            return view('layouts.admin_views.menus_admin.edit.submenu_edit', compact('roles', 'employees', 'submenu', 'grouped_sub_menu', 'sidebar_menu', 'usr_role'));
        } else {
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            return view('layouts.blank', compact('roles', 'employees', 'grouped_sub_menu', 'sidebar_menu', 'usr_role'));
        }
    }


    public function submenu_update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        Validator::make($request->all(), [
            'submenu_name' => 'required',
            'parent_id' => 'required'

        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('submenu')->where('id', $request->id)->update([
                'submenu_name' => $request->submenu_name,
                'submenu_icons' => $request->submenu_icons,
                'submenu_link' => $request->submenu_link,
                'parent_id' => $request->parent_id,
                'superadmin_role' => $request->superadmin_role,
                'admin_role' => $request->admin_role,
                'branch_head_role' => $request->branch_head_role,
                'is_active' => $request->is_active,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data submenu berhasil disimpan!');
            return redirect()->route('submenu_detail', ['id' => $request->parent_id]);
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 17.00 wib');
            return redirect()->back();
        }
    }

    public function submenu_delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SubMenuModel = SubmenuModel::where('id', [$request->id])->first();

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($SubMenuModel) {
                $SubMenuModel->delete();
                DB::table('log_activity_users')->insert([
                    'user_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->id,
                    'ip_address' => \Request::ip(),
                    'log_activity' => __METHOD__,
                    'created_at'  => now(),
                    'created_by'   => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data submenu berhasil dihapus!');
                return redirect()->back()->with('message', 'data successfully.');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 17.00 wib');
            return redirect()->back();
        }
    }

    public function submenu_export(Request $request)
    {

        $parent_id = $request->id;
        $MainMenuName = DB::table('v_submenu')->select('menu_name')->where('parent_id', $parent_id)->first();

        $menu_name = $MainMenuName->menu_name;
        // dd($MainMenuName);
        $fileName = 'Data_Submenu' . '-' . $menu_name . '.xlsx';
        return Excel::download(new SubmenuExport($parent_id), $fileName);
    }
}
