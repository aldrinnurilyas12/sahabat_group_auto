<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\Schema;


class EmployeeResignExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($selected_data, $offices, $bulan, $tahun)
    {

        $this->selected_data = $selected_data;
        $this->office = $offices;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }


    public function collection()
    {

        $column_except = Schema::getColumnListing('v_employee_resign');
        $column_except =  array_filter($column_except, fn($col) => $col !== 'id');

        if ($this->office == 'alldata' && $this->bulan == 'alldata' && $this->tahun == 'alldata') {
            return DB::table('v_employee_resign')
                ->select(
                    'resign_code',
                    'nik',
                    'name',
                    'location_name',
                    'department_name',
                    'position_name',
                    'resign_date',
                    'resign_reasons',
                    'return_company_property',
                    'last_day_of_work',
                    'approval_by_branch_head',
                    'approval_by_hr_head',
                    'feedback',
                    'created_at',
                    'updated_at'
                )
                ->get();
        } elseif ($this->office && $this->bulan && $this->tahun) {
            return DB::table('v_employee_resign')
                ->select(
                    'resign_code',
                    'nik',
                    'name',
                    'location_name',
                    'department_name',
                    'position_name',
                    'resign_date',
                    'resign_reasons',
                    'return_company_property',
                    'last_day_of_work',
                    'approval_by_branch_head',
                    'approval_by_hr_head',
                    'feedback',
                    'created_at',
                    'updated_at'
                )
                ->where('location_name', [$this->office])
                ->whereRaw('MONTH(resign_date) = ?', [$this->bulan])
                ->whereRaw('YEAR(resign_date) = ?', [$this->tahun])
                ->get();
        } else {
            return DB::table('v_employee_resign')
                ->select(
                    'resign_code',
                    'nik',
                    'name',
                    'location_name',
                    'department_name',
                    'position_name',
                    'resign_date',
                    'resign_reasons',
                    'return_company_property',
                    'last_day_of_work',
                    'approval_by_branch_head',
                    'approval_by_hr_head',
                    'feedback',
                    'created_at',
                    'updated_at'
                )
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'Kode Resign',
            'NIK',
            'Name',
            'Cabang',
            'Department',
            'Posisi',
            'Tanggal Resign',
            'Alasan Resign',
            'Properti perusahaan yang dikembalikan',
            'Hari terakhir kerja',
            'Approval oleh Kepala Cabang',
            'Approval oleh HR',
            'Feedback',
            'Dibuat pada',
            'Diubah Pada'
        ];
    }

    public function title(): string
    {
        return 'Data Resign'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Resign PT Sahabat Group Auto');
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->setCellValue('A2', 'Kantor : ' . $this->office);
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $event->sheet->getStyle('A2:H2')->getFont()->setBold(true); // Optional styling for title
                $event->sheet->getStyle('A3:H2')->getFont()->setBold(true);
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A3:O3')->getFont()->setBold(true); // Bold headers
                $sheet = $event->sheet->getDelegate();
                // Auto-size all used columns
                foreach (range('A', 'Z') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Jika Anda tahu ada kolom lebih dari Z, Anda bisa extend dengan:
                foreach (range('A', 'Z') as $first) {
                    $sheet->getColumnDimension($first)->setAutoSize(true);
                }
                foreach (range('A', 'F') as $second) { // Untuk kolom AA hingga AF
                    $col = 'A' . $second;
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
