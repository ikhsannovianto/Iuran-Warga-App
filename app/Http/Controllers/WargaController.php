<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\RT;
use Illuminate\Http\Request;
use App\Exports\WargasExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('rt')->get();
        return view('wargas.index', compact('wargas'));
    }

    public function create()
    {
        $rts = RT::all();
        return view('wargas.create', compact('rts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'nullable|string',
            'email' => 'nullable|email',
            'id_rt' => 'required|exists:rts,id',
        ]);

        Warga::create($request->all());
        return redirect()->route('wargas.index')->with('success', 'Warga berhasil ditambahkan.');
    }

    public function edit(Warga $warga)
    {
        $rts = RT::all();
        return view('wargas.edit', compact('warga', 'rts'));
    }

    public function update(Request $request, Warga $warga)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_telp' => 'nullable|string|max:20',
            'email' => 'nullable|string|email|max:255',
            'id_rt' => 'required|exists:rts,id'
        ]);

        $warga->update($validatedData);
        return redirect()->route('wargas.index')->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('wargas.index')->with('success', 'Data warga berhasil dihapus.');
    }

    public function export()
    {
        $timestamp = Carbon::now('Asia/Jakarta')->format('Y-m-d_H-i-s');
        return Excel::download(new WargasExport, "daftar_warga_{$timestamp}.xlsx");
    }
}