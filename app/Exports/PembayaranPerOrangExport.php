<?php

namespace App\Exports;

use App\Models\Pembayaran;
use App\Models\Warga;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PembayaranPerOrangExport implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, WithMapping
{
    protected $idWarga;
    protected $namaWarga;
    protected $filterDescription;


    public function __construct($idWarga)
    {
        $this->idWarga = $idWarga;

        // Fetch the name of the resident (warga)
        if (!empty($this->idWarga)) {
            $warga = Warga::find($this->idWarga);
            $this->namaWarga = $warga ? $warga->nama : null;
        }

        // Set filter description based on whether a resident is specified
        $this->filterDescription = !empty($this->namaWarga) ? 'Filter: ' . $this->namaWarga : 'Filter: Semua Data';
    }

    public function collection()
    {
        $pembayarans = Pembayaran::with(['warga', 'warga.rt'])
            ->when($this->idWarga, function ($query) {
                $query->where('id_warga', $this->idWarga);
            })
            ->get();

        return $pembayarans;
    }

    public function map($pembayaran): array
    {
        return [
            $pembayaran->warga->nama,
            $pembayaran->warga->rt->nama_rt,
            $pembayaran->warga->tagihans->isNotEmpty() ? $pembayaran->warga->tagihans->first()->jumlah_tagihan : 0,
            \DateTime::createFromFormat('!m', $pembayaran->bulan)->format('F'),
            $pembayaran->jumlah_dibayar,
            $pembayaran->tanggal_bayar,
            $pembayaran->metode_pembayaran,
        ];
    }

    public function headings(): array
    {
        return [
            'Warga',
            'RT',
            'Tagihan',
            'Untuk Bulan',
            'Jumlah Bayar',
            'Tanggal',
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
        $sheet->setCellValue('A1', 'Riwayat Pembayaran Per Orang');
        $sheet->getStyle('A1:G1')->applyFromArray([
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
                'startColor' => ['rgb' => 'D3D3D3'], // Light grey
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
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'F0F0F0'], // Very light grey
            ],
        ]);

        // Style for the headers
        $sheet->getStyle('A3:G3')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'A9A9A9'], // Dark grey
            ],
        ]);

        // Style for data cells
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A4:G' . $lastRow)->applyFromArray([
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DCDCDC'], // Gainsboro
            ],
        ]);

        // Center align all columns
        $sheet->getStyle('A4:G' . $lastRow)->applyFromArray([
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        // Add borders to the entire table
        $sheet->getStyle('A1:G' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Auto-size columns
        foreach (range('A', 'G') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set number format for 'Tagihan' and 'Jumlah Bayar' columns
        $sheet->getStyle('C4:C' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('E4:E' . $lastRow)->getNumberFormat()->setFormatCode('#,##0');
    }
}
