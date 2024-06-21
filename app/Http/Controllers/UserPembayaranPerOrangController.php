<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class UserPembayaranPerOrangController extends Controller
{
    public function index(Request $request)
    {
        $wargas = Warga::all();
        $pembayarans = Pembayaran::with('warga');
    
        if ($request->has('id_warga') && !empty($request->id_warga)) {
            $pembayarans->where('id_warga', $request->id_warga);
        }
    
        $pembayarans = $pembayarans->get();
    
        return view('userpembayarans.perorang', compact('wargas', 'pembayarans'));
    }
}
