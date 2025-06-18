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


class EmployeeLeavesExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($offices)
    {
        // $this->department = $departments;
        $this->office = $offices;
    }


    public function collection()
    {

        if ($this->office == 'alldata') {
            return DB::table('v_employee_leaves')
                ->select(
                    'id',
                    'absences_code',
                    'nik',
                    'name',
                    'location_name',
                    'department_name',
                    'position_name',
                    'type_of_leave',
                    'start_date',
                    'end_date',
                    'duration_of_leaves',
                    'reason',
                    'status',
                    'branch_head_reason_of_reject',
                    'hr_reason_of_reject',
                    'approval_by_branch_head',
                    'approval_by_hr_head',
                    'created_at',
                    'updated_at'
                )
                ->get();
        } elseif ($this->office) {
            return DB::table('v_employee_leaves')
                ->select(
                    'id',
                    'absences_code',
                    'nik',
                    'name',
                    'location_name',
                    'department_name',
                    'position_name',
                    'type_of_leave',
                    'start_date',
                    'end_date',
                    'duration_of_leaves',
                    'reason',
                    'status',
                    'branch_head_reason_of_reject',
                    'hr_reason_of_reject',
                    'approval_by_branch_head',
                    'approval_by_hr_head',
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
            'Kode Cuti',
            'NIK',
            'Nama Karyawan',
            'Cabang',
            'Department',
            'Posisi',
            'Tipe Cuti',
            'Tanggal Mulai Cuti',
            'Tanggal Akhir Cuti',
            'Durasi Cuti',
            'Alasan Cuti',
            'Status',
            'Alasan Penolakan Kepala Cabang',
            'Alasan Penolakan HR',
            'Approval oleh Kepala Cabang',
            'Approval oleh HR',
            'Dibuat pada',
            'Diupdate Pada'
        ];
    }

    public function title(): string
    {
        return 'Data Cuti Karyawan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Cuti Karyawan PT Sahabat Group Auto');
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->setCellValue('A2', 'Kantor : ' . $this->office);
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $event->sheet->getStyle('A3:H2')->getFont()->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate(); // PhpSpreadsheet worksheet

                // Set bold styling
                $sheet->getStyle('A2:AF2')->getFont()->setBold(true);
                $sheet->getStyle('A3:S4')->getFont()->setBold(true);


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
