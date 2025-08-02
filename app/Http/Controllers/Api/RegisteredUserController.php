<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\EmployeeModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Mail\UsersAdminVerification;
use Illuminate\Support\Facades\Mail;
use Ramsey\Uuid\Uuid;

class RegisteredUserController extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index()
    {
        $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
        $sub_menu = DB::table('submenu')->get();
        $grouped_sub_menu = $sub_menu->groupBy('parent_id');
        $users = DB::table('v_users')->get();
        $roles = RoleModel::all();
        $employees = EmployeeModel::all();

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.users_admin.users_data', compact('users', 'grouped_sub_menu', 'roles', 'employees', 'sidebar_menu'));
    }



    public function users_create_layout()
    {

        $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
        $sub_menu = DB::table('submenu')->get();
        $grouped_sub_menu = $sub_menu->groupBy('parent_id');
        $roles = RoleModel::all();
        $employees = DB::table('employee')
            ->select('employee.id', 'employee.nik', 'name', 'users.is_active')
            ->leftJoin('users', 'employee.id', '=', 'users.employee_id')
            ->where('users.is_active', null)
            ->where('employee.is_active', 'Y')
            ->get();

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.users_admin.create.users_create', compact('roles', 'employees', 'grouped_sub_menu', 'sidebar_menu'));
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


    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $validate = $request->validate([
            'nik' => 'required|max:16|unique:users',
            'employee_id' => 'unique:users',
            'email' => 'unique:users'
        ]);
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 22) {
                $User = User::create([
                    'employee_id' => $request->employee_id,
                    'nik' => $validate['nik'],
                    'email' => $request->email,
                    'is_active' => 'X',
                    'password' => Hash::make($request->password),
                    'role' => $request->role,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->SentEmailVerification($User);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_users.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 - 12.00.');
                return redirect()->route('master_users.index');
            }
        } else {
            $User = User::create([
                'employee_id' => $request->employee_id,
                'nik' => $validate['nik'],
                'email' => $request->email,
                'is_active' => 'X',
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->SentEmailVerification($User);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_users.index');
        }
    }


    public function SentEmailVerification(User $User)
    {

        try {
            Mail::to($User->email)->send(new UsersAdminVerification($User));
            return response()->json(['message' => 'Email berhasil dikirim'], 200);
        } catch (\Exception $e) {
            \Log::error('Email sending failed : ' .  $e->getMessage());
            return response()->json(['error' => 'failed to send email'], 500);
        }
    }

    // EDIT USERS LAYOUT
    public function show($id)
    {
        $show = User::whereId($id)->first();

        if ($show) {
            $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
            $sub_menu = DB::table('submenu')->get();
            $grouped_sub_menu = $sub_menu->groupBy('parent_id');
            $roles = RoleModel::all();
            $employees = EmployeeModel::all();
            $user =  DB::table('v_users')->where('id', $id)->get();
        }

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.users_admin.edit.users_edit', compact('roles', 'employees', 'user', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                DB::table('users')->where('id', $request->id)->update([
                    'nik' => $request->nik,
                    'email' => $request->email,
                    'is_active' => $request->is_active,
                    'role' => $request->role,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_at' => now()
                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_users.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 - 18.00.');
                return redirect()->route('master_users.index');
            }
        } else {
            DB::table('users')->where('id', $request->id)->update([
                'nik' => $request->nik,
                'email' => $request->email,
                'is_active' => $request->is_active,
                'role' => $request->role,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_users.index');
        }
    }

    public function getEmailNik($employeeId)
    {
        $employeeData = EmployeeModel::find($employeeId);
        return response()->json([
            'email' => $employeeData->email,
            'nik' => $employeeData->nik,
            'birth_date' => $employeeData->birth_date
        ]);
    }

    public function destroy(User $user, $id)
    {
        $user = User::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($user) {
                    $user->delete();
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('delete_success', 'Data Berhasil dihapus!');
                    return redirect()->back()->with('success', 'User deleted successfully!');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional : 08.00 - 18.00.');
                return redirect()->route('master_users.index');
            }
        } else {
            if ($user) {
                $user->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('delete_success', 'Data Berhasil dihapus!');
                return redirect()->back()->with('success', 'User deleted successfully!');
            }
        }
    }

    public function getUsersActivity()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'] ?? [];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'] ?? [];
        $users_activity = DB::table('users as u')
            ->select('u.id', 'u.nik', 'u.email', 'e.name', 'r.role_name', 'u.last_seen', 'b.location_name', 'jp.position_name')
            ->leftJoin('employee as e', 'u.employee_id', '=', 'e.id')
            ->leftJoin('role as r', 'u.role', '=', 'r.id')
            ->leftJoin('branch as b', 'e.branch_id', '=', 'b.id')
            ->leftJoin('job_position as jp', 'e.job_position', '=', 'jp.id')
            ->orderBy('u.last_seen', 'DESC')
            ->get();
        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.users_activity', compact('users_activity', 'grouped_sub_menu', 'sidebar_menu',));
    }
}
