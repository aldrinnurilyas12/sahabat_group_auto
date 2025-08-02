<?php

namespace App\Http\Controllers\Api;

use App\Exports\EticketExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\EticketModel;
use Ramsey\Uuid\Uuid;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class EticketingController extends Controller
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


    public function index(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $eticket_data = DB::table('v_eticket')->where('employee_id', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id)->orderBy('created_at', 'DESC')->get();
        return view('layouts.admin_views.eticketing.eticket', compact('eticket_data', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_eticket_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $eticket_category = DB::table('v_eticket_category')->where('menu_name', '<>', 'IT Monitoring')->get();
        return view('layouts.admin_views.eticketing.create.eticket_create', compact('eticket_category', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit_eticket_layouts(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $eticket_category = DB::table('v_eticket_category')->where('menu_name', '<>', 'IT Monitoring')->get();
        $eticket_data = DB::table('v_eticket')->where('eticket_code', $request->eticket_code)->get();
        return view('layouts.admin_views.eticketing.edit.eticket_edit', compact('eticket_category', 'eticket_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'attachment_files' => 'image|mimes:jpeg,png,jpg,gif|max:4048',
            'eticket_category' => 'required',
            'title' => 'required',
            'main_issue' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime <= 15) {
                if ($request->hasFile('attachment_files')) {
                    $attachment_files = $request->file('attachment_files');
                    $attachmentPath = $attachment_files->storeAs('eticket_attachment', uniqid() . '.' . $attachment_files->getClientOriginalExtension(), 'public');
                    EticketModel::create([
                        'eticket_code' => date('Ymd') . '-' . substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 12),
                        'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id,
                        'eticket_category' => $request->eticket_category,
                        'title' => $request->title,
                        'status' => 'menunggu konfirmasi',
                        'main_issue' => $request->main_issue,
                        'attachment_files' => $attachmentPath,
                        'approval_by_it' => 'menunggu konfirmasi',
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                    ]);
                } else {
                    EticketModel::create([
                        'eticket_code' => date('Ymd') . '-' . substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 12),
                        'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id,
                        'eticket_category' => $request->eticket_category,
                        'title' => $request->title,
                        'status' => 'menunggu konfirmasi',
                        'main_issue' => $request->main_issue,
                        'approval_by_it' => 'menunggu konfirmasi',
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                    ]);
                }
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_eticket.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan E-Ticket: 08.00 wib - 15.00 wib');
                return redirect()->route('master_eticket.index');
            }
        } else {
            if ($request->hasFile('attachment_files')) {
                $attachment_files = $request->file('attachment_files');
                $attachmentPath = $attachment_files->storeAs('eticket_attachment', uniqid() . '.' . $attachment_files->getClientOriginalExtension(), 'public');
                EticketModel::create([
                    'eticket_code' => date('Ymd') . '-' . substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 12),
                    'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id,
                    'eticket_category' => $request->eticket_category,
                    'title' => $request->title,
                    'status' => 'menunggu konfirmasi',
                    'main_issue' => $request->main_issue,
                    'attachment_files' => $attachmentPath,
                    'approval_by_it' => 'menunggu konfirmasi',
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);
            } else {
                EticketModel::create([
                    'eticket_code' => date('Ymd') . '-' . substr(str_replace('-', '', Uuid::uuid4()->toString()), 0, 12),
                    'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id,
                    'eticket_category' => $request->eticket_category,
                    'title' => $request->title,
                    'status' => 'menunggu konfirmasi',
                    'main_issue' => $request->main_issue,
                    'approval_by_it' => 'menunggu konfirmasi',
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_eticket.index');
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
    public function update(Request $request)
    {
        $request->validate([
            // 'attachment_files' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
            'eticket_category' => 'required',
            'title' => 'required',
            'main_issue' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        if ($insertTime >= 7 && $insertTime <= 20) {

            DB::table('eticket')->where('eticket_code', $request->eticket_code)->update([
                'eticket_category' => $request->eticket_category,
                'title' => $request->title,
                'main_issue' => $request->main_issue,
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_eticket.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_eticket.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // FOR ROLE IT
    public function it_eticketing_layouts(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $eticket_data = DB::table('v_eticket')->orderBy('created_at', 'DESC')->get();
        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.eticketing.it_monitoring.eticket_it', compact('eticket_data', 'grouped_sub_menu', 'sidebar_menu', 'months', 'years', 'bulan', 'tahun'));
    }

    public function confirmed_eticket_it(Request $request)
    {
        $IT_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime <= 8 && $insertTime >= 18) {
                if ($IT_ROLE) {
                    DB::table('eticket')->where('eticket_code', $request->eticket_code)->update([
                        'scheduled' => $request->scheduled,
                        'approval_by_it' => $request->approval_by_it,
                        'status' => $request->status,
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil disimpan!');
                    return redirect()->route('master_it_eticketing');
                } else {
                    session()->flash('failed_insert', 'Anda tidak bisa konfirmasi layanan ini.');
                    return redirect()->route('master_it_eticketing');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_eticket.index');
            }
        } else {
            if ($IT_ROLE) {
                DB::table('eticket')->where('eticket_code', $request->eticket_code)->update([
                    'scheduled' => $request->scheduled,
                    'approval_by_it' => $request->approval_by_it,
                    'status' => $request->status,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_it_eticketing');
            } else {
                session()->flash('failed_insert', 'Anda tidak bisa konfirmasi layanan ini.');
                return redirect()->route('master_it_eticketing');
            }
        }
    }

    public function confirmed_eticket_it_done(Request $request)
    {
        $IT_ROLE = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->department_name == 'Information Technology';
        date_default_timezone_set('Asia/Jakarta');
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime <= 8 && $insertTime >= 18) {
                if ($IT_ROLE) {
                    DB::table('eticket')->where('eticket_code', $request->eticket_code)->update([
                        'status' => $request->status,
                        'task_complete_date' => $request->task_complete_date,
                        'updated_at' => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil disimpan!');
                    return redirect()->route('master_it_eticketing');
                } else {
                    session()->flash('failed_insert', 'Anda tidak bisa konfirmasi layanan ini.');
                    return redirect()->route('master_it_eticketing');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_eticket.index');
            }
        } else {
            if ($IT_ROLE) {
                DB::table('eticket')->where('eticket_code', $request->eticket_code)->update([
                    'status' => $request->status,
                    'task_complete_date' => $request->task_complete_date,
                    'updated_at' => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_it_eticketing');
            } else {
                session()->flash('failed_insert', 'Anda tidak bisa konfirmasi layanan ini.');
                return redirect()->route('master_it_eticketing');
            }
        }
    }

    // FOR USERS
    public function eticket_detail_layouts(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $eticket_data = DB::table('v_eticket')->where('eticket_code', $request->eticket_code)->get();
        return view('layouts.admin_views.eticketing.eticket_detail', compact('eticket_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function filter_eticket(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $eticket_data = DB::table('v_eticket')->get();
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }


        if ($bulan && $tahun) {
            $eticket_data = DB::table('v_eticket')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])->get();
        }

        if ($bulan === 'alldata' && $tahun === 'alldata') {
            $eticket_data = DB::table('v_eticket')->get();
        }


        return view('layouts.admin_views.eticketing.it_monitoring.eticket_it', compact('eticket_data', 'grouped_sub_menu', 'sidebar_menu', 'bulan', 'tahun', 'months', 'years'));
    }

    public function download_excel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $fileName = 'Data_Eticket_' . '-' . $bulan . '-' . $tahun . '.xlsx';

        return Excel::download(new EticketExport($bulan, $tahun), $fileName);
    }

    public function download_pdf(Request $request)
    {
        $year = date('Y');
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $eticket_data = DB::table('v_eticket')->get();

        if ($bulan && $tahun) {
            $eticket_data = DB::table('v_eticket')
                ->whereRaw('MONTH(created_at) = ?', [$bulan])
                ->whereRaw('YEAR(created_at) = ?', [$tahun])->get();
        }

        if ($bulan === 'alldata' && $tahun === 'alldata') {
            $eticket_data = DB::table('v_eticket')->get();
        }


        $fileName = 'Data_Eticket_' . $bulan . '_' . $year . '.pdf';
        $pdf = Pdf::loadView('layouts.pdf.eticket_pdf', [
            'eticket_data' => $eticket_data
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }
}
