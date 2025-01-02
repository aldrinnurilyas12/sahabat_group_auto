<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PayrollApproval;
use App\Models\PayrollModel;
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
        $request->validate([
            'payroll_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);


        if ($request->hasFile('payroll_file')) {
            $picture = $request->file('payroll_file');
            $picturePath = $picture->storeAs('payroll_payment_file', uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
            $sentPayroll = PayrollModel::create([
                'employee_id' => $request->employee_id,
                'status' => 'Menunggu Konfirmasi',
                'payroll_file' => $picturePath,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            if ($sentPayroll) {
                PayrollApproval::create([
                    'payroll_id' => $sentPayroll->id,
                    'approval_by_head_of_finance' => 'pending',
                    'approval_by_head_of_human_resource' => 'pending',
                    'approval_by_head_of_finance' => 'pending'
                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Payroll Berhasil Disimpan!');
            return redirect()->route('master_payroll.index');
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

    public function confirmed_payroll(Request $request, $payroll_id)
    {

        if (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Finance Operation') {
            DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                'payroll_id' => $request->payroll_id,
                'approval_by_head_of_finance' => $request->approval_by_head_of_finance
            ]);
        } elseif (app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name == 'Head of Human Resource') {
            DB::table('payroll_approval')->where('payroll_id', $request->payroll_id)->update([
                'payroll_id' => $request->payroll_id,
                'approval_by_head_of_human_resource' => $request->approval_by_head_of_human_resource
            ]);
        }

        $checking_data_confirmed = DB::table('payroll_approval')->first();


        if ($checking_data_confirmed->approval_by_head_of_finance == 'pending' && $checking_data_confirmed->approval_by_head_of_human_resource == 'pending') {
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_payroll.index');
        } elseif ($checking_data_confirmed->approval_by_head_of_finance == 'pending' && $checking_data_confirmed->approval_by_head_of_human_resource == 'confirmed') {
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_payroll.index');
        } elseif ($checking_data_confirmed->approval_by_head_of_human_resource == 'pending' && $checking_data_confirmed->approval_by_head_of_finance == 'confirmed') {
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_payroll.index');
        } elseif ($checking_data_confirmed->approval_by_head_of_finance == 'confirmed' && $checking_data_confirmed->approval_by_head_of_human_resource == 'confirmed') {
            PayrollModel::where('id', $request->payroll_id)->update([
                'status' => 'Sudah Konfirmasi',
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Payroll berhasil dikonfirmasi!');
        return redirect()->route('master_payroll.index');
    }


    // <!-- bug fixing -->

    public function get_attendance(Request $request, $id)
    {
        // Fetching total revenue for each month
        $attendance = DB::table('v_payroll')
            ->select('total_hadir', 'total_izin', 'total_sakit', 'total_alpha')
            ->where('id', 1)
            ->get();


        $attendance_type = ['Hadir', 'Izin', 'Sakit', 'Alpha']; // Menggunakan pluck untuk mendapatkan array


        return response()->json([
            'total_hadir' => $attendance->isNotEmpty() ? $attendance : [['total_hadir' => 0]], // Mengambil nilai total_hadir
            'total_izin' => $attendance->isNotEmpty() ? $attendance : [['total_izin' => 0]],   // Mengambil nilai total_izin
            'total_sakit' => $attendance->isNotEmpty() ? $attendance : [['total_sakit' => 0]],
            'total_alpha' => $attendance->isNotEmpty() ? $attendance : [['total_alpha' => 0]], // Mengambil nilai total_sakit
            'attendance_type' => $attendance_type
        ]);
    }
}
