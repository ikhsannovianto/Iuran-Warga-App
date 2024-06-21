<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class UserPembayaranPerBulanController extends Controller
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

        return view('userpembayarans.perbulan', compact('pembayarans', 'wargaPembayaran'));
    }
}
