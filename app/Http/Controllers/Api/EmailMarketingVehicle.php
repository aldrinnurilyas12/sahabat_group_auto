<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Mail\EmailMarketingVehicle as MailEmailMarketingVehicle;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailMarketing as EmailMarketingModel;

class EmailMarketingVehicle extends Controller
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


    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function email_marketing_vehicle_create(Request $request): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $vehicle_data = DB::table('v_vehicle')->where('id', $request->id)->get();
        return view('layouts.admin_views.vehicle.create.add_marketing_vehicle', compact('vehicle_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'

        ]);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();
        $urlPath = url('/');
        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->requestlink == 'ya') {
                    $send_email =  EmailMarketingModel::create([
                        'vehicle_id' => $request->vehicle_id,
                        'title' => $request->title,
                        'subject' => $request->subject,
                        'description' => $request->description,
                        'link' => $urlPath . '/' . $request->link,
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                } else {
                    $send_email = EmailMarketingModel::create([
                        'vehicle_id' => $request->vehicle_id,
                        'title' => $request->title,
                        'subject' => $request->subject,
                        'description' => $request->description,
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                }
                $this->insertLogActivityUsers(__METHOD__);
                $this->sentEmailMarketingVehicle($send_email);
                session()->flash('message_success', 'Email Marketing Berhasil dikirim!');
                return redirect()->route('email_marketing.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('email_marketing.index');
            }
        } else {
            if ($request->requestlink == 'ya') {
                $send_email =  EmailMarketingModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'title' => $request->title,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'link' => $urlPath . '/' . $request->link,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            } else {
                $send_email = EmailMarketingModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'title' => $request->title,
                    'subject' => $request->subject,
                    'description' => $request->description,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }
            $this->insertLogActivityUsers(__METHOD__);
            $this->sentEmailMarketingVehicle($send_email);
            session()->flash('message_success', 'Email Marketing Berhasil dikirim!');
            return redirect()->route('email_marketing.index');
        }
    }


    public function sentEmailMarketingVehicle(EmailMarketingModel $send_email)
    {
        $all_email_customer = DB::table('v_email_marketing')->get();

        if ($all_email_customer->isEmpty()) {
            return response()->json(['error' => 'No customers found'], 404);
        }

        try {
            foreach ($all_email_customer as $email_customer) {
                Mail::to($email_customer->email)->send(new MailEmailMarketingVehicle($send_email));
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
