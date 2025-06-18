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


class EmployeeResignExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($offices)
    {
        // $this->department = $departments;
        $this->office = $offices;
    }


    public function collection()
    {

        if ($this->office == 'alldata') {
            return DB::table('v_employee_resign')
                ->select(
                    'id',
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
        } elseif ($this->office) {
            return DB::table('v_employee_resign')
                ->select(
                    'id',
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
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'id',
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
            'Feeback',
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
                $sheet = $event->sheet->getDelegate(); // PhpSpreadsheet worksheet

                // Set bold styling
                $sheet->getStyle('A2:AF2')->getFont()->setBold(true);



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
