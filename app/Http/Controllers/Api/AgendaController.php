<?php

namespace App\Http\Controllers\Api;

use App\Exports\AgendaExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\AgendaGuestsModel;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AgendaController extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;

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


        $agenda = DB::table('v_agenda as va')
            ->select(
                'va.id',
                'va.department_name',
                'va.branch',
                'va.meeting_leader',
                've.name',
                'va.agenda_name',
                'va.agenda_date',
                'va.start_time',
                'va.status',
                'va.reasons',
                'va.end_time',
                'va.created_at',
                'va.created_by',
                'va.updated_by',
                'va.updated_at'
            )
            ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
            ->orderBy('created_at', 'DESC')->get();
        $disallowedData = DB::table('users_privilege')
            ->where('disallowed', '<>', '')
            ->distinct()
            ->pluck('disallowed')
            ->flatMap(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->toArray();

        $disallowedRoles = in_array(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id, $disallowedData);

        if ($disallowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.agenda.agenda', compact('agenda', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'bulan', 'tahun', 'months', 'years', 'department', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function agenda_layouts()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();

        $meeting_leader = DB::table('v_employee')->get();
        $disallowedData = DB::table('users_privilege')
            ->where('disallowed', '<>', '')
            ->distinct()
            ->pluck('disallowed')
            ->flatMap(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->toArray();

        $disallowedRoles = in_array(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id, $disallowedData);

        if ($disallowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.agenda.create.agenda_create', compact('branch', 'employee', 'department', 'meeting_leader', 'grouped_sub_menu', 'sidebar_menu'));
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
        $request->validate([
            'employee_id' => 'required|array',
            'employee_id.*' => 'integer',
            'meeting_leader' => 'required',
            'agenda_name' => 'required',
            'agenda_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                $agenda = AgendaModel::create([
                    'department' => $request->department,
                    'branch' => $request->branch,
                    'meeting_leader' => $request->meeting_leader,
                    'agenda_name' => $request->agenda_name,
                    'agenda_date' => $request->agenda_date,
                    'status' => 'scheduled',
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);

                $agendaId = $agenda->latest()->first()->id;
                $guests_list = [];
                foreach ($request->employee_id as $emp_id) {
                    $guests_list[] = [
                        'employee_id' => $emp_id,
                        'agenda_id' => $agendaId,
                        'status' => null
                    ];
                }

                $AgendaGuestList = AgendaGuestsModel::insert($guests_list);

                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Agenda berhasil disimpan!');
                return redirect()->route('master_agenda.index');
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_blog.index');
            }
        } else {
            $agenda =  AgendaModel::create([
                'department' => $request->department,
                'branch' => $request->branch,
                'meeting_leader' => $request->meeting_leader,
                'agenda_name' => $request->agenda_name,
                'agenda_date' => $request->agenda_date,
                'status' => 'scheduled',
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            $agendaId = $agenda->latest()->first()->id;
            $guests_list = [];
            foreach ($request->employee_id as $emp_id) {
                $guests_list[] = [
                    'employee_id' => $emp_id,
                    'agenda_id' => $agendaId,
                    'status' => null
                ];
            }

            $AgendaGuestList = AgendaGuestsModel::insert($guests_list);

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Agenda berhasil disimpan!');
            return redirect()->route('master_agenda.index');
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

    public function agenda_edit_layouts(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $agenda = DB::table('v_agenda')->where('id', $request->id)->get();
        $branch = DB::table('branch')->get();
        $department = DB::table('department')->get();

        $meeting_leader = DB::table('v_employee')->get();

        $find_agenda = AgendaModel::find($request->id);
        $agendas_date = Carbon::parse($find_agenda->agenda_date);
        $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();

        $disallowedData = DB::table('users_privilege')
            ->where('disallowed', '<>', '')
            ->distinct()
            ->pluck('disallowed')
            ->flatMap(function ($item) {
                return array_map('trim', explode(',', $item));
            })
            ->toArray();

        $disallowedRoles = in_array(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id, $disallowedData);

        if ($disallowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.agenda.edit.agenda_edit', compact('branch', 'agenda', 'employee', 'department', 'meeting_leader', 'agendas_date', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'agenda_name' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                DB::table('agenda')->where('id', $request->id)->update([
                    'department' => $request->department,
                    'branch' => $request->branch,
                    'meeting_leader' => $request->meeting_leader,
                    'agenda_name' => $request->agenda_name,
                    'agenda_date' => $request->agenda_date,
                    'reasons' => $request->reasons,
                    'start_time' => $request->start_time,
                    'end_time' => $request->end_time,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);


                // NOTE PERBAIKI JIKA DATA EMPLOYEE_ID SUDAB ADA DI TABLE JANGAN DIMASUKAN LAGI
                $agendaId = $request->agenda_id;
                $checkEmployeeId = AgendaGuestsModel::where('agenda_id', $agendaId)
                    ->pluck('employee_id')
                    ->toArray();

                $guests_list = [];
                foreach ($request->employee_id as $emp_id) {
                    if (!in_array($emp_id, $checkEmployeeId)) {
                        $guests_list[] = [
                            'employee_id' => $emp_id,
                            'agenda_id' => $agendaId,
                            'status' => null
                        ];
                    }
                }

                if (!empty($guests_list)) {
                    $AgendaGuestList = AgendaGuestsModel::insert($guests_list);
                }


                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Agenda berhasil disimpan!');
                return redirect()->route('master_agenda.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 17.00 wib');
                return redirect()->route('master_agenda.index');
            }
        } else {
            DB::table('agenda')->where('id', $request->id)->update([
                'department' => $request->department,
                'branch' => $request->branch,
                'meeting_leader' => $request->meeting_leader,
                'agenda_name' => $request->agenda_name,
                'agenda_date' => $request->agenda_date,
                'reasons' => $request->reasons,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);


            $agendaId = $request->agenda_id;
            $checkEmployeeId = AgendaGuestsModel::where('agenda_id', $agendaId)
                ->pluck('employee_id')
                ->toArray();

            $guests_list = [];
            foreach ($request->employee_id as $emp_id) {
                if (!in_array($emp_id, $checkEmployeeId)) {
                    $guests_list[] = [
                        'employee_id' => $emp_id,
                        'agenda_id' => $agendaId,
                        'status' => null
                    ];
                }
            }

            if (!empty($guests_list)) {
                $AgendaGuestList = AgendaGuestsModel::insert($guests_list);
            }


            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Agenda berhasil disimpan!');
            return redirect()->route('master_agenda.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = AgendaModel::find($id);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($agenda) {
                    $agenda->delete();
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil dihapus!');
                    return redirect()->route('master_agenda.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_agenda.index');
            }
        } else {
            if ($agenda) {
                $agenda->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_agenda.index');
            }
        }
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'status' => 'required'

        ]);

        AgendaModel::where('id', $request->id)->update([
            'status' => $request->status
        ]);
        session()->flash('message_success', 'Agenda berhasil diperbarui!');
        return redirect()->route('master_agenda.index');
    }

    public function filter_agenda(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;
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

        $agenda = DB::table('v_agenda as va')
            ->select(
                'va.id',
                'va.department_name',
                'va.branch',
                'va.meeting_leader',
                've.name',
                'va.agenda_name',
                'va.agenda_date',
                'va.start_time',
                'va.status',
                'va.end_time',
                'va.created_at',
                'va.created_by',
                'va.updated_by',
                'va.updated_at'
            )
            ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
            ->orderBy('created_at', 'DESC')->get();

        if ($offices && $bulan && $tahun) {
            $agenda = DB::table('v_agenda as va')
                ->select(
                    'va.id',
                    'va.department_name',
                    'va.branch',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->where('location_name', $offices)->whereRaw('MONTH(agenda_date) = ?', [$bulan])
                ->whereRaw('YEAR(agenda_date) = ?', [$tahun])
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        }

        if ($offices === 'alldata' && $bulan === 'alldata' && $tahun === 'alldata') {
            $agenda = DB::table('v_agenda as va')
                ->select(
                    'va.id',
                    'va.department_name',
                    'va.branch',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        }

        return view('layouts.admin_views.agenda.agenda', compact('agenda', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'bulan', 'tahun', 'months', 'years', 'department', 'departments'));
    }


    public function download_agenda_pdf(Request $request)
    {
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;
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

        $agenda = DB::table('v_agenda as va')
            ->select(
                'va.id',
                'va.department_name',
                'va.branch',
                'va.meeting_leader',
                've.name',
                'va.agenda_name',
                'va.agenda_date',
                'va.reasons',
                'va.start_time',
                'va.status',
                'va.end_time',
                'va.created_at',
                'va.created_by',
                'va.updated_by',
                'va.updated_at'
            )
            ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
            ->orderBy('created_at', 'DESC')->get();

        if ($offices && $bulan && $tahun) {
            $agenda = DB::table('v_agenda as va')
                ->select(
                    'va.id',
                    'va.department_name',
                    'va.branch',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->where('location_name', $offices)->whereRaw('MONTH(agenda_date) = ?', [$bulan])
                ->whereRaw('YEAR(agenda_date) = ?', [$tahun])
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        }

        if ($offices === 'alldata' && $bulan === 'alldata' && $tahun === 'alldata') {
            $agenda = DB::table('v_agenda as va')
                ->select(
                    'va.id',
                    'va.department_name',
                    'va.branch',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        }


        // Nama file PDF
        $fileName = 'Data_agenda_' . $offices . '-' . $bulan . '-' . $tahun . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('layouts.pdf.agenda_pdf', [
            'agenda' => $agenda,
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }

    public function download_agenda_excel(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $offices = $request->office;
        $fileName = 'Agenda_data_' . '-' . $offices . '-' . $bulan .  '-' . $tahun . '.xlsx';
        return Excel::download(new AgendaExport($offices, $bulan, $tahun), $fileName);
    }
}
