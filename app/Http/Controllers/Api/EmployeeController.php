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
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Array_;
use App\Http\Resources\EmployeeResource;
use App\Models\EmployeeBankAccount;
use App\Models\EmployeeResignModel;
use App\Models\EmployeeSignature;
use App\Models\EmployeeTypePosition;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\EpsImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Barryvdh\DomPDF\Facade\Pdf;


// use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EmployeeController extends Controller
{

    // property for sidebar
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
        $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
        $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->get();
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;

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
        return view('layouts.admin_views.employee.employee_data', compact('employee', 'employee_resign', 'grouped_sub_menu', 'sidebar_menu', 'office', 'offices', 'department', 'departments'));
    }

    // public function getEmployee($id = null)
    // {
    //     if ($id) {
    //         $employee = DB::table('v_employee')->where('id', $id)->first();

    //         if (!$employee) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Data tidak tesedia'
    //             ], 404);
    //         }
    //     } else {
    //         $employee = DB::table('v_employee')->get();
    //         if (!$employee) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Data tidak tesedia'
    //             ], 404);
    //         }
    //     }

    //     return new EmployeeResource(true, 'Data Karyawan', $employee);
    // }

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
        $job_level_position = DB::table('job_level_position')->get();
        $branch = DB::table('branch')->get();
        $banks = DB::table('bank')->get();
        return view('layouts.admin_views.employee.create.add_employee', compact('employee', 'banks', 'branch', 'job_position', 'job_level_position', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function store(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        $request->validate([
            'nik' => 'required|max:16|unique:employee',
            'name'  => 'required',
            'address' => 'required',
            'phone_number' => 'required|unique:employee',
            'email' => 'required|unique:employee',
            'job_position' => 'required',
            'branch_id' => 'required'
        ]);
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        $checking_email_available = DB::table('employee')->where('email', $request->email)->first();
        $cheking_phone_number_available = DB::table('employee')->where('phone_number', "+62 " . $request->phone_number)->first();

        // code for QR CODE Employee

        $location_name = DB::table('branch')->select('location_name')->where('id', $request->branch_id)->first();
        $position = DB::table('job_position')->select('position_name')->where('id', $request->job_position)->first();

        $employee_data_qr_code  = [
            'nik' => $request->nik,
            'name' => $request->name,
            'job_position' => $position->position_name,
            'branch' => $location_name->location_name
        ];

        // dd($employee_data_qr_code);

        $folderPath = public_path('employee_qrcode');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        $qrCodePath = 'employee_qrcode/' . $request->nik . '.svg';
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svgOutput = $writer->writeString(json_encode($employee_data_qr_code));

        Storage::disk('public')->put('employee_qrcode/' . $request->nik . '.svg', $svgOutput);



        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                $employee = EmployeeModel::create([
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone_number' => "+62 " . $request->phone_number,
                    'email' => $request->email,
                    'job_position' => $request->job_position,
                    'job_level_position' => $request->job_level_position,
                    'branch_id' => $request->branch_id,
                    'is_active' => 'Y',
                    'birth_date' => $request->birth_date,
                    'start_date' => $request->start_date,
                    'qr_code_path' => $qrCodePath,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);

                EmployeeTypePosition::create([
                    'employee_id' => $employee->latest()->first()->id,
                    'type_of_employee' => $request->type_of_employee,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date
                ]);

                EmployeeBankAccount::create([
                    'nik' => $request->nik,
                    'bank_id' => $request->bank_id,
                    'bank_account' => $request->bank_account,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

                ]);

                if ($checking_email_available && $cheking_phone_number_available) {
                    session()->flash('failed_insert', 'Email sudah terdaftar, silahkan gunakan email lain!');
                    return redirect()->back();
                }

                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil disimpan!');
                return redirect()->route('master_employee.index');
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
                return redirect()->route('master_employee.index');
            }
        } else {
            $employee =  EmployeeModel::create([
                'nik' => $request->nik,
                'name' => $request->name,
                'address' => $request->address,
                'phone_number' => "+62 " . $request->phone_number,
                'email' => $request->email,
                'job_position' => $request->job_position,
                'job_level_position' => $request->job_level_position,
                'branch_id' => $request->branch_id,
                'is_active' => 'Y',
                'birth_date' => $request->birth_date,
                'start_date' => $request->start_date,
                'qr_code_path' => $qrCodePath,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            ]);

            EmployeeTypePosition::create([
                'employee_id' => $employee->latest()->first()->id,
                'type_of_employee' => $request->type_of_employee,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            EmployeeBankAccount::create([
                'nik' => $request->nik,
                'bank_id' => $request->bank_id,
                'bank_account' => $request->bank_account,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);

            if ($checking_email_available && $cheking_phone_number_available) {
                session()->flash('failed_insert', 'Email sudah terdaftar, silahkan gunakan email lain!');
                return redirect()->back();
            }

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
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
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('department_name', $departments)->where('location_name', $offices)->get();
        }

        if ($offices === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('department_name', $departments)->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('department_name', $departments)->get();
        }

        if ($departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('location_name', $offices)->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('location_name', $offices)->get();
        }
        if ($offices === 'alldata' && $departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->get();
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


    public function download_employee_pdf(Request $request)
    {
        $employee = DB::table('v_employee')->where('is_active', 'Ya');
        $office = DB::table('branch')->get();
        $department = DB::table('department')->get();
        $offices = $request->office;
        $departments = $request->department;


        if ($offices && $departments) {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('department_name', $departments)->where('location_name', $offices)->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('department_name', $departments)->where('location_name', $offices)->get();
        }

        if ($offices === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('department_name', $departments)->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('department_name', $departments)->get();
        }

        if ($departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->where('location_name', $offices)->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->where('location_name', $offices)->get();
        }
        if ($offices === 'alldata' && $departments === 'alldata') {
            $employee = DB::table('v_employee')->where('is_active', 'Ya')->get();
            $employee_resign = DB::table('v_employee_resign')->where('resign_status', 'sudah konfirmasi')->get();
        }

        // Nama file PDF
        $fileName = 'Data_Karyawan_' . $offices . '_' . $departments . '.pdf';

        // Generate PDF
        $pdf = Pdf::loadView('layouts.pdf.employee_pdf', [
            'employee' => $employee,
        ]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }



    public function edit_employee_layout(Request $request, String $nik)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $user = app('App\Http\Controllers\Api\LoginAdminController')->getUsers();

        $allowed_positions = ['Human Resource Staff', 'Head of Human Resource'];
        $HR_SESSION = in_array($user->position_name, $allowed_positions);
        $USER_LOGIN = $user->nik;
        $EMPLOYEE_LOGIN = auth()->user()->nik;

        if (!$HR_SESSION && $nik !== $EMPLOYEE_LOGIN) {
            session()->flash('failed_insert', 'Akses ditolak!');
            return redirect()->back();
        }

        $emp = DB::table('v_employee')->where('nik', $nik)->first();
        if ($emp == null) {
            abort(404, 'Data Not Found');
        }

        $start_date = Carbon::parse($emp->start_date);
        $resign_date = Carbon::parse($emp->resign_date);
        $birth_date  = Carbon::parse($emp->birth_date);
        $end_date = Carbon::parse($emp->end_date);

        $employee = DB::table('v_employee')->where('nik', $request->nik)->get();
        $main_menu = DB::table('v_main_menu')->get();
        $job_position = DB::table('job_position')->get();
        $job_level_position = DB::table('job_level_position')->get();
        $branch = DB::table('branch')->get();
        $banks = DB::table('bank')->get();

        return view('layouts.admin_views.employee.edit.edit_employee', compact('employee', 'banks', 'start_date', 'end_date', 'birth_date', 'resign_date', 'branch', 'job_position', 'job_level_position', 'main_menu', 'grouped_sub_menu', 'sidebar_menu'));
    }



    public function update(Request $request)
    {
        $request->validate([
            'nik' => 'max:16'
        ]);

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $checkingBankAccount = DB::table('employee_bank_account')->where('nik', $request->nik)->first();
        $checkingAvailableEmployeeJobPosition = DB::table('employee_type_position')->select('type_of_employee')->where('nik', $request->nik)->first();
        $checkingAvailableEmployeeJobLevel = DB::table('employee')->select('job_level_position')->where('id', $request->id)->first();
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        $user = app('App\Http\Controllers\Api\LoginAdminController')->getUsers();


        $HR_SESSION = in_array(app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name, ['Human Resource Staff', 'Head of Human Resource']);
        $EMPLOYEE_LOGIN = auth()->user()->nik;
        // dd($EMPLOYEE_LOGIN);

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($HR_SESSION || $EMPLOYEE_LOGIN) {
                    DB::table('employee')->where('nik', $request->nik)->update([
                        'nik' => $request->nik,
                        'name' => $request->name,
                        'address' => $request->address,
                        'phone_number' => "+62 " . $request->phone_number,
                        'email' => $request->email,
                        'job_position' => $request->job_position,
                        'job_level_position' => $request->job_level_position,
                        'branch_id' => $request->branch_id,
                        'is_active' => $request->is_active,
                        'birth_date' => $request->birth_date,
                        'start_date' => $request->start_date,
                        'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                        'updated_at' => now()
                    ]);

                    if ($checkingAvailableEmployeeJobPosition === null) {
                        EmployeeTypePosition::create([
                            'nik' => $request->nik,
                            'type_of_employee' => $request->type_of_employee,
                            'start_date' => $request->start_date,
                            'end_date' => $request->end_date
                        ]);
                    } else {
                        if ($request->type_of_employee === null) {
                            $request->type_of_employee = $checkingAvailableEmployeeJobPosition->type_of_employee;
                        } else {
                            EmployeeTypePosition::where('nik', $request->nik)->update([
                                'nik' => $request->nik,
                                'type_of_employee' => $request->type_of_employee,
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date
                            ]);
                        }
                    }

                    if ($checkingAvailableEmployeeJobLevel == null) {
                        EmployeeModel::create([
                            'job_level_position' => $request->job_level_position,
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                            'updated_at' => now()
                        ]);
                    } else {
                        EmployeeModel::where('nik', $request->nik)->update([
                            'job_level_position' => $request->job_level_position,
                            'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                            'updated_at' => now()
                        ]);
                    }

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
                    session()->flash('failed_insert', 'Tidak dapat mengubah data!');
                    return redirect()->route('master_employee.index');
                }
            } else {
                session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional : 08.00 wib - 18.00 wib');
                return redirect()->route('master_employee.index');
            }
        } else {
            if ($HR_SESSION || $EMPLOYEE_LOGIN) {
                DB::table('employee')->where('nik', $request->nik)->update([
                    'nik' => $request->nik,
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone_number' => "+62 " . $request->phone_number,
                    'email' => $request->email,
                    'job_position' => $request->job_position,
                    'job_level_position' => $request->job_level_position,
                    'branch_id' => $request->branch_id,
                    'is_active' => $request->is_active,
                    'birth_date' => $request->birth_date,
                    'start_date' => $request->start_date,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'updated_at' => now()
                ]);

                if ($checkingAvailableEmployeeJobPosition === null) {
                    EmployeeTypePosition::create([
                        'nik' => $request->nik,
                        'type_of_employee' => $request->type_of_employee,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date
                    ]);
                } else {
                    if ($request->type_of_employee === null) {
                        $request->type_of_employee = $checkingAvailableEmployeeJobPosition->type_of_employee;
                    } else {
                        EmployeeTypePosition::where('nik', $request->nik)->update([
                            'nik' => $request->nik,
                            'type_of_employee' => $request->type_of_employee,
                            'start_date' => $request->start_date,
                            'end_date' => $request->end_date
                        ]);
                    }
                }

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
                session()->flash('failed_insert', 'Tidak dapat mengubah data!');
                return redirect()->route('master_employee.index');
            }
        }
    }

    public function user_update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        $request->validate([
            'nik' => 'max:16'
        ]);

        $employee_id = $request->id;

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 5 && $insertTime <= 18) {
                DB::table('employee')->where('id', $employee_id)->update([
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
        } else {
            DB::table('employee')->where('id', $employee_id)->update([
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
        return redirect()->route('profile');
    }

    public function update_user_picture(Request $request, $id)
    {
        $request->validate([
            'users_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10048'
        ]);

        $picture_id = DB::table('users_picture')->where('user_id', $request->id)->first();

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
            return redirect()->route('profile');
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

        $signatureId = DB::table('employee_signature')->where('employee_id', $employee_id)->firstOrFail();

        if ($request->hasFile('signature')) {
            $signature = $request->file('signature');
            $signaturePath = $signature->storeAs('employee_signature', uniqid() . '.' . $signature->getClientOriginalExtension(), 'public');

            DB::table('employee_signature')->where('employee_id', $request->employee_id)->update([
                'employee_id' => $employee_id,
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
        return redirect()->route('profile');
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
        $SETTING_TIME = DB::table('settings_schedule_time')->first();

        $user = app('App\Http\Controllers\Api\LoginAdminController')->getUsers();
        $allowed_positions = ['Human Resource Staff', 'Head of Human Resource'];
        $HR_SESSION = in_array($user->position_name, $allowed_positions);

        if ($SETTING_TIME->open_schedule_time == 'on') {
            if ($insertTime >= 7 && $insertTime <= 18) {
                if ($HR_SESSION) {
                    if ($employee_model) {
                        $employee_model->delete();
                        $this->insertLogActivityUsers(__METHOD__);
                        session()->flash('delete_success', 'Berhasil hapus data!');
                        return redirect()->back();
                    }
                } else {
                    session()->flash('failed_insert', 'Tidak dapat menghapus data!');
                    return redirect()->back();
                }
            } else {
                session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional  : 08.00 wib - 18.00 wib');
                return redirect()->route('master_employee.index');
            }
        } else {
            if ($HR_SESSION) {
                if ($employee_model) {
                    $employee_model->delete();
                    $this->insertLogActivityUsers(__METHOD__);
                    session()->flash('delete_success', 'Berhasil hapus data!');
                    return redirect()->back();
                }
            } else {
                session()->flash('failed_insert', 'Tidak dapat menghapus data!');
                return redirect()->back();
            }
        }
    }


    public function profile(Request $request): View
    {

        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id;

        if (auth()->user()->nik  !== auth()->user()->nik) {
            abort(403, 'Ooops unauthorized nik');
        }

        $employee = DB::table('v_employee')->where('nik', auth()->user()->nik)->get();
        $employee_type_position = DB::table('employee_type_position')->where('NIK', $request->nik)->get();
        if ($employee->isEmpty()) {
            abort(403, 'Ooops unauthorized nik');
        }


        $start_date = Carbon::parse($employee->first()->start_date);
        $end_date = Carbon::parse($employee->first()->end_date);
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
            ->where('u.nik', auth()->user()->nik)->get();

        $signature_employee = DB::table('employee_signature as se')
            ->select('nik', 'name', 'signature')
            ->leftJoin('employee as e', 'se.employee_id', '=', 'e.id')->where('nik', auth()->user()->nik)->get();
        $user = app('App\Http\Controllers\Api\LoginAdminController')->getUsers();

        $checking_employee_resign_status = DB::table('v_employee_resign')->where('employee_id', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id)->get();
        $checking_absences_status = DB::table('v_employee_leaves')->where('employee_id', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id)->latest()->first();

        $qr_code_employee = DB::table('employee')->select('qr_code_path')->where('nik', auth()->user()->nik)->get();

        $username = DB::table('v_employee')->select(DB::raw('left(name,1) as user_name'))->where('nik', auth()->user()->nik)->get();
        return view('layouts.admin_views.employee_profile.edit.edit_profile', compact('employee', 'branch', 'job_position', 'grouped_sub_menu', 'sidebar_menu', 'user', 'start_date', 'end_date', 'birth_date', 'user_picture', 'signature_employee', 'checking_employee_resign_status', 'checking_absences_status', 'qr_code_employee', 'username'));
    }


    public function generate_qr_code(Request $request)
    {

        $employee_branch_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->branch_id;
        $employee_job_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position;
        $nik =  app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->nik;
        $name =  app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name;
        $employee_id = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->user_emp_id;
        $location_name = DB::table('branch')->select('location_name')->where('id', $employee_branch_id)->first();
        $position = DB::table('job_position')->select('position_name')->where('id', $employee_job_id)->first();

        $employee_data_qr_code  = [
            'nik' => $nik,
            'name' => $name,
            'employee_id' => $employee_id,
            'attedance_type' => "hadir",
            'attedance_date' => now()->format('Y-m-d'),
            'job_position' => $position->position_name,
            'branch' => $location_name->location_name
        ];

        // dd($employee_data_qr_code);

        $folderPath = public_path('employee_qrcode');
        if (!File::exists($folderPath)) {
            File::makeDirectory($folderPath, 0755, true);
        }

        $qrCodePath = 'employee_qrcode/' . $request->nik . '.svg';
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svgOutput = $writer->writeString(json_encode($employee_data_qr_code));

        Storage::disk('public')->put('employee_qrcode/' . $request->nik . '.svg', $svgOutput);


        EmployeeModel::where('nik', $nik)->update([
            'qr_code_path' => $qrCodePath
        ]);

        return redirect()->back()->with('message_success', 'QR Code berhasil dibuat!');
    }



    public function users_log_activity(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $users_activity = DB::table('log_activity_users as la')
            ->select('la.id', 'la.user_id', 'la.ip_address', 'la.log_activity', 'e.nik', 'e.name', 'la.created_at', 'la.created_by')
            ->leftJoin('users as us', 'us.id', '=', 'la.user_id')
            ->leftJoin('employee as e', 'us.employee_id', '=', 'e.id')
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
        return view('layouts.admin_views.users_admin.users_activity', compact('users_activity', 'grouped_sub_menu', 'sidebar_menu'));
    }
}
