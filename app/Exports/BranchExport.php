<?php

namespace App\Exports;

use App\Models\EmployeeAttedanceModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;


class BranchExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function collection()
    {
        // Ambil data kehadiran yang difilter berdasarkan bulan, tahun, dan employee_id
        return DB::table('v_branch')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Cabang ID',
            'Kode Lokasi',
            'Nama Lokasi',
            'Alamat',
            'No.Telepon',
            'Kepala Cabang',
            'Total Karyawan',
            'Total Unit Kendaraan',
            'Total Unit Ready',
            'Total Unit Terjual',
            'Total Unit Pengajuan Kredit',
            'Total Unit Dalam Perbaikan',
            'Koornidat',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah pada',
            'Diubah oleh'
        ];
    }

    public function title(): string
    {
        return 'Data Cabang'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Cabang PT Sahabat Group Auto');
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true);

                // CODE UNTUK AUTO-SIZE COLUMN
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
