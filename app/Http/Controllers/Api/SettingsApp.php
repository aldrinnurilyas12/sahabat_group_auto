<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Mail\MaintenanceNotification;
use App\Models\BranchModel;
use App\Models\UnderDevelopmentSetting;
use PhpParser\Node\Stmt\Else_;
use Psy\CodeCleaner\ReturnTypePass;
use Illuminate\Support\Facades\Mail;


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

        $setting_app = DB::table('under_development_setting')->select('admin_web', 'landing_page_web', 'description')->first();
        $setting_time = DB::table('settings_schedule_time')->first();

        $settings_data = DB::table('under_development_setting')->get();

        return view('layouts.admin_views.settings', compact('grouped_sub_menu', 'sidebar_menu', 'setting_time', 'setting_app', 'settings_data'));
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
            $maintenance = UnderDevelopmentSetting::find(1);

            $maintenance->update(
                [
                    'admin_web' => $request->admin_web,
                    'landing_page_web' => $request->landing_page_web,
                    'description' => $request->description,
                    'start_date_maintenance' => $request->start_date_maintenance,
                    'time_start_date_maintenance' => $request->time_start_date_maintenance,
                    'end_date_maintenance' => $request->end_date_maintenance,
                    'time_end_date_maintenance' => $request->time_end_date_maintenance,
                    'updated_at' => now(),
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]
            );

            if ($request->admin_web == 'Ya') {
                $this->maintenance_notification($maintenance);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Pengaturan Berhasil disimpan!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Anda tidak bisa akses ke module ini!');
            return redirect()->back();
        }
    }

    public function maintenance_notification(UnderDevelopmentSetting $maintenance)
    {

        $user_email = DB::table('users')->where('is_active', 'Y')->get();

        if ($user_email->isEmpty()) {
            return response()->json(['error' => 'No Email User Found'], 404);
        }

        try {
            foreach ($user_email as $email) {
                Mail::to($email->email)->send(new MaintenanceNotification($maintenance));
            }
        } catch (\Exception $e) {
            \Log::error('Email send failed : ' . $e->getMessage());
            return response()->json(['error' => 'Failed sending email'], 500);
        }
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
