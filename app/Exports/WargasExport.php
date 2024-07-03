<?php

namespace App\Exports;

use App\Models\Warga;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class WargasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    private $rowNumber; // Variabel untuk menyimpan nomor baris.

    public function __construct()
    {
        $this->rowNumber = 0; // Menginisialisasi nomor baris awal.
    }

    public function collection()
    {
        return Warga::with('rt')->get(); // Mengambil semua data Warga beserta relasi RT.
    }

    public function headings(): array
    {
        return [
            ['Daftar Warga'], // Judul tambahan di atas tabel (merge sel A1 dengan H1).
            ['No', 'Nama', 'Alamat', 'No Telp', 'Email', 'RT', 'Dibuat Pada', 'Diperbarui Pada'] // Header kolom tabel.
        ];
    }
// asd
    public function map($warga): array
    {
        $this->rowNumber++; // Increment nomor baris.

        // Mengembalikan array yang berisi nilai untuk setiap kolom pada baris saat ini.
        return [
            $this->rowNumber, // Nomor baris.
            $warga->nama, // Nama warga.
            $warga->alamat, // Alamat warga.
            $warga->no_telp, // Nomor telepon warga.
            $warga->email, // Email warga.
            $warga->rt ? $warga->rt->nama_rt : 'Tidak ada RT', // Nama RT atau pesan jika tidak ada RT.
            Carbon::parse($warga->created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Tanggal dibuat dengan zona waktu Asia/Jakarta.
            Carbon::parse($warga->updated_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Tanggal diperbarui dengan zona waktu Asia/Jakarta.
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur gaya untuk seluruh sheet.

        // Menggabungkan sel A1 sampai H1 untuk judul tambahan.
        $sheet->mergeCells('A1:H1');

        // Mengatur gaya untuk sel A1.
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

        // Mengatur gaya untuk sel A2 sampai H2 (header kolom).
        $sheet->getStyle('A2:H2')->applyFromArray([
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

        // Mengatur gaya untuk border dari sel A2 sampai sel terakhir yang terisi data.
        $sheet->getStyle('A2:H' . $sheet->getHighestRow())
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        // Mengatur alignment horizontal dan vertical untuk sel A3 sampai sel terakhir yang terisi data.
        $sheet->getStyle('A3:H' . $sheet->getHighestRow())
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Mengatur font untuk isi data (sel A3 sampai sel terakhir yang terisi data).
        $sheet->getStyle('A3:H' . $sheet->getHighestRow())
            ->getFont()
            ->setName('Times New Roman');

        return []; // Mengembalikan array kosong karena tidak ada pengaturan tambahan yang perlu dikembalikan.
    }

    public function title(): string
    {
        return 'Daftar Warga'; // Judul sheet dalam file Excel.
    }
}
