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

class AppointmentExport implements FromCollection, WithHeadings, WithTitle, WithEvents
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

            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->get();
        } elseif ($this->month && $this->year == 'alldata') {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])->get();
        } elseif ($this->year && $this->month == 'alldata') {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])->get();
        } elseif ($this->month) {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])->get();
        } elseif ($this->year) {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])->get();
        } elseif ($this->month && $this->year) {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->whereRaw('MONTH(created_at) = ? ', [$this->month])
                ->whereRaw('YEAR(created_at) = ? ', [$this->year])->get();
        } else {
            return DB::table('v_appointment')
                ->select(
                    'id',
                    'advertisement_id',
                    'unit',
                    'location_unit',
                    'category_name',
                    'name',
                    'phone_number',
                    'address',
                    'appointment_status',
                    'date',
                    'schedule_time',
                    'created_at'
                )
                ->where('location_unit', $this->branch)
                ->get();
        }
    }

    public function headings(): array
    {
        return  [
            'Appointment ID',
            'ads ID',
            'Unit',
            'Lokasi Unit',
            'Status Unit',
            'Nama Customer',
            'No.Telepon',
            'Alamat',
            'Status Appointment',
            'Tanggal Appointment',
            'Jam',
            'Dibuat pada'

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
                $event->sheet->getStyle('A2:A3')->getFont()->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:AF2')->getFont()->setBold(true);
            },
        ];
    }
}
