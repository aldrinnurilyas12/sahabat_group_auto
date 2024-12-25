<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\Models\User;
use Psy\Readline\Hoa\Console;

class LoginAdminController extends Controller
{
    public function login_gateway(): View
    {
        return view('auth.login');
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

    public function store(LoginRequest $request)
    {
        $request->validate([
            'nik' => 'required|max:6'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        // if ($insertTime >= 0 && $insertTime <= 0) {
        $request->authenticate();

        $request->session()->regenerate();

        $credentials = $request->only('nik', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Nik atau password salah'
            ]);
        }

        // $dataResponseToken =  response()->json([
        //     'success' => true,
        //     'user'    => auth()->guard('api')->user(),
        //     'token'   => $token
        // ], 200);

        // return $dataResponseToken;

        $this->insertLogActivityUsers(__METHOD__);
        User::where('nik', Auth::user()->nik)->update(['last_seen' => now()]);
        return redirect()->intended(route('dashboard', absolute: false));
        // } else {
        //     session()->flash('failed_login', 'Maaf saat ini anda tidak bisa login, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib ');
        //     return redirect()->route('login');
        // }
    }

    public function getUsers()
    {

        $user = Auth::user();
        $users = DB::table('users')
            ->select('users.id', 'users.employee_id as user_emp_id', 'users.role', 'employee.nik', 'employee.name as name', 'employee.branch_id', 'employee.id as employee_id', 'branch.location_name', 'employee.job_position', 'employee.email', 'up.users_foto', 'jp.position_name', 'd.department_name')
            ->leftJoin('employee', 'users.employee_id', '=', 'employee.id')
            ->leftJoin('branch', 'employee.branch_id', '=', 'branch.id')
            ->leftJoin('users_picture as up', 'employee.id', '=', 'up.user_id')
            ->join('job_position as jp', 'employee.job_position', '=', 'jp.id')
            ->leftJoin('department as d', 'jp.department_id', '=', 'd.id')
            ->where('users.id', $user->id)
            ->first();


        return $users;
    }
}
