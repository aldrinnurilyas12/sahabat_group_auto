<?php

namespace App\Http\Controllers\Api;

use App\Exports\TestimonialCustomersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\MasterMainMenuController;
use App\Models\TestimonialModel;
use Carbon\Month;
use FontLib\Table\Type\loca;
use Predis\Command\Container\FUNCTIONS;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class Analytics extends Controller
{

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
        $employee = DB::table('v_employee')->get();

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $location_unit = DB::table('branch')->get();

        $head_finance = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Finance Operation';
        $head_business_development = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Business Development';
        $head_marketing = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Marketing';
        $sales_manager = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Sales Manager';
        $head_of_branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Head of Branch Operations';
        $finanee_staff = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->position_name = 'Finance Staff';

        $vehicle_brand = DB::table('vehicle_brand as vb')
            ->join('vehicle as v', 'vb.id', '=', 'v.brand')
            ->distinct()
            ->count('v.brand');

        $vehicle_total = DB::table('vehicle')
            ->select('v.id')->count();

        $vehicle_total_clicked = DB::table('vehicle_advertisement as va')
            ->select(DB::raw('concat(vb.brand_name, " ", v.vehicle_type, " ", v.manufacture_year) as unit'), 'va.clicked as total_vehicle_clicked')
            ->leftJoin('vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->where('va.is_active', 'Y')->get();

        $total_clicked = $vehicle_total_clicked->values();

        $revenue = $this->get_revenue($request);

        $vehicle_ads = DB::table('vehicle_advertisement')->where('is_active', 'Y')->count();
        $appointment_total = DB::table('appointment')->count();
        $unit_request = DB::table('customer_vehicle_request')->count();
        $sale_unit_request = DB::table('vehicle_sale_request')->count();
        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.analytics.analytics', compact('revenue', 'employee', 'grouped_sub_menu', 'sidebar_menu', 'appointment_total', 'unit_request', 'sale_unit_request', 'vehicle_ads', 'vehicle_total_clicked', 'vehicle_total', 'vehicle_brand', 'years', 'months', 'bulan', 'tahun', 'location_unit'));
    }

    public function get_total_vehicle_ads(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $location = $request->location;

        $fetch_data =  DB::table('vehicle_advertisement as va')
            ->select('v.unit', 'va.clicked as total_vehicle_clicked')
            ->when($location && $location !== 'alldata', function ($query) use ($location) {
                return $query->where('location_name', $location);
            })
            ->when($month && $month !== 'alldata', function ($query) use ($month) {
                return $query->whereMonth('va.created_at', $month);
            })
            ->when($year && $year !== 'alldata', function ($query) use ($year) {
                return $query->whereYear('va.created_at', $year);
            })
            ->leftJoin('v_vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->where('va.is_active', 'Y')->orderBy('va.clicked', 'DESC')->get();

        $unit = $fetch_data->pluck('unit');
        $total_clicked = $fetch_data->pluck('total_vehicle_clicked');

        return response()->json([
            'unit' => $unit,
            'total_vehicle_clicked' => $total_clicked
        ]);
    }

    public function get_brand_total()
    {
        $fetch_data = DB::table('vehicle as v')
            ->select('vb.brand_name as brand_name', \DB::raw('count(vb.brand_name) as brand_total'))
            ->join('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->groupBy('vb.brand_name')->orderBy('brand_total', 'DESC')->get();

        $brand = $fetch_data->pluck('brand_name');
        $brand_total = $fetch_data->pluck('brand_total');

        return response()->json([
            'brand_name' => $brand,
            'brand_total' => $brand_total
        ]);
    }

    // ->whereRaw('MONTH(created_at) = ?', [$bulan])->whereRaw('YEAR(created_at) = ?', [$tahun])


    // Pastikan untuk menggunakan model yang sesuai

    public function get_revenue(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $location = $request->location;

        // Mulai query dengan kondisi yang lebih tepat
        $query = DB::table('v_spk')
            ->select(DB::raw('MONTH(created_at  ) as month'), DB::raw('SUM(price) as total_revenue'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->when($location && $location !== 'alldata', function ($query) use ($location) {
                return $query->where('location_unit', $location);
            })
            ->when($month && $month !== 'alldata', function ($query) use ($month) {
                return $query->whereRaw('MONTH(created_at) = ?', [$month]);
            })
            ->when($year && $year !== 'alldata', function ($query) use ($year) {
                return $query->whereRaw('YEAR(created_at) = ?', [$year]);
            });

        // Eksekusi query untuk mendapatkan data pendapatan per bulan
        $revenue_by_month = $query->get();

        // Ambil daftar bulan dari tabel months
        $month_list = DB::table('months')->pluck('month_list');
        $revenue_data = [];

        // Siapkan data pendapatan berdasarkan bulan
        foreach ($revenue_by_month as $revenue) {
            $revenue_data[$revenue->month] = $revenue->total_revenue;
        }

        // Siapkan total pendapatan untuk setiap bulan (1 sampai 12)
        $total_revenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $total_revenue[] = $revenue_data[$i] ?? 0;
        }

        // Kembalikan response dalam format JSON
        return response()->json([
            'price' => $total_revenue,
            'month_list' => $month_list
        ]);
    }



    public function get_budget_maintenance(Request $request)
    {

        $month = $request->month;
        $year = $request->year;
        $location = $request->location;

        $maintenance_data = DB::table('maintenance_unit as mtc')
            ->select('vehicle_id', 'unit', DB::raw('SUM(cost) as total_cost'))
            ->when($location && $location !== 'alldata', function ($query) use ($location) {
                return $query->where('location_name', $location);
            })
            ->when($month && $month !== 'alldata', function ($query) use ($month) {
                return $query->whereMonth('mtc.created_at', $month);
            })
            ->when($year && $year !== 'alldata', function ($query) use ($year) {
                return $query->whereYear('mtc.created_at', $year);
            })
            ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
            ->groupBy('vehicle_id', 'unit')
            ->get();

        $unit = $maintenance_data->pluck('unit');
        $total_cost = $maintenance_data->pluck('total_cost');

        return response()->json([
            'unit' => $unit,
            'total_cost' => $total_cost
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */


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


    public function filter_analytics(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];
        $employee = DB::table('v_employee')->get();
        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $location_unit = DB::table('branch')->get();
        $vehicle_brand = DB::table('vehicle_brand as vb')
            ->join('vehicle as v', 'vb.id', '=', 'v.brand')
            ->distinct()
            ->count('v.brand');

        $vehicle_total = DB::table('vehicle')
            ->select('v.id')->count();
        $vehicle_total_clicked = DB::table('vehicle_advertisement as va')
            ->select(DB::raw('concat(vb.brand_name, " ", v.vehicle_type, " ", v.manufacture_year) as unit'), 'va.clicked as total_vehicle_clicked')
            ->leftJoin('vehicle as v', 'va.vehicle_id', '=', 'v.id')
            ->leftJoin('vehicle_brand as vb', 'v.brand', '=', 'vb.id')->where('va.is_active', 'Y')->get();

        $total_clicked = $vehicle_total_clicked->values();
        $vehicle_ads = DB::table('vehicle_advertisement')->where('is_active', 'Y')->count();
        $appointment_total = DB::table('appointment')->count();
        $unit_request = DB::table('customer_vehicle_request')->count();
        $sale_unit_request = DB::table('vehicle_sale_request')->count();

        $revenue = $this->get_revenue($request);

        // dd($revenue);
        return view('layouts.admin_views.analytics.analytics', compact('revenue', 'employee', 'grouped_sub_menu', 'sidebar_menu', 'appointment_total', 'unit_request', 'sale_unit_request', 'vehicle_ads', 'vehicle_total_clicked', 'vehicle_total', 'vehicle_brand', 'years', 'months', 'bulan', 'tahun', 'location_unit'));
    }

    public function show_testimonial_data(Request $request)
    {
        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];



        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $testimonial = DB::table('customers_testimonial')->orderBy('created_at', 'desc')->get();

        $allowedRoles = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->job_position == '14';

        if ($allowedRoles) {
            session()->flash('failed_insert', 'Anda tidak bisa akses Modul ini');
            return redirect()->back();
        }

        return view('layouts.admin_views.testimonial.testimonial', compact('testimonial', 'bulan', 'tahun', 'months', 'years', 'grouped_sub_menu', 'sidebar_menu',));
    }

    public function filter_testimonial(Request $request)
    {

        $master_menus = $this->MasterMainMenuController->master_display_menus();
        $sidebar_menu = $master_menus['sidebar_menu'];
        $grouped_sub_menu = $master_menus['grouped_sub_menu'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $testimonial = DB::table('customers_testimonial')->orderBy('created_at', 'desc')->get();

        if ($tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }

        if ($bulan == 'alldata' && $tahun == 'alldata') {
            $testimonial = DB::table('customers_testimonial')
                ->orderBy('created_at', 'desc')->get();
        }
        if ($bulan && $tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('MONTH(created_at) = ? ', [$bulan])
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }

        return view('layouts.admin_views.testimonial.testimonial', compact('testimonial', 'bulan', 'tahun', 'months', 'years', 'grouped_sub_menu', 'sidebar_menu',));
    }

    public function download_testimonial_pdf(Request $request)
    {

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $testimonial = DB::table('customers_testimonial')->orderBy('created_at', 'desc')->get();

        if ($tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }

        if ($bulan == 'alldata' && $tahun == 'alldata') {
            $testimonial = DB::table('customers_testimonial')
                ->orderBy('created_at', 'desc')->get();
        }
        if ($bulan && $tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('MONTH(created_at) = ? ', [$bulan])
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }

        $fileName = 'Data_Testimonial_Customers' . '-' . $bulan . '_' . $tahun . '.pdf';
        $pdf = Pdf::loadView('layouts.pdf.testimonial_pdf', [
            'testimonial' => $testimonial
        ]);
        $pdf->setPaper('a4', 'landscape');
        return $pdf->download($fileName);
    }

    public function download_excel_testimonial(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $months = DB::table('months')->get();
        $currentYear = date("Y");
        $startYear = $currentYear - 10; // 4 tahun ke belakang dari tahun sekarang
        $endYear = $currentYear;   // 4 tahun ke depan dari tahun sekarang

        $years = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $years[] = (string)$year;
        }

        $testimonial = DB::table('customers_testimonial')->orderBy('created_at', 'desc')->get();

        if ($tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }

        if ($bulan == 'alldata' && $tahun == 'alldata') {
            $testimonial = DB::table('customers_testimonial')
                ->orderBy('created_at', 'desc')->get();
        }
        if ($bulan && $tahun) {
            $testimonial = DB::table('customers_testimonial')
                ->whereRaw('MONTH(created_at) = ? ', [$bulan])
                ->whereRaw('YEAR(created_at) = ? ', [$tahun])
                ->orderBy('created_at', 'desc')->get();
        }


        $fileName = 'Data_Testimonial_Customers_' . '-' . $bulan .  '-' . $tahun . '.xlsx';
        return Excel::download(new TestimonialCustomersExport($bulan, $tahun), $fileName);
    }
}