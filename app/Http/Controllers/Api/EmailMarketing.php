<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmailMarketing as EmailMarketingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailMarketing;

class EmailMarketing extends Controller
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



    public function index()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $email_marketing = DB::table('email_marketing')->get();
        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.email_marketing.email_marketing', compact('email_marketing', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function email_create()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $email_marketing = DB::table('v_email_marketing')->get();
        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }
        return view('layouts.admin_views.email_marketing.create.email_create', compact('email_marketing', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'media_files' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048'

        ]);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('media_files')) {
                    $emailFile = $request->file('media_files');
                    $emailFilePath = $emailFile->storeAs('email_marketing_files', uniqid() . '.' . $emailFile->getClientOriginalExtension(), 'public');
                    $send_email = EmailMarketingModel::create([
                        'title' => $request->title,
                        'subject' => $request->subject,
                        'description' => $request->description,
                        'media_files' => $emailFilePath,
                        'link' => $request->link,
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                    $this->sentEmailMarketing($send_email);
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Email Marketing Berhasil dikirim!');
                    return redirect()->route('email_marketing.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('email_marketing.index');
            }
        } else {
            if ($request->hasFile('media_files')) {
                $emailFile = $request->file('media_files');
                $emailFilePath = $emailFile->storeAs('email_marketing_files', uniqid() . '.' . $emailFile->getClientOriginalExtension(), 'public');
                $send_email = EmailMarketingModel::create([
                    'title' => $request->title,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'media_files' => $emailFilePath,
                    'link' => $request->link,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->sentEmailMarketing($send_email);
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Email Marketing Berhasil dikirim!');
                return redirect()->route('email_marketing.index');
            }
        }
    }

    public function sentEmailMarketing(EmailMarketingModel $send_email)
    {
        $all_email_customer = DB::table('v_email_marketing')->get();

        if ($all_email_customer->isEmpty()) {
            return response()->json(['error' => 'No customers found'], 404);
        }

        try {
            foreach ($all_email_customer as $email_customer) {
                Mail::to($email_customer->email)->send(new SendEmailMarketing($send_email));
            }
            return response()->json(['message' => 'email successs'], 200);
        } catch (\Exception $e) {
            \Log::error('Email Sending Failed : ' . $e->getMessage());
            return response()->json(['error' => 'Failed_send_email'], 500);
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
}
