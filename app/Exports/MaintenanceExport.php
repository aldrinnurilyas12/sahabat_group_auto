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

class MaintenanceExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }


    public function collection()
    {

        if ($this->bulan == 'alldata' && $this->tahun == 'alldata') {

            return  DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->bulan && $this->tahun == 'alldata') {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$this->bulan])->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->tahun && $this->bulan == 'alldata') {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(mtc.created_at) = ?', [$this->tahun])->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->bulan && $this->tahun) {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$this->bulan])->whereRaw('YEAR(mtc.created_at) = ?', [$this->tahun])->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->bulan) {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(mtc.created_at) = ?', [$this->bulan])->orderBy('created_at', 'desc')
                ->get();
        } elseif ($this->tahun) {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(mtc.created_at) = ?', [$this->tahun])->orderBy('created_at', 'desc')
                ->get();
        } else {
            return DB::table('maintenance_unit as mtc')
                ->select('mtc.id', 'vehicle_id', 'unit', 'maintenance_type', 'cost', 'maintenance_date', 'maintenance_detail', 'mechanic_name', 'foto', 'mtc.created_at', 'mtc.created_by', 'mtc.updated_at', 'mtc.created_by', 'mtc.updated_by')
                ->leftJoin('v_vehicle as vhc', 'mtc.vehicle_id', '=', 'vhc.id')
                ->where('location_name', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function headings(): array
    {
        return  [
            'Maintenance_ID',
            'Vehicle ID',
            'Unit',
            'Tipe Perawatan',
            'Biaya',
            'Tanggal Perawatan',
            'Detail Perawatan',
            'Nama Mekanik',
            'Dibuat pada',
            'Dibuat Oleh',
            'Diubah pada',
            'Dibuat Oleh'

        ];
    }

    public function title(): string
    {
        return 'Data Maintenance Unit'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Maintenance Unit Kendaraan PT Sahabat Group Auto');
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->bulan);
                $event->sheet->setCellValue('A3', 'Tahun: ' . $this->tahun);
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
