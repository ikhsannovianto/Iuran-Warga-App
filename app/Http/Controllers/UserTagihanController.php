<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class UserTagihanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan yang dipilih dari request
        $bulan = $request->bulan;

        // Ambil semua tagihan dan data relasi terkait
        $query = Tagihan::with(['warga.rt', 'pembayarans']);

        // Jika bulan dipilih, filter tagihan berdasarkan bulan
        if ($bulan) {
            $query->where('bulan', $bulan);
        }

        // Ambil tagihan sesuai dengan filter bulan yang dipilih
        $tagihans = $query->get();

        // Inisialisasi array untuk menyimpan data laporan
        $laporan = [];

        // Loop melalui setiap tagihan
        foreach ($tagihans as $tagihan) {
            // Menghitung total pembayaran hanya untuk bulan yang sama
            $totalPembayaranBulanIni = $tagihan->pembayarans->where('bulan', $tagihan->bulan)->sum('jumlah_dibayar');
            $belumTerbayar = max(0, $tagihan->jumlah_tagihan - $totalPembayaranBulanIni);
            $status = ($totalPembayaranBulanIni >= $tagihan->jumlah_tagihan) ? 'Lunas' : 'Belum Lunas';

            // Tambahkan data tagihan dan laporan ke array laporan
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

        return view('usertagihans.index', compact('laporan', 'bulan'));
    }
}
