<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Warga;
use Illuminate\Http\Request;
use App\Exports\PembayaranPerOrangExport;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranPerOrangController extends Controller
{
    public function index(Request $request)
    {
        $wargas = Warga::all();
        $pembayarans = Pembayaran::with('warga');

        if ($request->has('id_warga') && !empty($request->id_warga)) {
            $pembayarans->where('id_warga', $request->id_warga);
        }

        $pembayarans = $pembayarans->get();

        return view('pembayarans.perorang', compact('wargas', 'pembayarans'));
    }

    public function export(Request $request)
    {
        $id_warga = $request->input('id_warga');
        return Excel::download(new PembayaranPerOrangExport($id_warga), 'pembayaran_per_orang.xlsx');
    }
}
