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


class EticketExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function __construct($bulan, $tahun)
    {
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }


    public function collection()
    {
        if ($this->bulan == 'alldata' && $this->tahun == 'alldata') {
            return DB::table('v_eticket')
                ->select(
                    'id',
                    'eticket_code',
                    'nik',
                    'name',
                    'title',
                    'eticket_category',
                    'status',
                    'main_issue',
                    'attachment_files',
                    'approval_by_it',
                    'task_complete_date',
                    'scheduled',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                )
                ->orderBy('created_at', 'DESC')
                ->get();
        } elseif ($this->tahun) {

            return DB::table('v_eticket')
                ->select(
                    'id',
                    'eticket_code',
                    'nik',
                    'name',
                    'title',
                    'eticket_category',
                    'status',
                    'main_issue',
                    'attachment_files',
                    'approval_by_it',
                    'task_complete_date',
                    'scheduled',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                )
                ->whereRaw('YEAR(created_at) = ?', [$this->tahun])
                ->orderBy('created_at', 'DESC')
                ->get();
        } elseif ($this->bulan && $this->tahun) {
            return DB::table('v_eticket')
                ->select(
                    'id',
                    'eticket_code',
                    'nik',
                    'name',
                    'title',
                    'eticket_category',
                    'status',
                    'main_issue',
                    'attachment_files',
                    'approval_by_it',
                    'task_complete_date',
                    'scheduled',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                )
                ->whereRaw('MONTH(created_at) = ?', [$this->bulan])
                ->whereRaw('YEAR(created_at) = ?', [$this->tahun])
                ->orderBy('created_at', 'DESC')
                ->get();
        } else {
            return DB::table('v_eticket')
                ->select(
                    'id',
                    'eticket_code',
                    'nik',
                    'name',
                    'title',
                    'eticket_category',
                    'status',
                    'main_issue',
                    'attachment_files',
                    'approval_by_it',
                    'task_complete_date',
                    'scheduled',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by'
                )
                ->orderBy('created_at', 'DESC')
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Tiket',
            'NIK',
            'Nama Karyawan',
            'Judul Tiket',
            'Kat.Tiket',
            'Status',
            'Permasalahan',
            'Attachment',
            'Approve by IT',
            'Tanggal Selesai',
            'Jadwal',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah pada',
            'Diubah oleh'
        ];
    }

    public function title(): string
    {
        return 'Data E-Ticket PT Sahabat Group Auto'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data E-Ticket');
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->bulan);
                $event->sheet->setCellValue('B2', 'Tahun: ' . $this->tahun);
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1:C1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A3:P3')->getFont()->setBold(true);
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