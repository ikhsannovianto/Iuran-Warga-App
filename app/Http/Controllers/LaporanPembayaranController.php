<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPembayaranExport;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\RT;
use Illuminate\Support\Facades\DB;
use App\Exports\LaporanPembayaranExportPDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPembayaranPDF;
use PDF;
use Mpdf\Mpdf;

class LaporanPembayaranController extends Controller
{
    public function index()
    {
        // Mengambil total pendapatan dari semua pembayaran
        $totalPendapatan = Pembayaran::sum('jumlah_dibayar');

        // Mengambil total pendapatan per bulan
        $pendapatanPerBulan = Pembayaran::select(
            DB::raw('MONTH(tanggal_bayar) as bulan'),
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy(DB::raw('MONTH(tanggal_bayar)'))->get();

        // Membuat array dengan semua bulan
        $allMonths = collect([
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June',
            7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ]);

        // Mencocokkan pendapatan per bulan dengan semua bulan
        $pendapatanPerBulan = $allMonths->map(function($monthName, $monthNumber) use ($pendapatanPerBulan) {
            $monthData = $pendapatanPerBulan->firstWhere('bulan', $monthNumber);
            return [
                'bulan' => $monthNumber,
                'nama_bulan' => $monthName,
                'total' => $monthData ? $monthData->total : 0
            ];
        });

        // Mengambil jumlah pembayaran per metode
        $pembayaranPerMetode = Pembayaran::select(
            'metode_pembayaran',
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy('metode_pembayaran')->get();

        // Mengambil total pembayaran per RT
        $totalPembayaranPerRT = RT::select('rts.nama_rt', DB::raw('SUM(pembayarans.jumlah_dibayar) as total_pembayaran'))
            ->leftJoin('wargas', 'rts.id', '=', 'wargas.id_rt')
            ->leftJoin('pembayarans', 'wargas.id', '=', 'pembayarans.id_warga')
            ->groupBy('rts.nama_rt')
            ->get();

        return view('laporan_pembayaran.index', compact('totalPendapatan', 'pendapatanPerBulan', 'pembayaranPerMetode', 'totalPembayaranPerRT'));
    }
    public function export()
    {
        $totalPendapatan = Pembayaran::sum('jumlah_dibayar');
        
        $pendapatanPerBulan = Pembayaran::select(
            DB::raw('MONTH(tanggal_bayar) as bulan'),
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy(DB::raw('MONTH(tanggal_bayar)'))->get()->map(function($item) {
            return [
                'Bulan' => $item->bulan,
                'Total' => $item->total
            ];
        });

        $pembayaranPerMetode = Pembayaran::select(
            'metode_pembayaran',
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy('metode_pembayaran')->get()->map(function($item) {
            return [
                'Metode Pembayaran' => $item->metode_pembayaran,
                'Total' => $item->total
            ];
        });

        $totalPembayaranPerRT = RT::select('rts.nama_rt', DB::raw('SUM(pembayarans.jumlah_dibayar) as total_pembayaran'))
            ->leftJoin('wargas', 'rts.id', '=', 'wargas.id_rt')
            ->leftJoin('pembayarans', 'wargas.id', '=', 'pembayarans.id_warga')
            ->groupBy('rts.nama_rt')
            ->get()->map(function($item) {
                return [
                    'Nama RT' => $item->nama_rt,
                    'Total Pembayaran' => $item->total_pembayaran
                ];
            });

        return Excel::download(new LaporanPembayaranExport($totalPendapatan, $pendapatanPerBulan, $pembayaranPerMetode, $totalPembayaranPerRT), 'laporan_pembayaran.xlsx');
    }

    public function exportPDF()
    {
        $totalPendapatan = Pembayaran::sum('jumlah_dibayar');
        
        $pendapatanPerBulan = Pembayaran::select(
            DB::raw('MONTH(tanggal_bayar) as bulan'),
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy(DB::raw('MONTH(tanggal_bayar)'))->get()->map(function($item) {
            return [
                'bulan' => $item->bulan,
                'total' => $item->total
            ];
        });
    
        $pembayaranPerMetode = Pembayaran::select(
            'metode_pembayaran',
            DB::raw('SUM(jumlah_dibayar) as total')
        )->groupBy('metode_pembayaran')->get()->map(function($item) {
            return [
                'Metode Pembayaran' => $item->metode_pembayaran,
                'Total' => $item->total
            ];
        });
    
        $totalPembayaranPerRT = RT::select('rts.nama_rt', DB::raw('SUM(pembayarans.jumlah_dibayar) as total_pembayaran'))
            ->leftJoin('wargas', 'rts.id', '=', 'wargas.id_rt')
            ->leftJoin('pembayarans', 'wargas.id', '=', 'pembayarans.id_warga')
            ->groupBy('rts.nama_rt')
            ->get()->map(function($item) {
                return [
                    'Nama RT' => $item->nama_rt,
                    'Total Pembayaran' => $item->total_pembayaran
                ];
            });
    
        $data = [
            'totalPendapatan' => $totalPendapatan,
            'pendapatanPerBulan' => $pendapatanPerBulan,
            'pembayaranPerMetode' => $pembayaranPerMetode,
            'totalPembayaranPerRT' => $totalPembayaranPerRT,
        ];
    
        $html = view('exports.laporan_pembayaran_pdf', ['data' => $data])->render();
    
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('laporan_pembayaran.pdf', 'D');
    }
}    