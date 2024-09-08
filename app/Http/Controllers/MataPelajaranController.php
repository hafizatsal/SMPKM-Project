<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function daftarMataPelajaran()
    {
        $mataPelajarans = MataPelajaran::all();
        return view('Admin.layout.MataPelajaran.DaftarMataPelajaran', compact('mataPelajarans'));
    }

    public function tambahMataPelajaran()
    {
        return view('Admin.layout.MataPelajaran.TambahMataPelajaran');
    }

    public function simpanMataPelajaran(Request $request)
    {
        $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        MataPelajaran::create($validatedData);

        return redirect()->route('matapelajaran.daftar')->with('success', 'Mata Pelajaran created successfully.');
    }

    public function editMataPelajaran($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('Admin.layout.MataPelajaran.EditMataPelajaran', compact('mataPelajaran'));
    }

    public function updateMataPelajaran(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_mapel' => 'required|string|max:100',
        ]);

        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->update($validatedData);

        return redirect()->route('matapelajaran.daftar')->with('success', 'Mata Pelajaran updated successfully.');
    }

    public function hapusMataPelajaran($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();
        return redirect()->route('matapelajaran.daftar')->with('success', 'Mata Pelajaran deleted successfully.');
    }
}
