<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Warga;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Log;

class TagihanController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan;
        $query = Tagihan::with(['warga.rt', 'pembayarans']);

        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        $tagihans = $query->get();

        $laporan = [];

        foreach ($tagihans as $tagihan) {
            // Menghitung total pembayaran hanya untuk bulan yang sama
            $totalPembayaranBulanIni = $tagihan->pembayarans->where('bulan', $tagihan->bulan)->sum('jumlah_dibayar');
            $belumTerbayar = max(0, $tagihan->jumlah_tagihan - $totalPembayaranBulanIni);
            $status = ($totalPembayaranBulanIni >= $tagihan->jumlah_tagihan) ? 'Lunas' : 'Belum Lunas';

            $laporan[] = [
                'tagihan' => $tagihan,
                'warga' => $tagihan->warga->nama,
                'rt' => $tagihan->warga->rt->nama_rt,
                'jumlah_tagihan' => (float)$tagihan->jumlah_tagihan,
                'total_terbayar' => (float)$totalPembayaranBulanIni,
                'belum_terbayar' => (float)$belumTerbayar,
                'status' => $status,
            ];
        }

        return view('tagihans.index', compact('laporan', 'bulan'));
    }

    public function create()
    {
        $wargas = Warga::with('rt')->get();
        return view('tagihans.create', compact('wargas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:wargas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah_tagihan' => 'required|numeric',
            'tanggal_bayar' => 'nullable|date',
        ]);

        // Cek apakah sudah ada tagihan untuk bulan dan tahun yang sama
        $existingTagihan = Tagihan::where('id_warga', $request->id_warga)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->first();

        if ($existingTagihan) {
            return redirect()->route('tagihans.create')->withErrors(['error' => 'Tagihan untuk bulan dan tahun yang dipilih sudah ada.']);
        }

        Tagihan::create($request->all());
        return redirect()->route('tagihans.index')->with('success', 'Data tagihan berhasil dibuat.');
    }

    public function edit(Tagihan $tagihan)
    {
        $wargas = Warga::with('rt')->get();
        return view('tagihans.edit', compact('tagihan', 'wargas'));
    }

    public function update(Request $request, Tagihan $tagihan)
    {
        $request->validate([
            'id_warga' => 'required|exists:wargas,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer',
            'jumlah_tagihan' => 'required|numeric',
            'tanggal_bayar' => 'nullable|date',
        ]);

        $tagihan->update($request->all());
        return redirect()->route('tagihans.index')->with('success', 'Data tagihan berhasil diperbarui.');
    }

    public function destroy(Tagihan $tagihan)
    {
        $tagihan->delete();
        return redirect()->route('tagihans.index')->with('success', 'Data tagihan berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $bulan = $request->query('bulan');
        Log::info('Bulan yang dipilih: ' . $bulan);

        // Ambil data tagihan berdasarkan bulan
        $query = Tagihan::with(['warga', 'warga.rt', 'pembayarans']);
        if ($bulan) {
            $query->where('bulan', $bulan);
        }
        $tagihans = $query->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['No', 'Nama Warga', 'RT', 'Tagihan untuk Bulan', 'Tahun', 'Jumlah Tagihan', 'Total Terbayar', 'Belum Terbayar', 'Status'];
        $sheet->fromArray($headers, null, 'A1');

        $rowNumber = 2;
        $no = 1;
        foreach ($tagihans as $tagihan) {
            $totalPembayaranBulanIni = $tagihan->pembayarans->where('bulan', $tagihan->bulan)->sum('jumlah_dibayar');
            $belumTerbayar = max(0, $tagihan->jumlah_tagihan - $totalPembayaranBulanIni);
            $status = ($totalPembayaranBulanIni >= $tagihan->jumlah_tagihan) ? 'Lunas' : 'Belum Lunas';

            $sheet->setCellValue('A' . $rowNumber, $no);
            $sheet->setCellValue('B' . $rowNumber, $tagihan->warga->nama);
            $sheet->setCellValue('C' . $rowNumber, $tagihan->warga->rt->nama_rt);
            $sheet->setCellValue('D' . $rowNumber, date('F', mktime(0, 0, 0, $tagihan->bulan, 1)));
            $sheet->setCellValue('E' . $rowNumber, $tagihan->tahun);
            $sheet->setCellValue('F' . $rowNumber, (float)$tagihan->jumlah_tagihan);
            $sheet->setCellValue('G' . $rowNumber, (float)$totalPembayaranBulanIni);
            $sheet->setCellValue('H' . $rowNumber, (float)$belumTerbayar);
            $sheet->setCellValue('I' . $rowNumber, $status);

            $sheet->getStyle('A' . $rowNumber . ':I' . $rowNumber)->applyFromArray([
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            $rowNumber++;
            $no++;
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => '0d6efd'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        $allBorders = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle('A1:I' . ($rowNumber - 1))->applyFromArray($allBorders);

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'riwayat_tagihan_' . $bulan . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        $writer->save('php://output');
        exit;
    }
}
