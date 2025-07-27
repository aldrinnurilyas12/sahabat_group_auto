<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\EmployeeModel;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('layouts.admin_views.edit', [
            'user' => $request->user(),
        ]);
    }


    // public function users_create_layout(): View
    // {

    //     // $sidebar_menu = DB::table('main_menu')->where('location', 'admin')->get();
    //     // $sub_menu = DB::table('submenu')->get();
    //     // $grouped_sub_menu = $sub_menu->groupBy('parent_id');
    //     $roles = RoleModel::all();
    //     $employees = DB::table('employee')
    //         // ->select('employee.id', 'employee.nik', 'name', 'users.is_active')
    //         // ->leftJoin('users', 'employee.id', '=', 'users.employee_id')
    //         // ->where('users.is_active', null)
    //         ->get();
    //     return view('layouts.admin_views.users_admin.create.users_create', compact('roles', 'employees'));
    // }

    // public function store(Request $request)
    // {

    //     $validate = $request->validate([
    //         'nik' => 'required|max:6|unique:users',
    //         'employee_id' => 'unique:users'
    //     ]);


    //     $user = User::create([
    //         'employee_id' => $request->employee_id,
    //         'nik' => $validate['nik'],
    //         'is_active' => $request->is_active,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role,
    //         'updated_by' => 'aldrin',
    //         'created_by' => 'aldrin'

    //     ]);

    //     // if ($user) {
    //     //     return redirect()->route('master_users.index');
    //     // } else {
    //     //     return back()->withErrors(['error' => 'User could not be created.']);
    //     // }
    // }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}