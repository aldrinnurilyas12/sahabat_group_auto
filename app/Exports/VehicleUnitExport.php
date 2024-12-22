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


class VehicleUnitExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($selected_data, $location_unit, $category_name)
    {
        $this->selected_data = $selected_data;
        $this->location_unit = $location_unit;
        $this->category_name = $category_name; // Ganti $users dengan $employee_id
    }


    public function collection()
    {


        if ($this->location_unit == 'alldata' && $this->category_name == 'alldata') {
            return DB::table('v_vehicle')
                ->get();
        } elseif ($this->category_name == 'alldata') {
            return DB::table('v_vehicle')
                ->where('location_unit', [$this->location_unit])
                ->get();
        } elseif ($this->location_unit == 'alldata') {
            return DB::table('v_vehicle')
                ->where('category_name', [$this->category_name])
                ->get();
        } elseif ($this->location_unit && $this->category_name) {
            return DB::table('v_vehicle')
                ->where('location_unit', [$this->location_unit])
                ->where('category_name', [$this->category_name])
                ->get();
        } else {
            return DB::table('v_vehicle')
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            'No',
            'No.Pol',
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
            'Nomor Rangka',
            'Nomor Mesin',
            'Nomor Coding',
            'Warna Plat Nomor',
            'No.Pol Lama',
            'Tahun Pendaftaran',
            'Tanggal Pajak',
            'Nomor BPKB',
            'Kode Lokasi',
            'Nomor Antrian Kendaraan',
            'Nama Pemilik',
            'Alamat',
            'Lokasi Unit',
            'Status Unit',
            'Tanggal',
            'Diupdate',
            'Tanggal Update',
            'Dibuat'
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
                $event->sheet->setCellValue('A1', 'Data Unit Kendaraan ' . ' ' . $this->location_unit . ' ' . ' - ' . "Kategori : " . $this->category_name); // Set custom title at the top of the sheet
                $event->sheet->mergeCells('A1:L1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true); // Bold headers
            },
        ];
    }
}
