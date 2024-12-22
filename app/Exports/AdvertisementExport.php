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

class AdvertisementExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }


    public function collection()
    {

        if ($this->month == 'alldata' && $this->year == 'alldata') {

            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->get();
        } elseif ($this->month && $this->year == 'alldata') {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->get();
        } elseif ($this->year && $this->month == 'alldata') {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        } elseif ($this->month && $this->year) {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        } elseif ($this->month) {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->get();
        } elseif ($this->year) {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        } else {
            return DB::table('v_vehicle_advertisement')
                ->select(
                    'vehicle_id',
                    'ads_id',
                    'vehicle_registration_number',
                    'unit',
                    'price',
                    'credit_price',
                    'location_unit',
                    'category_name',
                    'clicked',
                    'is_active',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->get();
        }
    }

    public function headings(): array
    {
        return  [
            'Vehicle ID',
            'ads ID',
            'NO.POL',
            'Unit',
            'Harga Cash',
            'Harga Kredit',
            'Lokasi Unit',
            'Status Unit',
            'Jumlah Views Iklan',
            'Status Iklan',
            'Dibuat pada',
            'Dibuat Oleh',
            'Diubah pada',
            'Dibuat Oleh'

        ];
    }

    public function title(): string
    {
        return 'Data Iklan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Iklan Unit Kendaraan PT Sahabat Group Auto');
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->month);
                $event->sheet->setCellValue('A3', 'Tahun: ' . $this->year);
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $event->sheet->getStyle('A2:A3')->getFont()->setBold(true);
                // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:N4')->getFont()->setBold(true);
            },
        ];
    }
}
