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


class EmployeeExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($departments, $offices)
    {
        $this->department = $departments;
        $this->office = $offices;
    }


    public function collection()
    {

        if ($this->department == 'alldata' && $this->office == 'alldata') {
            return DB::table('v_employee')
                ->select(
                    'id',
                    'nik',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'location_name',
                    'department_name',
                    'job_position',
                    'salary',
                    'age',
                    'start_date',
                    'resign_date',
                    'is_active',
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
        } elseif ($this->office == 'alldata') {
            return DB::table('v_employee')
                ->select(
                    'id',
                    'nik',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'location_name',
                    'department_name',
                    'job_position',
                    'salary',
                    'age',
                    'start_date',
                    'resign_date',
                    'is_active',
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
        } elseif ($this->department == 'alldata') {
            return DB::table('v_employee')
                ->select(
                    'id',
                    'nik',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'location_name',
                    'department_name',
                    'job_position',
                    'salary',
                    'age',
                    'start_date',
                    'resign_date',
                    'is_active',
                    'tunjangan_transport',
                    'tunjangan_kesehatan',
                    'tunjangan_lainnya',
                    'salary_total',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('location_name', [$this->office])
                ->get();
        } elseif ($this->department && $this->office) {
            return DB::table('v_employee')
                ->select(
                    'id',
                    'nik',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'location_name',
                    'department_name',
                    'job_position',
                    'salary',
                    'age',
                    'start_date',
                    'resign_date',
                    'is_active',
                    'tunjangan_transport',
                    'tunjangan_kesehatan',
                    'tunjangan_lainnya',
                    'salary_total',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('location_name', [$this->office])
                ->where('department_name', [$this->department])
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Nik',
            'Nama',
            'Alamat',
            'Nomor HP',
            'Email',
            'Kantor',
            'Department',
            'Posisi',
            'Gaji Pokok',
            'Umur',
            'Tanggal Mulai Kerja',
            'Tanggal Resign',
            'Aktif',
            'Tunjangan Transport',
            'Tunjangan Kesehatan',
            'Tunjangan Lainnya',
            'Total Gaji',
            'created_at',
            'updated_by',
            'updated_at',
            'created_by'
        ];
    }

    public function title(): string
    {
        return 'Data Karyawan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Karyawan PT Sahabat Group Auto');
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->setCellValue('A2', 'Kantor : ' . $this->office);
                $event->sheet->setCellValue('A3', 'Department : ' . $this->department);
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true);
                $event->sheet->getStyle('A3:H2')->getFont()->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true);
                $event->sheet->getStyle('A3:H2')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:W4')->getFont()->setBold(true);
            },
        ];
    }
}
