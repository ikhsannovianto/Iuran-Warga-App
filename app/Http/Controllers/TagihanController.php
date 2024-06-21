<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Warga;
use Illuminate\Http\Request;
use App\Exports\TagihansExport;
use Maatwebsite\Excel\Facades\Excel;

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

        foreach ($tagihans as $tagihan) {
            $pembayarans = $tagihan->pembayarans;
        }

        $laporan = [];

        foreach ($tagihans as $tagihan) {
            $jumlahTagihan = $tagihan->jumlah_tagihan;
            $totalPembayaran = $tagihan->pembayarans->sum('jumlah_dibayar');
            $belumTerbayar = max(0, $jumlahTagihan - $totalPembayaran);
            $status = ($totalPembayaran >= $jumlahTagihan) ? 'Lunas' : 'Belum Lunas';

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

    public function export()
    {
        return Excel::download(new TagihansExport, 'riwayat_tagihan.xlsx');
    }
}