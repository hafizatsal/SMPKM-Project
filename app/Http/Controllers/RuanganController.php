<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function daftarRuangan()
{
    $ruangan = Ruangan::all();

    // Mengelompokkan ruangan berdasarkan tahun
    $ruangan10 = $ruangan->filter(function ($ruang) {
        return strpos($ruang->nama_ruangan, '10') === 0;
    })->sort(function ($a, $b) {
        return $this->compareRuangan($a->nama_ruangan, $b->nama_ruangan);
    });

    $ruangan11 = $ruangan->filter(function ($ruang) {
        return strpos($ruang->nama_ruangan, '11') === 0;
    })->sort(function ($a, $b) {
        return $this->compareRuangan($a->nama_ruangan, $b->nama_ruangan);
    });

    $ruangan12 = $ruangan->filter(function ($ruang) {
        return strpos($ruang->nama_ruangan, '12') === 0;
    })->sort(function ($a, $b) {
        return $this->compareRuangan($a->nama_ruangan, $b->nama_ruangan);
    });

    return view('Admin.layout.Ruangan.DaftarRuangan', [
        'ruangan10' => $ruangan10,
        'ruangan11' => $ruangan11,
        'ruangan12' => $ruangan12
    ]);
}

private function compareRuangan($a, $b)
{
    $aNumber = $this->extractNumber($a);
    $bNumber = $this->extractNumber($b);

    if ($aNumber === $bNumber) {
        return 0;
    }

    return $aNumber < $bNumber ? -1 : 1;
}

private function extractNumber($str)
{
    if (preg_match('/(\d+)/', $str, $matches)) {
        return intval($matches[1]);
    }

    return PHP_INT_MAX;
}

    public function tambahRuangan()
    {
        return view('Admin.layout.Ruangan.TambahRuangan');
    }

    public function simpanRuangan(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'nama_ruangan.*' => 'required|string|max:50',
    ]);

    // Simpan data
    foreach ($request->nama_ruangan as $namaRuangan) {
        Ruangan::create(['nama_ruangan' => $namaRuangan]);
    }

    // Redirect dengan pesan sukses
    return redirect()->route('ruangan.daftar')->with('success', 'Ruangan berhasil ditambahkan.');
}

    public function editRuangan($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('Admin.layout.Ruangan.EditRuangan', compact('ruangan'));
    }

    public function updateRuangan(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_ruangan' => 'required|string|max:50',
        ]);

        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($validatedData);

        return redirect()->route('ruangan.daftar')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function hapusRuangan($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('ruangan.daftar')->with('success', 'Ruangan berhasil dihapus.');
    }
}

    