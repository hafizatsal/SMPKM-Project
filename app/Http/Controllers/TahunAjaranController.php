<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function daftarTahunAjaran()
    {
        $tahunAjarans = TahunAjaran::all();
        return view('Admin.layout.TahunAjaran.DaftarTahunAjaran', compact('tahunAjarans'));
    }

    public function simpanTahunAjaran(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string|max:10',
        ]);

        TahunAjaran::create($request->all());

        return redirect()->route('tahunajaran.daftar')->with('success', 'Tahun Ajaran created successfully.');
    }

    public function hapusTahunAjaran(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();
        return redirect()->route('tahunajaran.daftar')->with('success', 'Tahun Ajaran deleted successfully.');
    }
}
