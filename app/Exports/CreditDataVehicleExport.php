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


class CreditDataVehicleExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */


    public function __construct($vehicle_id)
    {
        $this->vehicle_id = $vehicle_id;
    }

    public function collection()
    {


        if ($this->vehicle_id == 'alldata') {
            return DB::table('v_credit_simulation')
                ->select(
                    'id',
                    'unit',
                    'price',
                    'credit_price',
                    'total_down_payment',
                    'down_payment',
                    'insurance_name',
                    'tenor_12_month',
                    'tenor_24_month',
                    'tenor_36_month',
                    'tenor_48_month',
                    'tenor_60_month',
                    'tenor_72_month',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->get();
        } elseif ($this->vehicle_id)
            return DB::table('v_credit_simulation')
                ->select(
                    'id',
                    'unit',
                    'price',
                    'credit_price',
                    'total_down_payment',
                    'down_payment',
                    'insurance_name',
                    'tenor_12_month',
                    'tenor_24_month',
                    'tenor_36_month',
                    'tenor_48_month',
                    'tenor_60_month',
                    'tenor_72_month',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('vehicle_id', [$this->vehicle_id])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Unit',
            'Harga Cash',
            'Harga Kredit',
            'Total Harga DP',
            'Buaya DP',
            'Nama Asuransi',
            'Tenor 12 Bulan',
            'Tenor 24 Bulan',
            'Tenor 36 Bulan',
            'Tenor 48 Bulan',
            'Tenor 60 Bulan',
            'Tenor 72 Bulan',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah pada',
            'Diubah oleh'
        ];
    }

    public function title(): string
    {
        return 'Data Kredit Unit'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Kredit Unit PT Sahabat Group Auto');
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