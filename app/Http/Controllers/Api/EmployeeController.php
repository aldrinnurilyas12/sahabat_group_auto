<?php

namespace App\Http\Controllers\Api;

use App\Exports\EmployeeExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\EmployeeModel;
use App\Http\Controllers\Controller;
use App\Models\JobPositionModel;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\UsersPicture;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;
use App\Http\Resources\EmployeeResource;
use App\Models\EmployeeBankAccount;
use App\Models\EmployeeSignature;

class EmployeeController extends Controller
{

    // property for sidebar
    protected $MasterMainController;

    public function __construct(MasterMainMenuController $MasterMainMenuController)
    {
        $this->MasterMainMenuController = $MasterMainMenuController;
    }


    public function index(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
        $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->get();
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;
        return view('layouts.admin_views.employee.employee_data', compact('employee', 'employee_resign', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'department', 'departments'));
    }

    public function getEmployee($id = null)
    {
        if ($id) {
            $employee = DB::table('v_employee')->where('id', $id)->first();

            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak tesedia'
                ], 404);
            }
        } else {
            $employee = DB::table('v_employee')->get();
            if (!$employee) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak tesedia'
                ], 404);
            }
        }

        return new EmployeeResource(true, 'Data Karyawan', $employee);
    }

    public function show($id)
    {
        $employee = DB::table('v_employee')->where('id', $id)->first();

        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak tesedia'
            ], 404);
        }
        return new EmployeeResource(true, 'Data Karyawan', $employee);
    }



    /**
     * Show the form for creating a new resource.
     */
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


    public function add_employee_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee = DB::table('v_employee')->get();
        $main_menu = DB::table('v_main_menu')->get();
        $job_position = JobPositionModel::all();
        $branch = DB::table('branch')->get();
        $banks = DB::table('bank')->get();
        return view('layouts.admin_views.employee.create.add_employee', compact('employee', 'banks', 'branch', 'job_position', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function store(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'nik' => 'required|unique:employee',
            'name'  => 'required',
            'address' => 'required',
            'phone_number' => 'required|unique:employee',
            'email' => 'required|unique:employee',
            'job_position' => 'required',
            'branch_id' => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {
            EmployeeModel::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => "+62 " . $request->phone_number,
                'email' => $request->email,
                'job_position' => $request->job_position,
                'branch_id' => $request->branch_id,
                'is_active' => $request->is_active,
                'birth_date' => $request->birth_date,
                'start_date' => $request->start_date,
                'resign_date' => $request->resign_date,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            EmployeeBankAccount::create([
                'nik' => $request->nik,
                'bank_id' => $request->bank_id,
                'bank_account' => $request->bank_account,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_employee.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee.index');
        }
    }


    public function users_export()
    {
        $fileName = 'Data_users' . '.xlsx';

        return Excel::download(new UsersExport, $fileName);
    }


    public function edit(string $id)
    {
        //
    }


    public function filter_employee(Request $request)
    {
        $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
        $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->get();
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;


        if ($offices && $departments) {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('department_name', $departments)->where('location_name', $offices)->get();
            $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->where('department_name', $departments)->where('location_name', $offices)->get();
        }

        if ($offices === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('department_name', $departments)->get();
            $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->where('department_name', $departments)->get();
        }

        if ($departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('location_name', $offices)->get();
            $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->where('location_name', $offices)->get();
        }
        if ($offices === 'alldata' && $departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
            $employee_resign = DB::table('v_employee')->where('is_active', 'Tidak')->get();
        }

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        return view('layouts.admin_views.employee.employee_data', compact('employee', 'employee_resign', 'grouped_sub_menu', 'sidebar_menu', 'office', 'department', 'offices', 'departments'));
    }

    public function employee_export(Request $request)
    {
        $departments = $request->department; // Full month name (e.g., January)
        $offices = $request->office; // Current year (e.g., 2024)

        $fileName = 'Data_Karyawan' . '_' . $offices . '_' . $departments . date('Y') . '.xlsx';

        return Excel::download(new EmployeeExport($departments, $offices), $fileName);
    }



    public function edit_employee_layout(Request $request, String $id): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $emp = EmployeeModel::find($id);
        $start_date = Carbon::parse($emp->start_date);
        $resign_date = Carbon::parse($emp->resign_date);
        $birth_date  = Carbon::parse($emp->birth_date);

        $employee = DB::table('v_employee')->where('id', $request->id)->get();
        $main_menu = DB::table('v_main_menu')->get();
        $job_position = DB::table('job_position')->get();
        $branch = DB::table('branch')->get();
        $banks = DB::table('bank')->get();
        return view('layouts.admin_views.employee.edit.edit_employee', compact('employee', 'banks', 'start_date', 'birth_date', 'resign_date', 'branch', 'job_position', 'main_menu', 'grouped_sub_menu', 'sidebar_menu'));
    }



    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $checkingBankAccount = DB::table('employee_bank_account')->where('nik', $request->nik)->first();

        if ($insertTime >= 7 && $insertTime <= 18) {

            DB::table('employee')->where('id', $request->id)->update([
                'nik' => $request->nik,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => "+62 " . $request->phone_number,
                'email' => $request->email,
                'job_position' => $request->job_position,
                'branch_id' => $request->branch_id,
                'is_active' => $request->is_active,
                'birth_date' => $request->birth_date,
                'start_date' => $request->start_date,
                'resign_date' => $request->resign_date,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);

            if ($checkingBankAccount === null) {
                EmployeeBankAccount::create([
                    'nik' => $request->nik,
                    'bank_id' => $request->bank_id,
                    'bank_account' => $request->bank_account,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            } else {
                DB::table('employee_bank_account')->where('nik', $request->nik)->update([
                    'bank_id' => $request->bank_id,
                    'bank_account' => $request->bank_account,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);
            }

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_employee.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee.index');
        }
    }

    public function user_update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 5 && $insertTime <= 18) {

            DB::table('employee')->where('nik', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik)->update([
                'nik' => $request->nik,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => "+62 " . $request->phone_number,
                'email' => $request->email,
                'birth_date' => $request->birth_date,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil diperbarui!');
            return redirect()->route('profile', ['nik' => auth()->user()->nik]);
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
            return redirect()->route('profile', ['nik' => auth()->user()->nik]);
        }
    }

    public function upload_users_picture(Request $request)
    {
        $request->validate([
            'users_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);


        if ($request->hasFile('users_foto')) {
            $picture = $request->file('users_foto');
            $picturePath = $picture->storeAs('users_foto', uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
            UsersPicture::create([
                'user_id' => $request->user_id,
                'users_foto' => $picturePath,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Foto berhasil diupload!');
        return redirect()->route('profile', ['nik' => auth()->user()->nik]);
    }

    public function update_user_picture(Request $request, $id)
    {
        $request->validate([
            'users_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);

        $picture_id = UsersPicture::find($id);

        if ($request->hasFile('users_foto')) {
            $picture = $request->file('users_foto');
            $picturePath = $picture->storeAs('users_foto', uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
            $update_picture = DB::table('users_picture')->where('user_id', $request->id)->update([
                'users_foto' => $picturePath,
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }

        if ($picture_id->users_foto) {
            $oldPicture = public_path('storage/' . $picture_id->users_foto);
            if (file_exists($oldPicture)) {
                unlink($oldPicture);
            }
        }


        if ($update_picture) {
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Foto berhasil diperbarui!');
            return redirect()->route('profile', ['nik' => auth()->user()->nik]);
        }
    }

    public function upload_employee_signature(Request $request)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signaturePath = $signature->storeAs('employee_signature', uniqid() . '.' . $signature->getClientOriginalExtension(), 'public');

            EmployeeSignature::create([
                'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id,
                'signature' => $signaturePath,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Signature berhasil disimpan!');
        return redirect()->route('profile', ['nik' => auth()->user()->nik]);
    }

    public function update_signature(Request $request, $employee_id)
    {
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);

        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;

        $signatureId = EmployeeSignature::find($employee_id);

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signaturePath = $signature->storeAs('employee_signature', uniqid() . '.' . $signature->getClientOriginalExtension(), 'public');

            DB::table('employee_signature')->where('employee_id', $request->employee_id)->update([
                'employee_id' => app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id,
                'signature' => $signaturePath,
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
        }

        if ($signatureId->signature) {
            $oldsignature = public_path('storage/' . $signatureId->signature);
            if (file_exists($oldsignature)) {
                unlink($oldsignature);
            }
        }

        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('message_success', 'Signature berhasil disimpan!');
        return redirect()->route('profile', ['nik' => auth()->user()->nik]);
    }

    public function delete_signature($employee_id)
    {
        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;
        $emplooyee_sign =  EmployeeSignature::where('employee_id', $employee_id)->first();


        if ($emplooyee_sign) {
            $emplooyee_sign->delete();
            $dropSignature = public_path('storage/' . $emplooyee_sign->signature);
            if (file_exists($dropSignature)) {
                unlink($dropSignature);
            }

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('delete_success', 'Berhasil hapus data!');
            return redirect()->back();
        }
    }


    public function delete_foto($employee_id)
    {
        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->employee_id;
        $users_picture =  UsersPicture::where('user_id', $employee_id)->first();


        if ($users_picture) {
            $users_picture->delete();
            $dropPicture = public_path('storage/' . $users_picture->users_foto);
            if (file_exists($dropPicture)) {
                unlink($dropPicture);
            }

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('delete_success', 'Berhasil hapus data!');
            return redirect()->back();
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeModel $employee_model, $id)
    {
        $employee_model = EmployeeModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($employee_model) {
                $employee_model->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('delete_success', 'Berhasil hapus data!');
                return redirect()->back();
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional  : 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee.index');
        }
    }



    // BUG FIX
    public function profile(Request $request, $nik): View
    {


        if (auth()->check() && auth()->user()->nik  !== $nik) {
            abort(403, 'Ooops unauthorized nik');
        }

        $employee = DB::table('v_employee')->where('nik', $request->nik)->get();
        if ($employee->isEmpty()) {
            abort(403, 'Ooops unauthorized nik');
        }


        $start_date = Carbon::parse($employee->first()->start_date);
        $birth_date  = Carbon::parse($employee->first()->birth_date);

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        // $employee = DB::table('v_employee')->get();
        $main_menu = DB::table('v_main_menu')->get();
        $job_position = JobPositionModel::all();
        $branch = DB::table('branch')->get();
        $user_picture = DB::table('users_picture as up')
            ->select('up.id', 'up.user_id', 'up.users_foto', 'u.nik')
            ->leftJoin('users as u', 'up.user_id', '=', 'u.employee_id')
            ->where('u.nik', $nik)->get();

        $signature_employee = DB::table('employee_signature as se')
            ->select('nik', 'name', 'signature')
            ->leftJoin('employee as e', 'se.employee_id', '=', 'e.id')->where('nik', $nik)->get();
        $user = app('App\Http\Controllers\Api\LoginAdminController')->getUsers();
        return view('layouts.admin_views.employee_profile.edit.edit_profile', compact('employee', 'branch', 'job_position', 'grouped_sub_menu', 'sidebar_menu', 'user', 'start_date', 'birth_date', 'user_picture', 'signature_employee'));
    }

    // RESIGN EMPLOYEE

    public function employee_resign_layout(Request $request, $employee_id): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $emp = EmployeeModel::find($employee_id);
        $start_date = Carbon::parse($emp->start_date);

        $employee = DB::table('v_employee')->where('id', $request->id)->get();
        $main_menu = DB::table('v_main_menu')->get();
        return view('layouts.admin_views.employee.edit.employee_resign', compact('employee', 'start_date', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function resign_approval(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'resign_reasons' => 'required',
            'resign_date'   => 'required'
        ]);

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('employee')->where('id', $request->id)->update([
                'resign_reasons' => $request->resign_reasons,
                'is_active' => $request->is_active,
                'resign_date' => $request->resign_date,
                'updated_at' => now(),
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_employee.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
            return redirect()->route('master_employee.index');
        }
    }
}
