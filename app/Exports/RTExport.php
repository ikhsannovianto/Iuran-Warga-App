<?php

namespace App\Exports;

use App\Models\RT;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RTExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return RT::all();
    }

    /**
     * @param mixed $rt
     * @return array
     */
    public function map($rt): array
    {
        static $number = 0;
        $number++;
        return [
            $number,
            $rt->nama_rt,
            $rt->alamat,
            $rt->ketua_rt,
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama RT',
            'Alamat',
            'Ketua RT',
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'B5';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');

        $sheet->mergeCells('B2:E3');
        $sheet->setCellValue('B2', 'Manajemen RT');
        $sheet->getStyle('B2:E3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '8DB4E2'],
            ],
        ]);

        $sheet->getStyle('B5:E5')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'B8CCE4'],
            ],
        ]);

        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('B6:E' . $lastRow)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DCE6F1'],
            ],
        ]);

        $sheet->getStyle('B6:B' . $lastRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('B2:E' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        foreach (range('B', 'E') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}