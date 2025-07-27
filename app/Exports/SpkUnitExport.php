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

class SpkUnitExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{

    public function __construct($branch_request, $bulan, $tahun)
    {
        $this->month = $bulan;
        $this->year = $tahun;
        $this->branch = $branch_request;
    }


    public function collection()
    {


        if ($this->branch == 'alldata' && $this->month == 'alldata' && $this->year == 'alldata') {
            return DB::table('v_spk')
                ->select(
                    'unit',
                    'location_unit',
                    'payment_method',
                    'price',
                    'price_nominal',
                    'down_payment',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'approval_by_head_branch',
                    'approval_by_sales_manager',
                    'spk_status',
                    'spk_confirmation_date',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        } elseif ($this->branch) {
            return DB::table('v_spk')
                ->select(
                    'unit',
                    'location_unit',
                    'payment_method',
                    'price',
                    'price_nominal',
                    'down_payment',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'approval_by_head_branch',
                    'approval_by_sales_manager',
                    'spk_status',
                    'spk_confirmation_date',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->where('location_unit', [$this->branch])
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        } elseif ($this->branch && $this->bulan && $this->tahun) {
            return DB::table('v_spk')
                ->select(
                    'unit',
                    'location_unit',
                    'payment_method',
                    'price',
                    'price_nominal',
                    'down_payment',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'approval_by_head_branch',
                    'approval_by_sales_manager',
                    'spk_status',
                    'spk_confirmation_date',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->where('location_unit', [$this->branch])
                ->whereRaw('MONTH(spk_confirmation_date) = ?', [$this->month])
                ->whereRaw('YEAR(spk_confirmation_date) = ?', [$this->year])
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        } elseif ($this->branch === 'alldata') {
            return DB::table('v_spk')
                ->select(
                    'unit',
                    'location_unit',
                    'payment_method',
                    'price',
                    'price_nominal',
                    'down_payment',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'approval_by_head_branch',
                    'approval_by_sales_manager',
                    'spk_status',
                    'spk_confirmation_date',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        } else {
            return DB::table('v_spk')
                ->select(
                    'unit',
                    'location_unit',
                    'payment_method',
                    'price',
                    'price_nominal',
                    'down_payment',
                    'name',
                    'address',
                    'phone_number',
                    'email',
                    'approval_by_head_branch',
                    'approval_by_sales_manager',
                    'spk_status',
                    'spk_confirmation_date',
                    'created_at',
                    'created_by',
                    'updated_at',
                    'updated_by'
                )
                ->where('approval_by_head_branch', 'Sudah Konfirmasi')
                ->where('approval_by_sales_manager', 'Sudah Konfirmasi')
                ->orderBy('spk_confirmation_date', 'DESC')->get();
        }
    }



    public function headings(): array
    {
        return  [
            'Unit',
            'Cabang',
            'Pembayaran',
            'Harga',
            'Terbilang',
            'Uang DP',
            'Customer',
            'Alamat',
            'No.Telepon',
            'Email',
            'Approve by Kepala Cabang',
            'Approve by Sales Manager',
            'SPK Status',
            'Tanggal SPK',
            'Dibuat pada',
            'Dibuat oleh',
            'Diupdate pada',
            'Diupdate oleh'

        ];
    }

    public function title(): string
    {
        return 'Data SPK Unit Kendaraan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data SPK Unit Kendaraan');
                $event->sheet->setCellValue('A2', 'Cabang : ' . $this->branch);
                $event->sheet->setCellValue('A3', 'Bulan : ' . $this->month);
                $event->sheet->setCellValue('B3', 'Tahun: ' . $this->year);
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
