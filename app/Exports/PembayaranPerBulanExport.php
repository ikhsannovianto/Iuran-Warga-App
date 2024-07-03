<?php

namespace App\Exports;

use App\Models\Pembayaran;
use DateTime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PembayaranPerBulanExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping, ShouldAutoSize
{
    protected $bulan;
    protected $filterDescription;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
        $this->filterDescription = !empty($this->bulan) ? 'Filter: ' . DateTime::createFromFormat('!m', $this->bulan)->format('F') : 'Filter: Semua Data';
    }

    public function collection()
    {
        $query = Pembayaran::with(['warga', 'warga.rt']);

        if (!empty($this->bulan)) {
            $query->whereMonth('tanggal_bayar', $this->bulan);
        }

        $pembayarans = $query->get();

        return $pembayarans;
    }

    public function map($pembayaran): array
    {
        return [
            $pembayaran->warga->nama,
            $pembayaran->warga->rt->nama_rt,
            $pembayaran->warga->tagihans->isNotEmpty() ? $pembayaran->warga->tagihans->first()->jumlah_tagihan : 0,
            DateTime::createFromFormat('!m', $pembayaran->bulan)->format('F'),
            $pembayaran->jumlah_dibayar,
            $pembayaran->tanggal_bayar,
            $pembayaran->metode_pembayaran,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Warga',
            'RT',
            'Jumlah Tagihan',
            'Bulan',
            'Jumlah Bayar',
            'Tanggal Bayar',
            'Metode Pembayaran',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function styles(Worksheet $sheet)
    {
        // Set font to Times New Roman for entire sheet
        $sheet->getParent()->getDefaultStyle()->getFont()->setName('Times New Roman');

        // Style for the title
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'Riwayat Pembayaran Per Bulan');
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style for the filter description
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', $this->filterDescription);
        $sheet->getStyle('A2:G2')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style for the headers with background color
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0275D8'], // Dark Blue
            ],
        ]);

        // Center align all columns
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A3:G' . $lastRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Add borders to the entire table
        $sheet->getStyle('A3:G' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Set number format for 'Jumlah Tagihan' and 'Jumlah Bayar' columns
        $sheet->getStyle('C4:C' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E4:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
    }
}
