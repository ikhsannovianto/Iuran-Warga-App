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
            // Ambil jumlah tagihan
            $jumlahTagihan = $tagihan->jumlah_tagihan;

            // Ambil total pembayaran untuk tagihan tertentu
            $totalPembayaran = $tagihan->pembayarans->sum('jumlah_dibayar');

            // Hitung sisa tagihan yang belum terbayar
            $belumTerbayar = max(0, $jumlahTagihan - $totalPembayaran);

            // Tentukan status pembayaran
            $status = ($totalPembayaran >= $jumlahTagihan) ? 'Lunas' : 'Belum Lunas';

            // Tambahkan data tagihan dan laporan ke array laporan
            $laporan[] = [
                'tagihan' => $tagihan,
                'warga' => $tagihan->warga->nama,
                'rt' => $tagihan->warga->rt->nama_rt,
                'jumlah_tagihan' => (float)$jumlahTagihan,
                'total_terbayar' => (float)$totalPembayaran,
                'belum_terbayar' => (float)$belumTerbayar,
                'status' => $status,
            ];
        }

        return view('usertagihans.index', compact('laporan', 'bulan'));
    }
}
