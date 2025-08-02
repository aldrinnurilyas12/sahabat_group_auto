<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BannerModel;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterBanner extends Controller
{


    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }

    public function index()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $banner_data = DB::table('banner_landingpage')->get();

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.banner.banner', compact('banner_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_banner_layout()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.banner.create.banner_create', compact('grouped_sub_menu', 'sidebar_menu'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_name' => 'required|string|max:255',
            'banner_file' => 'required|image|mimes:jpg,jpeg,png|max:5048'
        ]);

        if ($request->hasFile('banner_file')) {
            $file = $request->file('banner_file');
            $bannerFile = $file->storeAs('banner_file', uniqid() . '.' . $file->getClientOriginalExtension(), 'public');
            BannerModel::create([
                'banner_name' => $request->banner_name,
                'banner_file' => $bannerFile,
                'banner_title' => $request->banner_title,
                'text_content' => $request->text_content,
                'is_active' => 'Y',
                'button_1' => $request->button_1,
                'button_2' => $request->button_2,
                'link_1' => $request->link_1,
                'link_2' => $request->link_2,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Berhasil disimpan!');
        return redirect()->route('master_banner.index');
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

    public function edit_banner_layout(Request $request, $id): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $banner_data = DB::table('banner_landingpage')->where('id', $request->id)->get();

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.banner.edit.banner_edit', compact('banner_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'banner_name' => 'required|string|max:255',
            'banner_file' => 'image|mimes:jpg,jpeg,png|max:5048'
        ]);

        $picture_id = DB::table('banner_landingpage')->where('id', $request->id)->first();

        if ($request->hasFile('banner_file')) {
            $file = $request->file('banner_file');
            $bannerFile = $file->storeAs('banner_file', uniqid() . '.' . $file->getClientOriginalExtension(), 'public');
            BannerModel::where('id', $request->id)->update([
                'banner_name' => $request->banner_name,
                'banner_file' => $bannerFile,
                'banner_title' => $request->banner_title,
                'text_content' => $request->text_content,
                'is_active' => $request->is_active,
                'button_1' => $request->button_1,
                'button_2' => $request->button_2,
                'link_1' => $request->link_1,
                'link_2' => $request->link_2,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            if ($picture_id->banner_file) {
                $oldPicture = public_path('storage/' . $picture_id->banner_file);
                if (file_exists($oldPicture)) {
                    unlink($oldPicture);
                }
            }
        } else {
            BannerModel::where('id', $request->id)->update([
                'banner_name' => $request->banner_name,
                'banner_title' => $request->banner_title,
                'text_content' => $request->text_content,
                'is_active' => $request->is_active,
                'button_1' => $request->button_1,
                'button_2' => $request->button_2,
                'link_1' => $request->link_1,
                'link_2' => $request->link_2,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Berhasil disimpan!');
        return redirect()->route('master_banner.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = BannerModel::find($id);

        if ($banner) {

            $dropPicture = public_path('storage/' . $banner->banner_file);
            if (file_exists($dropPicture)) {
                unlink($dropPicture);
            }
            BannerModel::destroy($id);
        }

        session()->flash('message_success', 'Data Berhasil dihapus!');
        return redirect()->back();
    }
}
