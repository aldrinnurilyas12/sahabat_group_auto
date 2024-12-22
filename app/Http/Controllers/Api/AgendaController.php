<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgendaModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Api\MasterMainMenuController;

class AgendaController extends Controller
{

    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index(): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $agenda = DB::table('agenda')->orderBy('created_at', 'DESC')->get();
        return view('layouts.admin_views.agenda.agenda', compact('agenda', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function agenda_layouts(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $branch = DB::table('branch')->get();
        $department = DB::table('department')->get();

        return view('layouts.admin_views.agenda.create.agenda_create', compact('branch', 'department', 'grouped_sub_menu', 'sidebar_menu'));
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
            'department' => 'required',
            'branch' => 'required',
            'agenda_name' => 'required',
            'agenda_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        AgendaModel::create([
            'department' => $request->department,
            'branch' => $request->branch,
            'agenda_name' => $request->agenda_name,
            'agenda_date' => $request->agenda_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
        ]);

        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Agenda berhasil disimpan!');
        return redirect()->route('master_agenda.index');
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

    public function agenda_edit_layouts(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $agenda = DB::table('agenda')->where('id', $request->id)->get();
        $branch = DB::table('branch')->get();
        $department = DB::table('department')->get();

        return view('layouts.admin_views.agenda.edit.agenda_edit', compact('branch', 'agenda', 'department', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'branch' => 'required',
            'agenda_name' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        if ($insertTime >= 7 && $insertTime <= 22) {
            DB::table('agenda')->where('id', $request->id)->update([
                'department' => $request->department,
                'branch' => $request->branch,
                'agenda_name' => $request->agenda_name,
                'agenda_date' => $request->agenda_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Agenda berhasil disimpan!');
            return redirect()->route('master_agenda.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 17.00 wib');
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

        if ($insertTime >= 7 && $insertTime <= 22) {

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
    }
}