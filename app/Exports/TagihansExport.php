<?php

namespace App\Exports;

use App\Models\Tagihan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class TagihansExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $bulan;

    public function __construct($bulan = null)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        $query = Tagihan::with(['warga', 'warga.rt', 'pembayarans']);

        if ($this->bulan) {
            $query->where('bulan', $this->bulan);
        }

        return $query->get()->map(function ($tagihan) {
            $jumlahTagihan = $tagihan->jumlah_tagihan;
            $totalPembayaran = $tagihan->pembayarans->sum('jumlah_dibayar');
            $belumTerbayar = max(0, $jumlahTagihan - $totalPembayaran);
            $status = ($totalPembayaran >= $jumlahTagihan) ? 'Lunas' : 'Belum Lunas';

            return [
                'No' => $tagihan->id,
                'Nama Warga' => $tagihan->warga->nama,
                'RT' => $tagihan->warga->rt->nama_rt,
                'Tagihan untuk Bulan' => date('F', mktime(0, 0, 0, $tagihan->bulan, 1)),
                'Tahun' => $tagihan->tahun,
                'Jumlah Tagihan' => $jumlahTagihan,
                'Total Terbayar' => $totalPembayaran,
                'Belum Terbayar' => $belumTerbayar,
                'Status' => $status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['Riwayat Tagihan'], // Additional title row
            ['No', 'Nama Warga', 'RT', 'Tagihan untuk Bulan', 'Tahun', 'Jumlah Tagihan', 'Total Terbayar', 'Belum Terbayar', 'Status']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cells for additional title
        $sheet->mergeCells('A1:I1');
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
        $sheet->getStyle('A2:I2')->applyFromArray([
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
        $sheet->getStyle('A2:I' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Center alignment for table headers and data
        $sheet->getStyle('A2:I' . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Font for table data
        $sheet->getStyle('A3:I' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman');
    }
}
