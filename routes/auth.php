<?php

use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\Analytics;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\LoginAdminController;
use App\Http\Controllers\Api\AuthenticatedSessionController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ConfirmablePasswordController;
use App\Http\Controllers\Api\CustomerRequestVehicleSale;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EmailVerificationNotificationController;
use App\Http\Controllers\Api\EmailVerificationPromptController;
use App\Http\Controllers\Api\EmployeeAttedance;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Http\Controllers\Api\PasswordResetLinkController;
use App\Http\Controllers\Api\RegisteredUserController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmployeeSalary;
use App\Http\Controllers\Api\LandingPage\LandingPageController;
use App\Http\Controllers\Api\MasterCreditSimulation;
use App\Http\Controllers\Api\MasterVehicleAdvertisement;
use App\Http\Controllers\Api\MasterVehicleData;
use App\Http\Controllers\Api\VerifyEmailController;
use App\Http\Controllers\Api\MasterAppointment;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\MaintenanceUnitController;
use App\Http\Controllers\Api\SpkUnitController;
use App\Http\Controllers\Api\VehicleSalesRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserControl;
use App\Mail\SendEmailAppointment;
use App\Models\CreditSimulation;
use App\Models\MasterVehicleAdvertisementModel;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

Route::middleware('guest')->group(function () {
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('send-forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.check');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
    Route::get('login', [LoginAdminController::class, 'login_gateway'])
        ->name('login');
    Route::post('login_execute', [LoginAdminController::class, 'store'])->name('login_execute');
    Route::get('sahabatmotor', [LandingPageController::class, 'index'])->name('sahabatmotor');
    // route post request vehicle
    Route::post('request_vehicle', [LandingPageController::class, 'vehicle_customer_request'])->name('request_vehicle');
    Route::get('vehicle_detail/{slug}', [LandingPageController::class, 'vehicle_detail'])->name('vehicle_detail');
    Route::get('all_vehicle', [LandingPageController::class, 'all_vehicles'])->name('all_vehicle');
    Route::get('vehicle_price_range/', [LandingPageController::class, 'vehicle_price_range'])->name('vehicle_price_range/');
    Route::get('filter_brand/', [LandingPageController::class, 'filterbyvehiclebrand'])->name('filter_brand/');
    Route::get('vehicle_appointment/', [LandingPageController::class, 'appointment_layout'])->name('vehicle_appointment');
    Route::post('appointment_save', [LandingPageController::class, 'saveAppointment'])->name('appointment_save');
    Route::get('/get_location/{vehicle_id}', [LandingPageController::class, 'get_location']);
    Route::get('filter_branch', [LandingPageController::class, 'filter_branch_vehicle'])->name('filter_branch');
    Route::put('ads_clicked/{slug}', [LandingPageController::class, 'clicked_ads'])->name('ads_clicked');


    // route vehicle sale request
    Route::post('vehicle_request_save', [VehicleSalesRequest::class, 'store'])->name('vehicle_request_save');
    Route::get('vehicle_sale_request', [VehicleSalesRequest::class, 'index'])->name('vehicle_sale_request');

    Route::get('/get_status', [VehicleSalesRequest::class, 'check_status'])->name('get_status');

    Route::get('/get_status_request', [LandingPageController::class, 'check_status_request'])->name('get_status_request');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('employee_data', [EmployeeController::class, 'register_employee_layouts']);
    Route::get('add_employee', [RegisteredUserController::class, 'create'])->name('add_employee');

    Route::middleware('auth')->get('/users-register', [RegisteredUserController::class, 'create'])->name('register');

    // USER ROUTES
    Route::post('save_users', [RegisteredUserController::class, 'store'])->name('save_users');
    Route::put('edit_users/', [RegisteredUserController::class, 'update'])->name('edit_users.update');
    Route::apiResource('master_users', App\Http\Controllers\Api\RegisteredUserController::class);
    Route::get('users_create', [RegisteredUserController::class, 'users_create_layout'])->name('users_create');
    Route::get('/get_email_nik/{employeeId}', [RegisteredUserController::class, 'getEmailNik']);
    Route::get('profile/{nik}', [EmployeeController::class, 'profile'])->name('profile');
    Route::put('user_update/', [EmployeeController::class, 'user_update'])->name('user_update');
    Route::post('users_picture', [EmployeeController::class, 'upload_users_picture'])->name('users_picture');
    Route::put('update_picture/{id}', [EmployeeController::class, 'update_user_picture'])->name('update_picture');
    Route::get('users_export', [EmployeeController::class, 'users_export'])->name('users_export');

    // USER ACCESS CONTROL ROUTES
    Route::apiResource('user_control', App\Http\Controllers\UserControl::class);
    Route::get('users_activity', [RegisteredUserController::class, 'getUSersActivity'])->name('users_activity');

    // DEPARTMENT ROUTES
    Route::apiResource('master_department', App\Http\Controllers\Api\DepartmentController::class);
    Route::get('department_create', [DepartmentController::class, 'department_create_layout'])->name('department_create');
    Route::get('department_update/{id}', [DepartmentController::class, 'edit_layout'])->name('department_update');
    Route::get('department_export', [DepartmentController::class, 'department_export'])->name('department_export');

    // MENU ROUTES
    Route::apiResource('master_main_menus', App\Http\Controllers\Api\MasterMainMenuController::class);
    Route::get('menu_create', [MasterMainMenuController::class, 'menus_create_layout'])->name('menu_create');
    Route::get('submenu_create/', [MasterMainMenuController::class, 'submenu_create_layout'])->name('submenu_create');
    Route::get('submenu_detail/{id}', [MasterMainMenuController::class, 'submenu_detail_data'])->name('submenu_detail');
    Route::delete('submenu_delete/', [MasterMainMenuController::class, 'submenu_delete'])->name('submenu_delete');
    Route::post('submenu_save', [MasterMainMenuController::class, 'submenu_save'])->name('submenu_save');
    Route::get('submenu_edit/', [MasterMainMenuController::class, 'submenu_update_layout'])->name('submenu_edit');
    Route::put('edit_menus/', [MasterMainMenuController::class, 'update'])->name('edit_menus.update');
    Route::put('edit_submenu/', [MasterMainMenuController::class, 'submenu_update'])->name('edit_submenu.update');
    Route::get('submenu_export/{id}', [MasterMainMenuController::class, 'submenu_export'])->name('submenu_export');

    // EMPLOYEE ROUTES
    Route::apiResource('master_employee', App\Http\Controllers\Api\EmployeeController::class);
    Route::get('add_employee', [EmployeeController::class, 'add_employee_layout'])->name('add_employee');
    Route::get('edit_employee/{id}', [EmployeeController::class, 'edit_employee_layout'])->name('edit_employee');
    Route::put('edit_employee/{id}', [EmployeeController::class, 'update'])->name('edit_employee.update');
    Route::get('employee_export', [EmployeeController::class, 'employee_export'])->name('employee_export');
    Route::get('employee_profile', [EmployeeController::class, 'employee_profile_layout'])->name('employee_profile');
    Route::get('filter_employee', [EmployeeController::class, 'filter_employee'])->name('filter_employee');
    Route::post('/export_employee', [EmployeeController::class, 'employee_export'])->name('export_employee');
    Route::post('upload_signature', [EmployeeController::class, 'upload_employee_signature'])->name('upload_signature');
    Route::put('upload_update_signature/{employee_id}', [EmployeeController::class, 'update_signature'])->name('upload_update_signature');
    Route::delete('delete_signature/{employee_id}', [EmployeeController::class, 'delete_signature'])->name('delete_signature');


    // ROUTE FOR API employee
    Route::get('get_employee', [EmployeeController::class, 'getEmployee'])->name('get_employee');
    Route::get('get_employee/{id}', [EmployeeController::class, 'getEmployee'])->name('get_employee');

    // EMPLOYEE SALARY ROUTES
    Route::apiResource('master_employee_salary', App\Http\Controllers\Api\EmployeeSalary::class);
    Route::put('edit_employee_salary/{id}', [EmployeeSalary::class, 'update'])->name('edit_employee_salary.update');
    Route::get('edit_emp_salary/{id}', [EmployeeSalary::class, 'show'])->name('edit_emp_salary');
    Route::get('add_emp_salary', [EmployeeSalary::class, 'create_emp_salary_layout'])->name('add_emp_salary');
    Route::get('filter_employee_salary', [EmployeeSalary::class, 'filter_salary'])->name('filter_employee_salary');
    Route::post('/export_employee_salary', [EmployeeSalary::class, 'employee_salary_export'])->name('export_employee_salary');

    // EMPLOYEE ATTEDANCE ROUTES
    Route::apiResource('master_employee_attedance', App\Http\Controllers\Api\EmployeeAttedance::class);
    Route::get('add_employee_attedance', [EmployeeAttedance::class, 'create_employee_attedance_layout'])->name('add_employee_attedance');
    Route::get('edit_attedance_layout/{nik}/{id}', [EmployeeAttedance::class, 'edit_employee_attedance_layout'])->name('edit_attedance_layout');
    Route::put('edit_employee_attedance/{id}', [EmployeeAttedance::class, 'update'])->name('edit_employee_attedance.update');
    Route::get('filter_attedance', [EmployeeAttedance::class, 'filter_attedance'])->name('filter_attedance');
    Route::post('/attendance_export_data', [EmployeeAttedance::class, 'attendance_export'])->name('attendance_export_data');
    Route::post('/attendance_branch_export_data', [EmployeeAttedance::class, 'branch_attendance_export'])->name('attendance_branch_export_data');


    // VEHICLE ROUTES
    Route::apiResource('master_vehicle_data', App\Http\Controllers\Api\MasterVehicleData::class);
    Route::get('add_vehicle', [MasterVehicleData::class, 'create_vehicle_layout'])->name('add_vehicle');
    Route::get('edit_vehicle/{id}', [MasterVehicleData::class, 'edit_vehicle_layout'])->name('edit_vehicle');
    Route::get('detail_vehicle/{id}', [MasterVehicleData::class, 'detail_vehicle_layout'])->name('detail_vehicle');
    Route::put('update_vehicle/{id}', [MasterVehicleData::class, 'update'])->name('update_vehicle.update');
    Route::put('update_status/{id}', [MasterVehicleData::class, 'update_status_vehicle'])->name('update_status');
    Route::put('update_payment/{id}', [MasterVehicleData::class, 'update_payment_method'])->name('update_payment');
    Route::post('document_upload', [MasterVehicleData::class, 'document_upload'])->name('document_upload');
    Route::post('image_upload', [MasterVehicleData::class, 'images_upload'])->name('image_upload');
    Route::get('/download/vehicle_document/{id}', [MasterVehicleData::class, 'document_download'])->name('download.document');
    Route::get('/download/vehicle_images/{id}', [MasterVehicleData::class, 'images_download'])->name('download.images');
    Route::get('filter_status', [MasterVehicleData::class, 'filter_status'])->name('filter_status');
    Route::delete('delete_images/', [MasterVehicleData::class, 'delete_allimages'])->name('delete_images');
    Route::delete('delete_document/', [MasterVehicleData::class, 'delete_alldocument'])->name('delete_document');
    Route::delete('delete_onlychoose_document/', [MasterVehicleData::class, 'delete_choose_document'])->name('delete_onlychoose_document');
    Route::delete('delete_onlychoose_images/', [MasterVehicleData::class, 'delete_choose_images'])->name('delete_onlychoose_images');
    Route::get('get_vehicle_location', [MasterVehicleData::class, 'getvehiclelocation'])->name('get_vehicle_location');
    Route::get('payment_method/{id}', [MasterVehicleData::class, 'payment_method_layouts'])->name('payment_method');


    // vehicle export excel
    Route::post('/vehicle_export', [MasterVehicleData::class, 'vehicle_export_data'])->name('vehicle_export');

    // VEHICLE MEDIA PLAYER ROUTES:
    Route::post('vehicle_media_upload', [MasterVehicleData::class, 'vehicle_media_upload'])->name('vehicle_media_upload');

    // Credit Simulation Routes
    Route::apiResource('master_credit_simulation', App\Http\Controllers\Api\MasterCreditSimulation::class);
    Route::get('add_credit_simulation/{id}', [MasterCreditSimulation::class, 'create_credit_simulation_layout'])->name('add_credit_simulation');
    Route::get('edit_credit_simulation/{id}', [MasterCreditSimulation::class, 'edit_credit_simulation_layout'])->name('edit_credit_simulation');
    Route::put('update_credit_simulation/{id}', [MasterCreditSimulation::class, 'update'])->name('update_credit_simulation.update');
    Route::delete('delete_credit/', [MasterCreditSimulation::class, 'destroy'])->name('delete_credit');


    // Branch Routes
    Route::apiResource('master_branch', App\Http\Controllers\Api\BranchController::class);
    Route::get('branch_create', [BranchController::class, 'create_branch_layout'])->name('branch_create');
    Route::get('update_branch/{id}', [BranchController::class, 'edit_branch_layout'])->name('update_branch.update');
    Route::put('edit_branch/{id}', [BranchController::class, 'update'])->name('edit_branch.update');
    Route::delete('delete_branch/', [BranchController::class, 'destroy'])->name('delete_branch');
    Route::get('branch_export', [BranchController::class, 'branch_export'])->name('branch_export');

    // Route Vehicle Advertisement
    Route::apiResource('master_vehicle_advertisement', App\Http\Controllers\Api\MasterVehicleAdvertisement::class);
    Route::delete('delete_ads/', [MasterVehicleAdvertisement::class, 'destroy'])->name('delete_ads');
    Route::get('add_vehicle_advertisement/{vehicle_id}', [MasterVehicleAdvertisement::class, 'add_advertisement_layout'])->name('add_vehicle_advertisement');
    Route::put('update_foto/{vehicle_id}', [MasterVehicleAdvertisement::class, 'update_advertisement_foto'])->name('update_foto');
    Route::get('filter_advertisement', [MasterVehicleAdvertisement::class, 'filter_advertisement'])->name('filter_advertisement');
    Route::post('/advertisement_export', [MasterVehicleAdvertisement::class, 'advertisement_export'])->name('advertisement_export');


    // settings routes
    Route::get('settings', [DashboardController::class, 'settings_layout'])->name('settings');

    // Appointment Routes
    Route::apiResource('customers_appointment', App\Http\Controllers\Api\MasterAppointment::class);
    Route::put('change_appointment_status/{id}', [MasterAppointment::class, 'change_appointment'])->name('change_appointment_status');
    Route::get('filter_appontment', [MasterAppointment::class, 'filter_appointment'])->name('filter_appointment');
    Route::post('appointment_export', [MasterAppointment::class, 'appointment_export'])->name('appointment_export');

    // customer_vehicle_request
    Route::get('customer_vehicle_request', [MasterAppointment::class, 'customer_vehicle_request']);
    Route::get('customer_vehicle_mail/{id}', [MasterAppointment::class, 'sendMailVehicleRequest'])->name('customer_vehicle_mail');
    Route::put('response_customers_request/{id}', [MasterAppointment::class, 'response_customers_request'])->name('response_customers_request');
    Route::get('filter_request', [MasterAppointment::class, 'filter_request'])->name('filter_request');
    Route::post('vehicle_req_export', [MasterAppointment::class, 'vehicle_req_export'])->name('vehicle_req_export');

    // customer sale request
    Route::apiResource('master_vehicle_sale', App\Http\Controllers\Api\CustomerRequestVehicleSale::class);
    Route::get('customer_vehicle_sale_mail/{id}', [CustomerRequestVehicleSale::class, 'sendMailVehicleSaleRequest'])->name('customer_vehicle_mail');
    Route::put('response_customers_request_sale/{id}', [CustomerRequestVehicleSale::class, 'response_customers_request'])->name('response_customers_request_sale');

    // settings routes:
    Route::post('time_settings', [UserControl::class, 'time__settings'])->name('time_settings');

    // Analytics DashboardController
    Route::get('master_analytics', [Analytics::class, 'index'])->name('master_analytics');
    Route::get('/get_clicked_data', [Analytics::class, 'get_total_vehicle_ads']);
    Route::get('/get_brand_total', [Analytics::class, 'get_brand_total']);

    // AGENDA controller
    Route::apiResource('master_agenda', App\Http\Controllers\Api\AgendaController::class);
    Route::get('agenda_create', [AgendaController::class, 'agenda_layouts'])->name('agenda_create');
    Route::get('agenda_edit/{id}', [AgendaController::class, 'agenda_edit_layouts'])->name('agenda_edit');
    Route::put('agenda_update/{id}', [AgendaController::class, 'update'])->name('agenda_update');

    // SPK Unit Controller
    Route::apiResource('transaksi_spk_unit', App\Http\Controllers\Api\SpkUnitController::class);
    Route::get('spk_create', [SpkUnitController::class, 'spk_create_layout'])->name('spk_create');
    Route::get('spk_edit/{id}', [SpkUnitController::class, 'spk_edit_layout'])->name('spk_edit');
    Route::get('/get_unit/{vehicleId}', [SpkUnitController::class, 'getUnit']);
    Route::put('confirmed_status_spk/{id}', [SpkUnitController::class, 'confirmedSpkUnit'])->name('confirmed_status_spk');
    Route::get('get_pdf/{id}', [SpkUnitController::class, 'download_spk'])->name('get_pdf');

    // Maintenence Unit
    Route::apiResource('master_maintenance_unit', App\Http\Controllers\Api\MaintenanceUnitController::class);
    Route::get('maintenance_unit_create', [MaintenanceUnitController::class, 'maintenance_layout'])->name('maintenance_unit_create');
    Route::get('maintenance_unit_edit/{id}', [MaintenanceUnitController::class, 'maintenance_edit_layout'])->name('maintenance_unit_edit');
    Route::put('maintenance_update/{id}', [MaintenanceUnitController::class, 'update'])->name('maintenance_update');
});
