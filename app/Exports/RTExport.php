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
use PhpOffice\PhpSpreadsheet\Style\Font;

class RTExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping
{
    private $rowNumber;

    public function __construct()
    {
        $this->rowNumber = 0;
    }

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
        $this->rowNumber++;
        return [
            $this->rowNumber,
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
            ['Manajemen RT'], // Additional title row
            ['No', 'Nama RT', 'Alamat', 'Ketua RT'] // Table headers
        ];
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        return 'A1';
    }

    /**
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Merge cells for additional title
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style for table headers
        $sheet->getStyle('A2:D2')->applyFromArray([
            'font' => [
                'name' => 'Times New Roman',
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0275D8'],
            ],
        ]);

        // Border for table headers and data
        $sheet->getStyle('A2:D' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Center alignment for table headers and data
        $sheet->getStyle('A2:D' . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Font for table data
        $sheet->getStyle('A3:D' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman');

        // Autosize columns based on content
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }
}
