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

class TestimonialCustomersExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($bulan, $tahun)
    {
        $this->month = $bulan;
        $this->year = $tahun;
    }


    public function collection()
    {

        if ($this->month == 'alldata' && $this->year == 'alldata') {
            return DB::table('customers_testimonial')
                ->orderBy('created_at', 'desc')->get();
        } elseif ($this->year) {
            return DB::table('customers_testimonial')
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->orderBy('created_at', 'desc')->get();
        } elseif ($this->bulan && $this->tahun) {
            return DB::table('customers_testimonial')
                ->whereRaw('MONTH(created_at) = ?', [$this->month])
                ->whereRaw('YEAR(created_at) = ?', [$this->year])
                ->orderBy('created_at', 'desc')->get();
        } else {
            return DB::table('customers_testimonial')
                ->orderBy('created_at', 'desc')->get();
        }
    }



    public function headings(): array
    {
        return  [
            'No/ID',
            'Nama Customer',
            'Email',
            'Testimonial',
            'Rating',
            'Kritik dan Saran',
            'Nama Disembunyikan',
            'created_at',
            'updated_at'

        ];
    }

    public function title(): string
    {
        return 'Data Testimonial'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Testimonial Customers');
                $event->sheet->setCellValue('A2', 'Bulan : ' . $this->month);
                $event->sheet->setCellValue('A3', 'Tahun: ' . $this->year);
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1:C1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A4:R4')->getFont()->setBold(true);
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
