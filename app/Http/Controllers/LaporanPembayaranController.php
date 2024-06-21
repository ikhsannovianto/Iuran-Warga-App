<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\RT;
use Illuminate\Support\Facades\DB;

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
}
