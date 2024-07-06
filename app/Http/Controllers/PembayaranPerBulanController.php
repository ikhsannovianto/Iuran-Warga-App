<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Warga;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Exports\PembayaranPerBulanExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;

class PembayaranPerBulanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('warga');

        if ($request->has('bulan') && !empty($request->bulan)) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        $pembayarans = $query->get();

        $wargaIds = $pembayarans->pluck('id_warga')->unique();
        $wargaPembayaran = [];

        foreach ($wargaIds as $wargaId) {
            $totalBayar = Pembayaran::where('id_warga', $wargaId)->sum('jumlah_dibayar');
            $wargaPembayaran[$wargaId] = $totalBayar;
        }

        return view('pembayarans.perbulan', compact('pembayarans', 'wargaPembayaran'));
    }

    public function create()
    {
        // Dapatkan email user yang sedang login
        $emailUser = Auth::user()->email;

        // Dapatkan warga yang emailnya sama dengan email user yang login dan memiliki tagihan
        $wargasWithTagihan = Warga::where('email', $emailUser)->has('tagihans')->get();

        return view('pembayarans.create', compact('wargasWithTagihan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_warga' => 'required|exists:wargas,id',
            'jumlah_dibayar' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string|in:tunai,transfer',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        // Cek apakah warga memiliki tagihan pada bulan yang dipilih
        $tagihan = Tagihan::where('id_warga', $request->id_warga)
            ->where('bulan', $request->bulan)
            ->where('tahun', date('Y')) // Misalkan cek untuk tahun berjalan, bisa disesuaikan
            ->first();

        if (!$tagihan) {
            return redirect()->route('pembayarans.create')->withErrors(['error' => 'Warga tidak memiliki tagihan pada bulan yang dipilih.']);
        }

        if ($request->jumlah_dibayar > $tagihan->jumlah_tagihan) {
            return redirect()->route('pembayarans.create')->withErrors(['error' => 'Jumlah pembayaran tidak boleh lebih dari jumlah tagihan.']);
        }

        Pembayaran::create([
            'id_warga' => $request->id_warga,
            'jumlah_dibayar' => $request->jumlah_dibayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'bulan' => $request->bulan,
        ]);

        return redirect()->route('pembayarans.success');
    }

    public function edit(Pembayaran $pembayaran)
    {
        $wargas = Warga::all();
        return view('pembayarans.edit', compact('pembayaran', 'wargas'));
    }

    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'id_warga' => 'required|exists:wargas,id',
            'jumlah_dibayar' => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'metode_pembayaran' => 'required|string|in:tunai,transfer',
            'bulan' => 'required|integer|min:1|max:12',
        ]);

        // Cek apakah warga memiliki tagihan pada bulan yang dipilih
        $tagihan = Tagihan::where('id_warga', $request->id_warga)
            ->where('bulan', $request->bulan)
            ->where('tahun', date('Y')) // Misalkan cek untuk tahun berjalan, bisa disesuaikan
            ->first();

        if (!$tagihan) {
            return redirect()->route('pembayarans.edit', $pembayaran->id)->withErrors(['error' => 'Warga tidak memiliki tagihan pada bulan yang dipilih.']);
        }

        if ($request->jumlah_dibayar > $tagihan->jumlah_tagihan) {
            return redirect()->route('pembayarans.edit', $pembayaran->id)->withErrors(['error' => 'Jumlah pembayaran tidak boleh lebih dari jumlah tagihan.']);
        }

        $pembayaran->update($request->all());

        return redirect()->route('pembayarans.perbulan')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayarans.perbulan')->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function report()
    {
        $pembayarans = Pembayaran::with('warga')->get();
        return view('report', compact('pembayarans'));
    }

    public function success()
    {
        return view('pembayarans.success');
    }

    public function export(Request $request)
    {
        $bulan = $request->input('bulan');
        return Excel::download(new PembayaranPerBulanExport($bulan), 'pembayaran_per_bulan.xlsx');
    }

}

