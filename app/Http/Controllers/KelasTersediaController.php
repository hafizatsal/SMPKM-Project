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
        // Dapatkan tahun ajaran terbaru
        $tahunAjaranTerbaru = TahunAjaran::orderBy('tahun', 'desc')->first();

        // Ambil tahun ajaran ID dari request atau gunakan tahun ajaran terbaru jika tidak ada di request
        $tahunAjaranId = $request->query('tahun_ajaran_id', $tahunAjaranTerbaru ? $tahunAjaranTerbaru->id : null);

        // Ambil data kelas tersedia berdasarkan tahun ajaran yang dipilih
        $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)
            ->with(['tahunAjaran', 'ruangan', 'kelas'])
            ->get();

        // Ambil semua data tahun ajaran untuk dropdown
        $tahunAjaran = TahunAjaran::all();

        return view('Admin.layout.KelasTersedia.DaftarKelasTersedia', compact('kelasTersedia', 'tahunAjaran', 'tahunAjaranId'));
    }

    public function tambahKelasTersedia()
    {
        $tahunAjaran = TahunAjaran::all();
        $ruangan = Ruangan::orderBy('nama_ruangan')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('Admin.layout.KelasTersedia.TambahKelasTersedia', compact('tahunAjaran', 'ruangan', 'kelas'));
    }

    public function simpanKelasTersedia(Request $request)
{
    $validatedData = $request->validate([
        'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        'ruangan_id' => 'required|exists:ruangan,id',
        'kelas_ids' => 'required|array',
        'kelas_ids.*' => 'required|exists:kelas,id',
    ]);

    $tahunAjaranId = $validatedData['tahun_ajaran_id'];
    $ruanganId = $validatedData['ruangan_id'];
    $kelasIds = $validatedData['kelas_ids'];

    foreach ($kelasIds as $kelasId) {
        $kelas = Kelas::findOrFail($kelasId);
        $tingkat = substr($kelas->nama_kelas, 0, 2);

        // Validasi tingkat untuk memastikan hanya nilai 10, 11, atau 12 yang diterima
        if (!in_array($tingkat, ['10', '11', '12'])) {
            return redirect()->back()->with('error', 'Tingkat tidak valid.');
        }

        KelasTersedia::create([
            'tahun_ajaran_id' => $tahunAjaranId,
            'ruangan_id' => $ruanganId,
            'kelas_id' => $kelasId,
            'tingkat' => $tingkat, // Menyimpan tingkat berdasarkan nama kelas
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

    // Validasi tingkat untuk memastikan hanya nilai 10, 11, atau 12 yang diterima
    if (!in_array($tingkat, ['10', '11', '12'])) {
        return redirect()->back()->with('error', 'Tingkat tidak valid.');
    }

    $kelasTersedia->update(array_merge($validatedData, ['tingkat' => $tingkat]));

    return redirect()->route('kelasTersedia.daftar')->with('success', 'Kelas Tersedia berhasil diperbarui.');
}

    public function hapusKelasTersedia($id)
    {
        $kelasTersedia = KelasTersedia::findOrFail($id);
        $kelasTersedia->delete();

        return redirect()->route('kelasTersedia.daftar')->with('success', 'Kelas Tersedia berhasil dihapus.');
    }
}
