<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomersRequestExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($bulan, $tahun)
    {
        $this->month = $bulan;
        $this->year = $tahun;
        $this->branch = app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name;
    }


    public function collection()
    {


        if ($this->month == 'alldata' && $this->year == 'alldata') {

            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->get();
        } elseif ($this->month && $this->year == 'alldata') {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])
                ->get();
        } elseif ($this->year && $this->month == 'alldata') {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])
                ->get();
        } elseif ($this->month) {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])
                ->get();
        } elseif ($this->year) {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])
                ->get();
        } elseif ($this->month && $this->year) {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])
                ->get();
        } else {
            return DB::table('customer_vehicle_request as cvr')
                ->select('vehicle_type', 'brand_name', 'year', 'vehicle_color', 'name', 'email', 'phone_number', 'sending_mail', 'description', 'created_at')
                ->leftJoin('vehicle_brand as br', 'cvr.brand', '=', 'br.id')
                ->get();
        }
    }

    public function headings(): array
    {
        return  [
            'Tipe Kendaraan',
            'Merk',
            'Tahun',
            'Warna',
            'Nama Customer',
            'Email',
            'No.Telepon',
            'Status Email',
            'Deskripsi',
            'Dibuat pada'

        ];
    }

    public function title(): string
    {
        return 'Data Permintaan unit'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Permintaan Unit Customer');
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->month);
                $event->sheet->setCellValue('A3', 'Tahun: ' . $this->year);
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1:C1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true);
            },
        ];
    }
}
