<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Maatwebsite\Excel\Events\AfterSheet;

class PendapatanPerMetodeSheet implements FromCollection, WithTitle, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    protected $pembayaranPerMetode;

    public function __construct($pembayaranPerMetode)
    {
        $this->pembayaranPerMetode = $pembayaranPerMetode;
    }

    public function collection()
    {
        return collect($this->pembayaranPerMetode);
    }

    public function title(): string
    {
        return 'Pendapatan Per Metode';
    }

    public function headings(): array
    {
        return [
            ['Pendapatan per Metode'], 
            ['Metode Pembayaran', 'Total Pendapatan (Rp)'], 
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for the title
        $sheet->mergeCells('A1:B1');
        $sheet->setCellValue('A1', 'Pendapatan per Metode');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '000000'], // Black
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Styling for headers
        $sheet->getStyle('A2:B2')->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // White
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0275D8'], // Dark Blue
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Styling for all data
        $sheet->getStyle('A3:B' . ($this->collection()->count() + 2))->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Borders for all data
        $sheet->getStyle('A2:B' . ($this->collection()->count() + 2))
              ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Autosize columns A and B
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach (range('A', 'B') as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
