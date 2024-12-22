<?php

namespace App\Http\Controllers\Api;

use App\Exports\VehicleUnitExport;
use App\Http\Controllers\Controller;
use App\Models\VehicleFotos;
use App\Models\VehicleModel;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Http\Resources\VehicleRescource;
use App\Models\DocumentModel;
use App\Models\MediaUploadModel;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use ZipArchive;

class MasterVehicleData extends Controller
{


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
        $status_category = DB::table('status_category')->get();
        $branch = DB::table('branch')->get();
        $vehicle = DB::table('v_vehicle')->get();
        $vehicle_sold = DB::table('v_vehicle')->where('category_name', 'Unit Terjual')->get();
        $selectedStatus = $request->status;
        $selectedLocation = $request->location_unit;
        return view('layouts.admin_views.vehicle.vehicle', compact('vehicle', 'branch', 'status_category', 'vehicle_sold', 'grouped_sub_menu', 'sidebar_menu', 'selectedStatus', 'selectedLocation'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create_vehicle_layout(): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $brand = DB::table('vehicle_brand')->orderBy('brand_name', 'asc')->get();
        $branch = DB::table('branch')->get();
        $vehicle_model = DB::table('vehicle_model')->get();
        $status_category = DB::table('status_category')->get();
        $vehicle_type = DB::table('vehicle_type')->get();
        return view('layouts.admin_views.vehicle.create.add_vehicle', compact('vehicle_model', 'vehicle_type', 'brand', 'branch', 'status_category', 'grouped_sub_menu', 'sidebar_menu'));
    }


    public function detail_vehicle_layout(Request $request): View
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle = DB::table('v_vehicle')->where('id', $request->id)->get();
        $status_category = DB::table('status_category')->get();
        $images = DB::table('vehicle_fotos')->where('vehicle_id', $request->id)->get();
        $documents = DB::table('vehicle_document')->where('vehicle_id', $request->id)->get();
        $credit_simulation = DB::table('v_credit_simulation')->where('vehicle_id', $request->id)->get();

        $check_ads = DB::table('vehicle_advertisement as va')
            ->select('va.id', 'va.vehicle_id', 'va.is_active')
            ->join('vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->where('va.vehicle_id', $request->id)
            ->exists();

        $media_video = DB::table('v_vehicle_media_player')->where('media_type', 'video')->where('vehicle_id', $request->id)->get();

        $media_sound = DB::table('v_vehicle_media_player')->where('media_type', 'engine sound')->where('vehicle_id', $request->id)->get();
        return view('layouts.admin_views.vehicle.vehicle_detail', compact('vehicle', 'check_ads', 'images', 'status_category', 'documents', 'credit_simulation', 'grouped_sub_menu', 'sidebar_menu', 'media_video', 'media_sound'));
    }

    public function edit_vehicle_layout(Request $request): View
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle = DB::table('v_vehicle')->where('id', $request->id)->get();
        $transmission = DB::table('vehicle')->distinct()->select('transmission')->get();
        $vehicle_model = DB::table('vehicle_model')->get();
        $brand = DB::table('vehicle_brand')->orderBy('brand_name', 'asc')->get();
        $branch = DB::table('branch')->get();
        $status_category = DB::table('status_category')->get();
        $selectedBranch = null;


        if ($request->has('id')) {

            $selectedBranch = DB::table('branch')->find($request->id);
        }

        $vehicle_type = DB::table('vehicle_type')->get();
        return view('layouts.admin_views.vehicle.edit.edit_vehicle', compact('vehicle', 'vehicle_type', 'status_category', 'selectedBranch', 'brand', 'branch', 'grouped_sub_menu', 'sidebar_menu', 'transmission', 'vehicle_model'));
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'vehicle_registration_number' => 'required|unique:vehicle',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
            'document_files.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048'
        ]);

        if ($insertTime >= 7  && $insertTime <= 20) {
            $save_data = VehicleModel::create([
                'vehicle_registration_number' => $request->vehicle_registration_number,
                'vehicle_type' => $request->vehicle_type,
                'price' => $request->price,
                'credit_price' => $request->credit_price,
                'current_km' => $request->current_km,
                'brand' => $request->brand,
                'manufacture_year' => $request->manufacture_year,
                'vehicle_category' => $request->vehicle_category,
                'model' => $request->model,
                'color' => $request->color,
                'fuel_type' => $request->fuel_type,
                'cylinder_capacity' => $request->cylinder_capacity,
                'transmission' => $request->transmission,
                'vehicle_identity_number' => $request->vehicle_identity_number,
                'engine_number' => $request->engine_number,
                'coding_number' => $request->coding_number,
                'licence_plate_color' => $request->licence_plate_color,
                'old_vin' => $request->old_vin,
                'registration_year' => $request->registration_year,
                'bpkb_number' => $request->bpkb_number,
                'location_code' => $request->location_code,
                'registration_queue_number' => $request->registration_queue_number,
                'name_of_owner' => $request->name_of_owner,
                'address' => $request->address,
                'location_branch_vehicle' => $request->location_branch_vehicle,
                'status_vehicle_id' => $request->status_vehicle_id,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name

            ]);

            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $image) {
            //         $imagePath = $image->storeAs('vehicle_images', uniqid() . '.' . $image->getClientOriginalExtension(), 'public');
            //         VehicleFotos::create([
            //             'vehicle_id' => $save_data->id,
            //             'images' => $imagePath,
            //             'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
            //             'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            //         ]);
            //     }
            // }


            // if ($request->hasFile('document_files')) {
            //     foreach ($request->file('document_files') as $document) {
            //         $documentPath = $document->storeAs('document', uniqid() . '.' . $document->getClientOriginalExtension(), 'public');
            //         DocumentModel::create([
            //             'vehicle_id' => $save_data->id,
            //             'document_files' => $documentPath,
            //             'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
            //             'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
            //         ]);
            //     }
            // }


            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_vehicle_data.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_vehicle_data.index');
        }
        // Ensure this is a return statement

    }


    // api development || created : 17/12/2024


    public function getVehicle()
    {
        $vehicle = DB::table('v_vehicle')->get();
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data unit tidak tersedia'
            ], 404);
        }

        return new VehicleRescource(true, 'Data Unit Kendaraan', $vehicle);
    }

    public function show($id)
    {
        $vehicle = DB::table('v_vehicle')->where('id', $id)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Data unit tidak tersedia'
            ], 404);
        }

        return new VehicleRescource(true, 'Data Unit Kendaraan', $vehicle);
    }


    public function filter_status(Request $request)
    {

        $vehicle = DB::table('v_vehicle');
        $selectedStatus = $request->status;
        $selectedLocation = $request->location_unit;

        if ($selectedStatus && $selectedLocation) {
            $vehicle = DB::table('v_vehicle')->where('location_unit', $selectedLocation)->where('category_name', $selectedStatus)->get();
        }

        if ($selectedStatus === 'alldata') {
            $vehicle = DB::table('v_vehicle')->where('location_unit', $selectedLocation)->get();
        }

        if ($selectedLocation === 'alldata') {
            $vehicle = DB::table('v_vehicle')->where('category_name', $selectedStatus)->get();
        }

        if ($selectedLocation === 'alldata' && $selectedStatus === 'alldata') {
            $vehicle = DB::table('v_vehicle')->get();
        }

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $branch = DB::table('branch')->get();
        $status_category = DB::table('status_category')->get();

        // Return the view with the data
        return view('layouts.admin_views.vehicle.vehicle', compact('vehicle', 'branch', 'status_category', 'grouped_sub_menu', 'sidebar_menu', 'selectedStatus', 'selectedLocation'));
    }

    public function vehicle_export_data(Request $request)
    {

        $selected_data = $this->filter_status($request);
        $location_unit = $request->location_unit; // Full month name (e.g., January)
        $category_name = $request->category_name; // Current year (e.g., 2024)

        $fileName = 'Data_Unit' . '_' . $location_unit . '_' . $category_name . '.xlsx';

        return Excel::download(new VehicleUnitExport($selected_data, $location_unit, $category_name), $fileName);
    }

    public function update(Request $request)
    {

        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            $updateData = DB::table('vehicle')->where('id', $request->id)->update([
                'vehicle_registration_number' => $request->vehicle_registration_number,
                'vehicle_type' => $request->vehicle_type,
                'price' => $request->price,
                'credit_price' => $request->credit_price,
                'brand' => $request->brand,
                'current_km' => $request->current_km,
                'manufacture_year' => $request->manufacture_year,
                'vehicle_category' => $request->vehicle_category,
                'model' => $request->model,
                'color' => $request->color,
                'fuel_type' => $request->fuel_type,
                'cylinder_capacity' => $request->cylinder_capacity,
                'transmission' => $request->transmission,
                'vehicle_identity_number' => $request->vehicle_identity_number,
                'engine_number' => $request->engine_number,
                'coding_number' => $request->coding_number,
                'licence_plate_color' => $request->licence_plate_color,
                'old_vin' => $request->old_vin,
                'registration_year' => $request->registration_year,
                'tax_date' => $request->tax_date,
                'bpkb_number' => $request->bpkb_number,
                'location_code' => $request->location_code,
                'registration_queue_number' => $request->registration_queue_number,
                'name_of_owner' => $request->name_of_owner,
                'address' => $request->address,
                'location_branch_vehicle' => $request->location_branch_vehicle,
                'status_vehicle_id' => $request->status_vehicle_id,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil disimpan!');
            return redirect()->route('master_vehicle_data.index');
        } else {
            session()->flash('failed_insert', 'Data gagal disimpan, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_vehicle_data.index');
        }
    }

    public function update_status_vehicle(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 24) {
            DB::table('vehicle')->where('id', $request->id)->update([
                'status_vehicle_id' => $request->status_vehicle_id,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil diupdate!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Data gagal diupdate, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_vehicle_data.index')->with('success', 'Data berhasil disimpan.');
        }
    }


    public function payment_method_layouts(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $vehicle = DB::table('v_vehicle')->where('id', $request->id)->get();

        return view('layouts.admin_views.vehicle.edit.update_payment_method', compact('vehicle', 'grouped_sub_menu', 'sidebar_menu'));
    }

    public function update_payment_method(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 24) {
            DB::table('vehicle')->where('id', $request->id)->update([
                'payment_method' => $request->payment_method,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_at' => now()
            ]);

            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('message_success', 'Data Berhasil diupdate!');
            return redirect()->route('detail_vehicle', $request->id);
        } else {
            session()->flash('failed_insert', 'Data gagal diupdate, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('detail_vehicle', $request->id)->with('success', 'Data berhasil disimpan.');
        }
    }


    // function untuk mendapatkan method activity
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
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleModel $vehicleModel, $id)
    {
        $vehicleModel = VehicleModel::find($id);
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($vehicleModel) {
                $vehicleModel->delete();
                $this->insertLogActivityUsers(__METHOD__);
                session()->flash('message_success', 'Data Berhasil dihapus!');
                return redirect()->route('master_vehicle_data.index');
            }
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->route('master_vehicle_data.index');
        }
    }

    // #FUNCTION FOR DELETE ALL IMAGES
    // public function delete_allimages(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $insertTime = (int) date('H');
    //     $request->validate([
    //         'vehicle_id' => 'required|integer|exists:vehicle_fotos,vehicle_id'
    //     ]);

    //     if ($insertTime >= 7 && $insertTime <= 18) {
    //         DB::table('vehicle_fotos')
    //             ->where('vehicle_id', $request->vehicle_id)
    //             ->delete();
    //         $this->insertLogActivityUsers(__METHOD__);
    //         session()->flash('delete_images', 'Foto Berhasil dihapus!');
    //         return redirect()->back();
    //     } else {
    //         session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
    //         return redirect()->route('master_vehicle_data.index');
    //     }
    // }

    // #FUNCTION FOR DELETE ALL DOCUMENTS
    // public function delete_alldocument(Request $request)
    // {
    //     date_default_timezone_set('Asia/Jakarta');
    //     $insertTime = (int) date('H');
    //     $request->validate([
    //         'vehicle_id' => 'required|integer|exists:vehicle_document,vehicle_id'
    //     ]);

    //     $document_id = DocumentModel::find($request->vehicle_id);

    //     if ($document_id->document_files) {
    //         $olddocument = public_path('storage/' . $document_id->document_files);
    //         if (file_exists($olddocument)) {
    //             unlink($olddocument);
    //         }
    //     }


    //     if ($insertTime >= 7 && $insertTime <= 18) {
    //         DB::table('vehicle_document')->where('vehicle_id', $request->vehicle_id)->delete();
    //         $this->insertLogActivityUsers(__METHOD__);
    //         session()->flash('delete_document', 'Semua Dokumen Berhasil dihapus!');
    //         return redirect()->back();
    //     } else {
    //         session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
    //         return redirect()->route('master_vehicle_data.index');
    //     }
    // }

    public function delete_choose_document(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'id' => 'required|integer|exists:vehicle_document,id'
        ]);

        $document_id = DocumentModel::find($request->id);


        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($document_id->document_files) {
                $olddocument = public_path('storage/' . $document_id->document_files);
                if (file_exists($olddocument)) {
                    unlink($olddocument);
                }
            }
        }

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('vehicle_document')
                ->where('id', $request->id)
                ->delete();
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('delete_document', 'Dokumen Berhasil dihapus!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->back();
        }
    }


    public function delete_choose_images(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $insertTime = (int) date('H');
        $request->validate([
            'id' => 'required|integer|exists:vehicle_fotos,id'
        ]);

        $picture_id = VehicleFotos::find($request->id);

        if ($insertTime >= 7 && $insertTime <= 18) {
            if ($picture_id->images) {
                $oldPicture = public_path('storage/' . $picture_id->images);
                if (file_exists($oldPicture)) {
                    unlink($oldPicture);
                }
            }
        }

        if ($insertTime >= 7 && $insertTime <= 18) {
            DB::table('vehicle_fotos')
                ->where('id', $request->id)
                ->delete();
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('delete_images', 'Foto Berhasil dihapus!');
            return redirect()->back();
        } else {
            session()->flash('failed_insert', 'Data gagal dihapus, Jam untuk melakukan operasional: 08.00 wib - 18.00 wib');
            return redirect()->back();
        }
    }


    public function images_upload(Request $request)
    {
        // run this code:
        // date_default_timezone_set('Asia/Jakarta');
        // $insertTime = (int) date('H');
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {

                $folderPath = 'vehicle_images/' . $request->vehicle_id;
                $imagePath = $image->storeAs($folderPath, uniqid() . '.' . $image->getClientOriginalExtension(), 'public');
                VehicleFotos::create([
                    'vehicle_id' => $request->vehicle_id,
                    'images' => $imagePath,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
            }
        }
        $this->insertLogActivityUsers(__METHOD__);
        session()->flash('success_images', 'Foto Berhasil disimpan!');
        return redirect()->back()->with('message', 'Images deleted successfully.');
    }

    public function document_upload(Request $request)
    {
        // run this code:
        // date_default_timezone_set('Asia/Jakarta');
        // $insertTime = (int) date('H');
        $request->validate([
            'document_files.*' => 'required|image|mimes:jpeg,png,jpg,gif,pdf,excel|max:4048'
        ]);

        if ($request->hasFile('document_files')) {
            foreach ($request->file('document_files') as $document) {
                $folderPath = 'document/' . $request->vehicle_id;
                $documentPath = $document->storeAs($folderPath, uniqid() . '.' . $document->getClientOriginalExtension(), 'public');
                DocumentModel::create([
                    'vehicle_id' => $request->vehicle_id,
                    'document_files' => $documentPath,
                    'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                    'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name
                ]);
                $this->insertLogActivityUsers(__METHOD__);
            }
        }
        session()->flash('success_document', 'Dokumen Berhasil disimpan!');
        return redirect()->back();
    }

    public function vehicle_media_upload(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required',
            'media_files' => 'required|file|mimetypes:video/mp4,audio/mpeg|max:10240000'
        ]);


        if ($request->hasFile('media_files')) {
            $folderPath = 'media_file/' . $request->vehicle_id;
            $picture = $request->file('media_files');
            $mediaFiles = $picture->storeAs($folderPath, uniqid() . '.' . $picture->getClientOriginalExtension(), 'public');
            MediaUploadModel::create([
                'vehicle_id' => $request->vehicle_id,
                'media_type' => $request->media_type,
                'media_files' => $mediaFiles,
                'media_size' => $request->media_size,
                'created_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
                'updated_by' => auth()->user()->nik . '-' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->name,
            ]);
            $this->insertLogActivityUsers(__METHOD__);
            session()->flash('success_document', 'Media Berhasil disimpan!');
            return redirect()->back();
        }
    }

    public function document_download(Request $request)
    {
        $document = DB::table('vehicle_document as vd')
            ->select('vd.id', 'vd.vehicle_id', 'vd.document_files', 'v.brand', 'v.manufacture_year', 'v.vehicle_type')
            ->join('vehicle as v', 'vd.vehicle_id', '=', 'v.id')
            ->where('vd.vehicle_id', '=', $request->id)->get();

        // Check if the document exists
        if (!$document) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        $allDocument = $document->first();

        if (!$allDocument) {
            return redirect()->back()->with('error', 'Document not found.');
        }


        $zip = new ZipArchive();
        $zipFileName = 'dokument_unit_' . $allDocument->brand . '_' . $allDocument->vehicle_type . '_' . $allDocument->manufacture_year . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            return redirect()->back()->with('error', 'Could not create zip file.');
        }

        foreach ($document as $doc) {
            $documentPath = 'public/' . $doc->document_files;
            if (Storage::exists($documentPath)) {
                $zip->addFile(storage_path('app/' . $documentPath), basename($documentPath));
            }
        }

        $zip->close();

        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

    public function images_download(Request $request)
    {
        $images = DB::table('vehicle_fotos as vf')
            ->select('vf.id', 'vf.vehicle_id', 'vf.images', 'v.brand', 'v.manufacture_year', 'v.vehicle_type')
            ->join('vehicle as v', 'vf.vehicle_id', '=', 'v.id')
            ->where('vf.vehicle_id', '=', $request->id)->get();

        if (!$images) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        $allImages = $images->first();

        if (!$allImages) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        $zip = new \ZipArchive();
        $zipFileName = 'foto_unit_' . $allImages->brand . '_' . $allImages->vehicle_type . '_' . $allImages->manufacture_year . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
            return redirect()->back()->with('error', 'Could not create zip file.');
        }

        // Add images to the zip file
        foreach ($images as $image) {
            $imagePath = 'public/' . $image->images;

            if (Storage::exists($imagePath)) {
                $zip->addFile(storage_path('app/' . $imagePath), basename($imagePath));
            }
        }

        $zip->close();
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }
}
