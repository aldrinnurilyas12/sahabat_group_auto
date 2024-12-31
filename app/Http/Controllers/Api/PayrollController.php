<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class PayrollController extends Controller
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

        $payroll_data = DB::table('v_payroll')->get();
        return view('layouts.admin_views.payroll.payroll', compact('payroll_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function payrol_detail_layout($id): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $payroll_detail = DB::table('v_payroll')->where('id', $id)->get();
        return view('layouts.admin_views.payroll.create.payroll_create', compact('payroll_detail', 'grouped_sub_menu', 'sidebar_menu'));
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



    // <!-- bug fixing -->

    public function get_attendance(Request $request, $id)
    {
        // Fetching total revenue for each month
        $attendance = DB::table('v_payroll')
            ->select('total_hadir', 'total_izin', 'total_sakit')
            ->where('id', $id)
            ->get();

        // Mengambil daftar bulan

        $attendance_type = ['Hadir', 'Izin', 'Alpha']; // Menggunakan pluck untuk mendapatkan array

        // Menyiapkan data untuk dikirim ke frontend


        return response()->json([
            'total_hadir' => $attendance->isNotEmpty() ? $attendance : [['total_hadir' => 0]], // Mengambil nilai total_hadir
            'total_izin' => $attendance->isNotEmpty() ? $attendance : [['total_izin' => 0]],   // Mengambil nilai total_izin
            'total_sakit' => $attendance->isNotEmpty() ? $attendance : [['total_sakit' => 0]], // Mengambil nilai total_sakit
            'attendance_type' => $attendance_type
        ]);
    }
}
