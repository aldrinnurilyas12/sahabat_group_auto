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


class SubmenuExport implements FromCollection, WithHeadings, WithTitle, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($parent_id)
    {
        $this->parent_id = $parent_id;
    }


    public function collection()
    {
        // Ambil data kehadiran yang difilter berdasarkan bulan, tahun, dan employee_id
        return DB::table('v_submenu')
            ->select(
                'id',
                'submenu_name',
                'submenu_link',
                'menu_name',
                'admin_role',
                'superadmin_role',
                'branch_head_role',
                'submenu_aktif',
                'created_at',
                'created_by',
                'updated_at',
                'updated_by'
            )
            ->where('parent_id', $this->parent_id)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Submenu ID',
            'Nama Submenu',
            'Link Submenu',
            'Nama Menu',
            'Role Admin',
            'Role Super Admin',
            'Role Head Branch',
            'Status Aktif',
            'Dibuat pada',
            'Dibuat oleh',
            'Diubah pada',
            'Diubah oleh'
        ];
    }

    public function title(): string
    {
        return 'Data Department'; // Nama atau judul sheet
    }

    public function registerEvents(): array
    {
        return [
            // Event before sheet is created, you can set titles, etc.
            BeforeSheet::class => function (BeforeSheet $event) {
                // Set title for the sheet (optional)
                $event->sheet->setCellValue('A1', 'Data Submenu Web Admin PT Sahabat Group Auto');
                $event->sheet->mergeCells('A1:O1'); // Merge cells for the title
                $event->sheet->getStyle('A1')->getFont()->setSize(16)->setBold(true); // Optional styling for title
            },
            // You can also customize formatting for other parts of the sheet (e.g., bold headers)
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A2:AF2')->getFont()->setBold(true);
            },
        ];
    }
}
