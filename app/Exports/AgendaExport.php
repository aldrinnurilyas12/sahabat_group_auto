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


class AgendaExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($offices, $bulan, $tahun)
    {


        $this->office = $offices;
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }


    public function collection()
    {


        if ($this->office == 'alldata' && $this->bulan == 'alldata' && $this->tahun == 'alldata') {
            return  DB::table('v_agenda as va')
                ->select(
                    'va.branch',
                    'va.department_name',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        } elseif ($this->office && $this->bulan && $this->tahun) {
            return  DB::table('v_agenda as va')
                ->select(
                    'va.branch',
                    'va.department_name',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->where('location_name', $this->office)->whereRaw('MONTH(agenda_date) = ?', [$this->bulan])
                ->whereRaw('YEAR(agenda_date) = ?', [$this->tahun])
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        } else {
            return  DB::table('v_agenda as va')
                ->select(
                    'va.branch',
                    'va.department_name',
                    'va.meeting_leader',
                    've.name',
                    'va.agenda_name',
                    'va.agenda_date',
                    'va.reasons',
                    'va.start_time',
                    'va.status',
                    'va.end_time',
                    'va.created_at',
                    'va.created_by',
                    'va.updated_by',
                    'va.updated_at'
                )
                ->leftJoin('v_employee as ve', 'va.meeting_leader', '=', 've.nik')
                ->orderBy('created_at', 'DESC')->get();
        }
    }

    public function headings(): array
    {
        return [
            'Kantor',
            'Department',
            'NIK',
            'Pemimpin Meeting',
            'Agenda',
            'Tanggal Agenda',
            'Status',
            'Alasan',
            'Jam Mulai',
            'Jam Akhir',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah Oleh',
            'Diubah Pada'
        ];
    }

    public function title(): string
    {
        return 'Data Agenda'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Agenda PT Sahabat Group Auto');
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
