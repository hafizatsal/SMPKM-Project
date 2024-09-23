<?php

namespace App\Http\Controllers;

use App\Models\KelasTersedia;
use App\Models\TahunAjaran;
use App\Models\Ruangan;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasTersediaController extends Controller
{
    public function daftarKelasTersedia(Request $request)
{
    $tahunAjaranTerbaru = TahunAjaran::orderBy('tahun', 'desc')->first();
    $tahunAjaranId = $request->query('tahun_ajaran_id', $tahunAjaranTerbaru ? $tahunAjaranTerbaru->id : null);

    $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)
        ->with(['tahunAjaran', 'ruangan', 'kelas'])
        ->orderByRaw("FIELD(tingkat, 10, 11, 12)") // Mengurutkan berdasarkan tingkat
        ->get(); // Data ini adalah koleksi Eloquent

    $tahunAjaran = TahunAjaran::all(); // Koleksi Eloquent

    return view('Admin.layout.KelasTersedia.DaftarKelasTersedia', compact('kelasTersedia', 'tahunAjaran', 'tahunAjaranId'));
}

public function tambahKelasTersedia()
{
    $tahunAjaran = TahunAjaran::all(); // Koleksi Eloquent
    $ruangan = Ruangan::orderBy('nama_ruangan')->get(); // Koleksi Eloquent
    $kelas = Kelas::orderBy('nama_kelas')->get(); // Koleksi Eloquent

    return view('Admin.layout.KelasTersedia.TambahKelasTersedia', compact('tahunAjaran', 'ruangan', 'kelas'));
}

public function simpanKelasTersedia(Request $request)
{
    $validatedData = $request->validate([
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'kelas_ids' => 'required|array',
        'kelas_ids.*' => 'exists:kelas,id',
        'ruangan_ids' => 'required|array',
        'ruangan_ids.*' => 'exists:ruangan,id',
    ]);

    $tahunAjaranId = $validatedData['tahun_ajaran_id'];
    $kelasIds = $validatedData['kelas_ids'];
    $ruanganIds = $validatedData['ruangan_ids'];

    $jumlahEntries = min(count($kelasIds), count($ruanganIds));

    for ($i = 0; $i < $jumlahEntries; $i++) {
        $kelasId = $kelasIds[$i];
        $ruanganId = $ruanganIds[$i];
        
        $kelas = Kelas::findOrFail($kelasId);
        $tingkat = substr($kelas->nama_kelas, 0, 2);

        if (!in_array($tingkat, ['10', '11', '12'])) {
            return redirect()->back()->with('error', 'Tingkat tidak valid.');
        }

        KelasTersedia::updateOrCreate([
            'tahun_ajaran_id' => $tahunAjaranId,
            'ruangan_id' => $ruanganId,
            'kelas_id' => $kelasId,
        ], [
            'tingkat' => $tingkat,
        ]);
    }

    return redirect()->route('kelastersedia.daftar')->with('success', 'Kelas Tersedia berhasil ditambahkan.');
}

    public function editKelasTersedia($id)
    {
        $kelasTersedia = KelasTersedia::findOrFail($id);
        $tahunAjaran = TahunAjaran::all();
        $ruangan = Ruangan::all();
        $kelas = Kelas::all();
        return view('Admin.layout.KelasTersedia.EditKelasTersedia', compact('kelasTersedia', 'tahunAjaran', 'ruangan', 'kelas'));
    }

    public function updateKelasTersedia(Request $request, $id)
{
    $validatedData = $request->validate([
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'ruangan_id' => 'required|exists:ruangan,id',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    $kelasTersedia = KelasTersedia::findOrFail($id);
    $kelas = Kelas::findOrFail($validatedData['kelas_id']);
    $tingkat = substr($kelas->nama_kelas, 0, 2);

    if (!in_array($tingkat, ['10', '11', '12'])) {
        return redirect()->back()->with('error', 'Tingkat tidak valid.');
    }

    $kelasTersedia->update(array_merge($validatedData, ['tingkat' => $tingkat]));

    return redirect()->route('kelastersedia.daftar')->with('success', 'Kelas Tersedia berhasil diperbarui.');
}

    public function hapusKelasTersedia($id)
    {
        $kelasTersedia = KelasTersedia::findOrFail($id);
        $kelasTersedia->delete();

        return redirect()->route('kelastersedia.daftar')->with('success', 'Kelas Tersedia berhasil dihapus.');
    }
}
