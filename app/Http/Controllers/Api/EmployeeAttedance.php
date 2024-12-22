<?php

namespace App\Http\Controllers\Api;

use AllowDynamicProperties;
use App\Exports\AttendanceBranchExport;
use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeAttedanceModel;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\returnSelf;

class EmployeeAttedance extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index(Request $request): View
    {
        $user_data =  auth()->user();
        $users = $user_data->employee_id;
        $checking_data = DB::table('employee_attedance')->where('attedance_date', now()->toDateString())->where('employee_id', $users)->get();
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
        $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
        $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
        $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
        $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
        $months = DB::table('months')->get();
        $years = [
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028'
        ];
        $bulan = $request->month;
        $tahun = $request->year;



        if (auth()->user()->role == '3') {
            $bulan = $request->month;
            $tahun = $request->year;
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', 'PLAZA AUTO')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', 'PERMATA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', 'KURNIA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', 'MEGA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            }
        } elseif (auth()->user()->role == '1' || auth()->user()->role == '2') {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->where('employee_id', $users)->whereDate('created_at', '=', now()->toDateString())->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            }
        } else {
        }
    }


    public function filter_attedance(Request $request)
    {
        // $request->validate([
        //     'month' => 'required',
        //     'year' => 'required'
        // ]);

        $bulan = $request->month;
        $tahun = $request->year;



        $user_data =  auth()->user();
        $users = $user_data->employee_id;
        $checking_data = DB::table('employee_attedance')->where('attedance_date', now()->toDateString())->where('employee_id', $users)->get();
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
        $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
        $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
        $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
        $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
        $months = DB::table('months')->get();
        $years = [
            '2020',
            '2021',
            '2022',
            '2023',
            '2024',
            '2025',
            '2026',
            '2027',
            '2028'
        ];

        if (auth()->user()->role == '3') {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PLAZA AUTO')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PLAZA AUTO')->where('attedance_type', 'alpha')->count();
                }

                $employee_data = DB::table('v_employee')->where('location_name', 'PLAZA AUTO')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'PERMATA ABADI MOTOR')->where('attedance_type', 'alpha')->count();
                }

                $employee_data = DB::table('v_employee')->where('location_name', 'PERMATA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'KURNIA ABADI MOTOR')->where('attedance_type', 'alpha')->count();
                }


                $employee_data = DB::table('v_employee')->where('location_name', 'KURNIA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->count();
                    $attedance_present = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->where('attedance_type', 'hadir')->count();
                    $attedance_izin = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->where('attedance_type', 'izin')->count();
                    $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->where('attedance_type', 'sakit')->count();
                    $attedance_alpha = DB::table('V_employee_attedance')->where('branch', 'MEGA ABADI MOTOR')->where('attedance_type', 'alpha')->count();
                }
                $employee_data = DB::table('v_employee')->where('location_name', 'MEGA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            }
        } elseif (auth()->user()->role == '1' || auth()->user()->role == '2') {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'PLAZA AUTO')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                $employee_data = DB::table('v_employee')->where('location_name', 'PLAZA AUTO')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {

                $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'PERMATA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }


                $employee_data = DB::table('v_employee')->where('location_name', 'PERMATA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('branch', 'KURNIA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }


                $employee_data = DB::table('v_employee')->where('location_name', 'KURNIA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->orderBy('created_at', 'desc')->get();

                if ($bulan) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }
                if ($tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan && $tahun) {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }

                if ($bulan === 'alldata' && $tahun === 'alldata') {
                    $employee_attedance = DB::table('v_employee_attedance')->where('employee_id', $users)->where('location_name', 'MEGA ABADI MOTOR')->orderBy('created_at', 'desc')->get();
                    $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
                    $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
                    $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
                    $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
                    $attedance_alpha = DB::table('employee_attedance')->where('attedance_type', 'alpha')->where('employee_id', $users)->count();
                }


                $employee_data = DB::table('v_employee')->where('location_name', 'MEGA ABADI MOTOR')->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            }
        }
    }



    public function attendance_export(Request $request)
    {
        $filter_date = $this->filter_attedance($request); // Call once and store the result
        $month = $request->bulan; // Access month from the result
        $year =  $request->tahun; // Access year from the result


        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;
        $location_name = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $name = str_replace(' ', '-', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name);
        // Get the selected attendance data filtered by month and year
        $selected_date = $this->filter_attedance($request);



        $fileName = 'Data_Presensi' . '_' . $name . '-' . $month . '_' . $year . '.xlsx';
        return Excel::download(new AttendanceExport($selected_date, $month, $year, $employee_id, $name, $location_name), $fileName);
    }



    public function branch_attendance_export(Request $request)
    {
        $filter_date = $this->filter_attedance($request); // Call once and store the result
        $month = $request->bulan; // Access month from the result
        $year =  $request->tahun; // Access year from the result

        $branch = str_replace(' ', '-', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name);
        // Get the selected attendance data filtered by month and year
        $fileName = 'Data_Presensi' . '_' . $branch . '-' . $month . '_' . $year . '.xlsx';
        return Excel::download(new AttendanceBranchExport($month, $year), $fileName);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create_employee_attedance_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee_attedance = DB::table('v_employee_attedance')->get();
        return view('layouts.admin_views.employee_attedance.create.add_employee_attedance', compact('grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'attedance_date' => 'required',
            'attedance_type' => 'required'
        ]);

        if ($insertTime >= 8 && $insertTime <= 18) {
            if ($insertTime >= 8  && $insertTime <= 10) {
                EmployeeAttedanceModel::create([
                    'employee_id' => $request->employee_id,
                    'attedance_type' => $request->attedance_type,
                    'reasons' => $request->reasons,
                    'attedance_date' => $request->attedance_date,
                    'fotos' => $request->fotos,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_employee_attedance.index');
            } else {
                session()->flash('failed_insert', 'Presensi sudah lewat!.');
                return redirect()->route('master_employee_attedance.index');
            }
        } else {
            session()->flash('failed_insert', 'Presensi belum pada jadwalnya!, Presensi dilakukan jam 08.00 Wib.');
            return redirect()->route('master_employee_attedance.index');
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
    public function edit_employee_attedance_layout(Request $request, $nik): View
    {

        if (auth()->check() && auth()->user()->nik !== $nik) {
            abort(403, 'Ooops unauthorized nik');
        }

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee_attedance = DB::table('v_employee_attedance')->where('id', $request->id)->where('nik', $request->nik)->get();

        if ($employee_attedance->isEmpty()) {
            abort(403, 'Ooops unauthorized nik');
        }
        return view('layouts.admin_views.employee_attedance.edit.edit_employee_attedance', compact('employee_attedance', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'attedance_date' => 'required',
            'attedance_type' => 'required'
        ]);

        DB::table('employee_attedance')->where('id', $request->id)->update([
            'employee_id' => $request->employee_id,
            'attedance_type' => $request->attedance_type,
            'reasons' => $request->reasons,
            'attedance_date' => $request->attedance_date,
            'fotos' => $request->fotos,
            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
            'updated_at' => now()
        ]);
        session()->flash('message_success', 'Data Berhasil disimpan!');
        return redirect()->route('master_employee_attedance.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
