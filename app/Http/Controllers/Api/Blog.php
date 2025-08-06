<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\BlogModel;
use Illuminate\View\View;


class Blog extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $blog_data = DB::table('blog')->orderBy('created_at', 'DESC')->get();

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

        return view('layouts.admin_views.blog.blog', compact('blog_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function blog_create_layouts()
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

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

        return view('layouts.admin_views.blog.create.blog_create', compact('grouped_sub_menu', 'sidebar_menu'));
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
            'blog_foto.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
            'title' => 'required',
            'subtitle' => 'required'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('blog_foto')) {
                    foreach ($request->file('blog_foto') as $foto) {
                        $folderPath = $foto->storeAs('blog_foto', uniqid() . '.' . $foto->getClientOriginalExtension(), 'public');
                        BlogModel::create([
                            'title' => $request->title,
                            'subtitle' => $request->subtitle,
                            'blog_foto' => $folderPath,
                            'post_date' => now(),
                            'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                        ]);
                        $this->insertLogActivityUsers(__METHOD__);
                        session()->flash('message_succes', 'Data Berhasil Disimpan!');
                        return redirect()->route('master_blog.index');
                    }
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_blog.index');
            }
        } else {
            if ($request->hasFile('blog_foto')) {
                foreach ($request->file('blog_foto') as $foto) {
                    $folderPath = $foto->storeAs('blog_foto', uniqid() . '.' . $foto->getClientOriginalExtension(), 'public');
                    BlogModel::create([
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'blog_foto' => $folderPath,
                        'post_date' => now(),
                        'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_succes', 'Data Berhasil Disimpan!');
                    return redirect()->route('master_blog.index');
                }
            }
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


    public function edit_blog_layouts(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $blog_data = DB::table('blog')->where('id', $request->id)->get();

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

        return view('layouts.admin_views.blog.edit.edit_blog', compact('blog_data', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required'
        ]);

        $blogfoto = BlogModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($request->hasFile('blog_foto')) {
                    foreach ($request->file('blog_foto') as $foto) {
                        $folderPath = $foto->storeAs('blog_foto', uniqid() . '.' . $foto->getClientOriginalExtension(), 'public');
                        DB::table('blog')->where('id', $request->id)->update([
                            'title' => $request->title,
                            'subtitle' => $request->subtitle,
                            'blog_foto' => $folderPath,
                            'updated_at'  => now(),
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                        ]);
                    }

                    if ($blogfoto->blog_foto) {
                        $oldPicture = public_path('storage/' . $blogfoto->blog_foto);
                        if (file_exists($oldPicture)) {
                            unlink($oldPicture);
                        }
                    }
                } elseif (!$request->hasFile('blog_foto')) {
                    $blogfotoOld = DB::table('blog')
                        ->where('id', $id)
                        ->value('blog_foto');

                    DB::table('blog')->where('id', $request->id)->update([
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'blog_foto' => $blogfotoOld,
                        'updated_at'  => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_blog.index');
            }
        } else {
            if ($request->hasFile('blog_foto')) {
                foreach ($request->file('blog_foto') as $foto) {
                    $folderPath = $foto->storeAs('blog_foto', uniqid() . '.' . $foto->getClientOriginalExtension(), 'public');
                    DB::table('blog')->where('id', $request->id)->update([
                        'title' => $request->title,
                        'subtitle' => $request->subtitle,
                        'blog_foto' => $folderPath,
                        'updated_at'  => now(),
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                    ]);
                }

                if ($blogfoto->blog_foto) {
                    $oldPicture = public_path('storage/' . $blogfoto->blog_foto);
                    if (file_exists($oldPicture)) {
                        unlink($oldPicture);
                    }
                }
            } elseif (!$request->hasFile('blog_foto')) {
                $blogfotoOld = DB::table('blog')
                    ->where('id', $id)
                    ->value('blog_foto');

                DB::table('blog')->where('id', $request->id)->update([
                    'title' => $request->title,
                    'subtitle' => $request->subtitle,
                    'blog_foto' => $blogfotoOld,
                    'updated_at'  => now(),
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }
        }


        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Data Berhasil diperbarui!');
        return redirect()->route('master_blog.index');
    }


    public function destroy(string $id)
    {
        $blog = BlogModel::find($id);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($blog) {
                    $blog->delete();
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('message_success', 'Data Berhasil dihapus!');
                    return redirect()->route('master_blog.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
                return redirect()->route('master_blog.index');
            }
        } else {
            if ($blog) {
                $blog->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_blog.index');
            }
        }
    }
}
