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

        $branch_location = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;

        $branch_head_session = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Branch Operations';
        $hr_head_session = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Human Resource';

        // COUNT TOTAL SEMUA
        $attedance_total = DB::table('employee_attedance')->where('employee_id', $users)->count();
        $attedance_present = DB::table('employee_attedance')->where('attedance_type', 'hadir')->where('employee_id', $users)->count();
        $attedance_izin = DB::table('employee_attedance')->where('attedance_type', 'izin')->where('employee_id', $users)->count();
        $attedance_abnormal = DB::table('employee_attedance')->where('attedance_type', 'sakit')->where('employee_id', $users)->count();
        $attedance_alpha = DB::table('v_employee_attedance')->where('employee_id', $users)->value('total_alpha_ongoing');

        $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->count();
        $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->count();
        $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->count();
        $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->count();
        $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->value('total_alpha_ongoing');

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }
        $bulan = $request->month;
        $tahun = $request->year;

        if (auth()->user()->role == '3') {
            $bulan = $request->month;
            $tahun = $request->year;
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', $branch_location)->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', $branch_location)->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', $branch_location)->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereMonth('attedance_date', Carbon::now()->month)->whereYear('attedance_date', Carbon::now()->year)->orderBy('created_at', 'desc')->get();
                $employee_data = DB::table('v_employee')->where('location_name', $branch_location)->where('is_active', 'Ya')->get();
                $date_listed = DB::table('date_listed')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
            }
        } elseif (auth()->user()->role == '1' || auth()->user()->role == '2') {
            if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '1') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $users)->whereDate('created_at', '=', now()->toDateString())->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '3') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id == '5') {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
            } else {
                $bulan = $request->month;
                $tahun = $request->year;
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $users)->orderBy('created_at', 'desc')->get();
                return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
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

        $branch_location = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
        $branch_head_login = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Branch Operations';
        $emp_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;

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
        $attedance_alpha = DB::table('v_employee_attedance')->where('employee_id', $users)->value('total_alpha_ongoing');


        $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->count();
        $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->count();
        $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->count();
        $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->count();
        $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->value('total_alpha_ongoing');
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }


        $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->orderBy('created_at', 'desc')->get();

        if ($branch_head_login) {
            if ($bulan) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
            }
            if ($tahun) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();


                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($bulan && $tahun) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($bulan === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($tahun === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->count();


                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('attedance_type', 'alpha')->count();
            }
        } else {
            if ($bulan) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
            }
            if ($tahun) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();


                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($bulan && $tahun) {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($bulan === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->whereRaw('YEAR(created_at) = ?', [$tahun])->count();
            }

            if ($tahun === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->where('attedance_type', 'alpha')->count();

                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->whereRaw('MONTH(created_at) = ?', [$bulan])->count();
            }

            if ($bulan === 'alldata' && $tahun === 'alldata') {
                $employee_attedance = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->orderBy('created_at', 'desc')->get();
                $attedance_total = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->count();
                $attedance_present = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'hadir')->count();
                $attedance_izin = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'izin')->count();
                $attedance_abnormal = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'sakit')->count();
                $attedance_alpha = DB::table('V_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->count();


                $attendance_total_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->count();
                $attendance_present_branch = DB::table('v_employee_attedance')->where('attedance_type', 'hadir')->where('branch', $branch_location)->where('employee_id', $emp_id)->count();
                $attendance_izin_branch = DB::table('v_employee_attedance')->where('attedance_type', 'izin')->where('branch', $branch_location)->where('employee_id', $emp_id)->count();
                $attendance_abnormal_branch = DB::table('v_employee_attedance')->where('attedance_type', 'sakit')->where('branch', $branch_location)->where('employee_id', $emp_id)->count();
                $attendance_alpha_branch = DB::table('v_employee_attedance')->where('branch', $branch_location)->where('employee_id', $emp_id)->where('attedance_type', 'alpha')->count();
            }
        }






        $employee_data = DB::table('v_employee')->where('location_name', $branch_location)->where('is_active', 'Ya')->get();
        $date_listed = DB::table('date_listed')->get();

        if ($branch_head_login) {
            return view('layouts.admin_views.employee_attedance.employee_data_attedance_branch', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'attendance_total_branch', 'attendance_present_branch', 'attendance_izin_branch', 'attendance_abnormal_branch', 'attendance_alpha_branch', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
        } else {
            return view('layouts.admin_views.employee_attedance.employee_data_attedance', compact('attedance_abnormal', 'attedance_alpha', 'attedance_izin', 'attedance_present', 'attedance_total', 'employee_data', 'checking_data', 'employee_attedance', 'grouped_sub_menu', 'sidebar_menu', 'date_listed', 'months', 'years', 'bulan', 'tahun'));
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
            'employee_id' => 'required',
            'surat_sakit' => 'image|mimes:jpeg,png,jpg,gif|max:4048'
        ]);

        $today = date('Y-m-d');
        $attendance_date = Carbon::now()->format('Y-m-d');


        $checking_attendance_today = DB::table('employee_attedance')
            ->where('employee_id', $request->employee_id)
            ->whereDate('attedance_date', $today)->exists();


        // HAPUS JAM ABSEN DIBAWAH INI JIKA INGIN MELAKUKAN TESTING
        if ($insertTime >= 8 && $insertTime <= 18) {
            if ($insertTime >= 8  && $insertTime <= 10) {

                if (!$checking_attendance_today) {
                    if ($request->hasFile('surat_sakit')) {
                        $letter = $request->file('surat_sakit');
                        $folderPath = 'surat_sakit/' . $request->employee_id;
                        $imagePath = $letter->storeAs($folderPath, uniqid() . '.' . $letter->getClientOriginalExtension(), 'public');

                        $attendance = EmployeeAttedanceModel::create([
                            'employee_id' => $request->employee_id,
                            'attedance_type' => $request->attedance_type,
                            'reasons' => $request->reasons,
                            'attedance_date' => $request->attedance_date,
                            'surat_sakit' => $imagePath,
                            'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                        ]);

                        if ($attendance) {
                            session()->flash('message_success', 'Data Berhasil disimpan!');
                            return redirect()->route('master_employee_attedance.index');
                        }
                    } else {
                        EmployeeAttedanceModel::create([
                            'employee_id' => $request->employee_id,
                            'attedance_type' => 'hadir',
                            'reasons' => $request->reasons,
                            'attedance_date' => $attendance_date,
                            'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                        ]);
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Berhasil melakukan presensi!'
                        ]);
                    }
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Berhasil melakukan presensi!'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan presensi!'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Presensi sudah lewat!, Presensi dilakukan jam 08.00 s/d 10.00 WIB.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi belum pada jadwalnya!, Presensi dilakukan jam 08.00 WIB.'
            ]);
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

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'surat_sakit' => 'image|mimes:jpeg,png,jpg,gif|max:4048'
        ]);


        if ($insertTime >= 8 && $insertTime <= 18) {
            if ($insertTime >= 8  && $insertTime <= 10) {

                if ($request->hasFile('surat_sakit')) {
                    $letter = $request->file('surat_sakit');
                    $folderPath = 'surat_sakit/' . $request->employee_id;
                    $imagePath = $letter->storeAs($folderPath, uniqid() . '.' . $letter->getClientOriginalExtension(), 'public');


                    DB::table('employee_attedance')->where('id', $request->id)->update([
                        'employee_id' => $request->employee_id,
                        'attedance_type' => $request->attedance_type,
                        'reasons' => $request->reasons,
                        'attedance_date' => $request->attedance_date,
                        'surat_sakit' => $imagePath,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_at' => now()
                    ]);
                } else {

                    DB::table('employee_attedance')->where('id', $request->id)->update([
                        'employee_id' => $request->employee_id,
                        'attedance_type' => $request->attedance_type,
                        'reasons' => $request->reasons,
                        'attedance_date' => $request->attedance_date,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_at' => now()
                    ]);
                }
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_employee_attedance.index');
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Presensi sudah lewat!, Presensi dilakukan jam 08.00 s/d 10.00 WIB.'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Presensi belum pada jadwalnya!, Presensi dilakukan jam 08.00 WIB.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
