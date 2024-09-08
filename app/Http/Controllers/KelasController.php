<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function daftarKelas(Request $request)
    {
        $kelas10 = Kelas::where('tingkat', 10)->get();
        $kelas11 = Kelas::where('tingkat', 11)->get();
        $kelas12 = Kelas::where('tingkat', 12)->get();

        return view('Admin.layout.Kelas.daftarKelas', compact('kelas10', 'kelas11', 'kelas12'));
    }

    public function tambahKelas()
    {
        return view('Admin.layout.Kelas.TambahKelas');
    }

    public function simpanKelas(Request $request)
    {
        $request->validate([
            'kelas.*' => 'required|string|max:50',
        ]);

        $kelasNames = $request->input('kelas');

        foreach ($kelasNames as $kelasName) {
            Kelas::create([
                'nama_kelas' => $kelasName,
            ]);
        }

        return redirect()->route('kelas.daftar')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function editKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('Admin.layout.Kelas.EditKelas', compact('kelas'));
    }

    public function updateKelas(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update([
            'nama_kelas' => $request->input('nama_kelas'),
        ]);

        return redirect()->route('kelas.daftar')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function hapusKelas($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->delete();

        return redirect()->route('kelas.daftar')->with('success', 'Kelas berhasil dihapus.');
    }
}
