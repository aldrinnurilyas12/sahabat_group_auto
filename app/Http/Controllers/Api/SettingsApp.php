<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\BranchModel;
use PhpParser\Node\Stmt\Else_;

class SettingsApp extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function settings_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'] ?? [];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'] ?? [];

        $setting_time = DB::table('settings_schedule_time')->first();
        return view('layouts.admin_views.settings', compact('grouped_sub_menu', 'sidebar_menu', 'setting_time'));
    }

    public function time__settings(Request $request)
    {

        $IT_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';
        $SUPER_ADMIN_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->role == '2';
        $BRANCH_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->role == '3';

        // date_default_timezone_set('Asia/Jakarta');
        // $insertTime = (int) date('H');

        if ($IT_ROLE || $SUPER_ADMIN_ROLE || $BRANCH_ROLE) {
            DB::table('settings_schedule_time')->where('id', '1')->update([
                'open_schedule_time' =>  $request->open_schedule_time,
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            session()->flash('message_success', 'Pengaturan Berhasil disimpan!');
            return redirect()->back();
        } else {
            return abort(403, 'You don`t have access for this services');
        }
    }


    public function under_development_setting(Request $request)
    {
        $IT_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';

        if ($IT_ROLE) {
            DB::table('under_development_setting')->where('id', 1)->update(
                [
                    'under_development' => $request->under_development,
                    'description' => $request->description,
                    'admin_web' => $request->admin_web,
                    'landing_page_web' => $request->landing_page_web,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]
            );
            session()->flash('message_success', 'Pengaturan Berhasil disimpan!');
            return redirect()->back();
        } else {
            return abort(403, 'You don`t have access for this services');
        }
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
