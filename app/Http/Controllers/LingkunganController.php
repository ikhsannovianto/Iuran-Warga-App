<?php

namespace App\Http\Controllers;

use App\Models\Lingkungan;
use Illuminate\Http\Request;

class LingkunganController extends Controller
{
    public function index()
    {
        $lingkungans = Lingkungan::all();
        return view('lingkungans.index', compact('lingkungans'));
    }

    public function create()
    {
        return view('lingkungans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        Lingkungan::create($request->all());
        return redirect()->route('lingkungans.index');
    }

    public function edit(Lingkungan $lingkungan)
    {
        return view('lingkungans.edit', compact('lingkungan'));
    }

    public function update(Request $request, Lingkungan $lingkungan)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $lingkungan->update($request->all());
        return redirect()->route('lingkungans.index');
    }

    public function destroy(Lingkungan $lingkungan)
    {
        $lingkungan->delete();
        return redirect()->route('lingkungans.index');
    }
}
