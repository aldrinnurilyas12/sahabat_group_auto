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


class AttendanceBranchExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($month, $year)
    {

        $this->month = $month;
        $this->year = $year; // Ganti $users dengan $employee_id
    }

    public function collection()
    {
        // Ambil data kehadiran yang difilter berdasarkan bulan, tahun, dan employee_id

        if ($this->month == 'alldata' && $this->year == 'alldata') {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->get();
        } elseif ($this->month == 'alldata') {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        } elseif ($this->year == 'all_data') {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->get();
        } elseif ($this->month && $this->year == 'alldata') {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->get();
        } elseif ($this->year && $this->month == 'alldata') {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        } elseif ($this->month && $this->year) {
            return DB::table('v_employee_attedance') // Pastikan nama tabel benar
                ->select('nik', 'name', 'attedance_type', 'reasons', 'attedance_date')
                ->where('branch', app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name)
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'NIK',
            'Nama Karyawan',
            'Tipe Presensi',
            'Alasan',
            'Tanggal Presensi'
        ];
    }
    public function title(): string
    {
        return 'Data presensi karyawan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Presensi Karyawan ' . ' ' . app('App\Http\Controllers\Api\LoginAdminController')->getUsers()->location_name);
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->month);
                $event->sheet->setCellValue('A3', 'Tahun: ' . $this->year); // Set custom title at the top of the sheet
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true);
                $event->sheet->getStyle('A3')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:E4')->getFont()->setBold(true); // Bold headers
            },
        ];
    }
}