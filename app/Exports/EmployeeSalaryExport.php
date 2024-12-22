<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeeSalaryExport implements FromCollection, WithTitle, WithHeadings, WithEvents
{
    public function __construct($department)
    {
        $this->department = $department;
    }


    public function collection()
    {

        if ($this->department == 'alldata') {
            return DB::table('v_employee_salary')
                ->select(
                    'id',
                    'position_name',
                    'department_name',
                    'employee_total',
                    'salary',
                    'tunjangan_transport',
                    'tunjangan_kesehatan',
                    'tunjangan_lainnya',
                    'salary_total',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->get();
        } elseif ($this->department) {
            return DB::table('v_employee_salary')
                ->select(
                    'id',
                    'position_name',
                    'department_name',
                    'employee_total',
                    'salary',
                    'tunjangan_transport',
                    'tunjangan_kesehatan',
                    'tunjangan_lainnya',
                    'salary_total',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('department_name', [$this->department])
                ->get();
        } else {
            return DB::table('v_employee_salary')
                ->select(
                    'id',
                    'position_name',
                    'department_name',
                    'employee_total',
                    'salary',
                    'tunjangan_transport',
                    'tunjangan_kesehatan',
                    'tunjangan_lainnya',
                    'salary_total',
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
        return [
            'JOB ID',
            'Posisi',
            'Nama Department',
            'Jumlah Karyawan',
            'Gaji',
            'Tunjangan Transport',
            'Tunjangan Kesehatan',
            'Tunjangan Lainnya',
            'Total Gaji',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah pada',
            'Diubah oleh'
        ];
    }

    public function title(): string
    {
        return 'Data Posisi Pekerjaan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Posisi Pekerjaan PT Sahabat Group Auto');
                $event->sheet->setCellValue('A2', 'Department : ' . $this->department);
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $event->sheet->getStyle('A2')->getFont()->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A3:M3')->getFont()->setBold(true);
            },
        ];
    }
}
