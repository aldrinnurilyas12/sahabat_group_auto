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
use Illuminate\Support\Facades\Schema;


class VehicleUnitExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($selected_data, $location_unit, $status_vehicle)
    {
        $this->selected_data = $selected_data;
        $this->location_unit = $location_unit;
        $this->status_vehicle = $status_vehicle; // Ganti $users dengan $employee_id
    }


    public function collection()
    {
        $columns = Schema::getColumnListing('v_vehicle');
        $columns = array_filter($columns, fn($col) => $col !== 'location_name');
        if ($this->location_unit == 'alldata' && $this->status_vehicle == 'alldata') {
            return DB::table('v_vehicle')->select($columns)
                ->get();
        } elseif ($this->status_vehicle == 'alldata') {
            return DB::table('v_vehicle')->select($columns)
                ->where('location_unit', [$this->location_unit])
                ->get();
        } elseif ($this->location_unit == 'alldata') {
            return DB::table('v_vehicle')->select($columns)
                ->where('status_vehicle', [$this->status_vehicle])
                ->get();
        } elseif ($this->location_unit && $this->status_vehicle) {
            return DB::table('v_vehicle')->select($columns)
                ->where('location_unit', [$this->location_unit])
                ->where('status_vehicle', [$this->status_vehicle])
                ->get();
        } elseif ($this->status_vehicle) {
            return DB::table('v_vehicle')->select($columns)
                ->where('status_vehicle', [$this->status_vehicle])
                ->get();
        } elseif ($this->location_unit) {
            return DB::table('v_vehicle')->select($columns)
                ->where('location_unit', [$this->location_unit])
                ->get();
        } else {
            return DB::table('v_vehicle')->select($columns)
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Kendaraan',
            'No.Pol',
            'Unit',
            'Harga',
            'Harga Kredit',
            'Merk',
            'Brand',
            'Tahun',
            'kategori',
            'Model',
            'Warna',
            'KM saat ini',
            'Bahan Bakar',
            'kapasitas silinder',
            'Transmisi',
            'Kunci Cadangan',
            'Buku Servis',
            'Nomor Rangka',
            'Nomor Mesin',
            'Nomor Coding',
            'Warna Plat Nomor',
            'No.Pol Lama',
            'Tahun Pendaftaran',
            'Tanggal Pajak',
            'Nomor BPKB',
            'Kode Lokasi',
            'Status Unit',
            'Nomor Antrian Kendaraan',
            'Nama Pemilik',
            'Alamat',
            'Lokasi Unit',
            'Pembayaran Melalui',
            'Tanggal buat',
            'Diupdate oleh',
            'Tanggal Update',
            'Dibuat oleh'
        ];
    }

    public function title(): string
    {
        return 'Data unit kendaraan'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Unit Kendaraan ' . ' ' . $this->location_unit . ' ' . ' - ' . "Kategori : " . $this->status_vehicle); // Set custom title at the top of the sheet
                $event->sheet->mergeCells('A1:L1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AK2')->getFont()->setBold(true); // Bold headers
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
