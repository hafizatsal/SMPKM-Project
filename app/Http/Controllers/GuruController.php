<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\GuruMataPelajaran;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function daftarGuru()
    {
        $gurus = Guru::all();
        return view('Admin.layout.Guru.DaftarGuru', compact('gurus'));
    }

    public function tambahGuru()
    {
        $mataPelajarans = MataPelajaran::all();
        return view('Admin.layout.Guru.TambahGuru', compact('mataPelajarans'));
    }

    public function someMethod()
{
    $user = Auth::user();
    return view('your.view', compact('user'));
}

    public function simpanGuru(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|string|unique:guru,nip',
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|string|email',
            'foto' => 'nullable|image',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('public/fotos');
            $validated['foto'] = $fotoPath;
        } else {
            $validated['foto'] = 'assets/img/foto_guru.png'; // Path ke foto default
        }

        $guru = Guru::create($validated);

        GuruMataPelajaran::create([
            'guru_id' => $guru->nip,
            'mata_pelajaran_id' => $validated['mata_pelajaran_id']
        ]);

        return redirect()->route('guru.daftar')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function editGuru($nip)
    {
        $guru = Guru::findOrFail($nip);
        $mataPelajarans = MataPelajaran::all();
        return view('Admin.layout.Guru.EditGuru', compact('guru', 'mataPelajarans'));
    }

    public function updateGuru(Request $request, $nip)
    {
        $guru = Guru::findOrFail($nip);

        $validated = $request->validate([
            'nama' => 'required|string',
            'jenis_kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'email' => 'required|string|email',
            'foto' => 'nullable|image',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ]);

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::delete($guru->foto);
            }
            $fotoPath = $request->file('foto')->store('public/fotos');
            $validated['foto'] = $fotoPath;
        } else {
            if (!$guru->foto) {
                $validated['foto'] = 'assets/img/foto_guru.png'; // Path ke foto default jika belum ada
            }
        }

        $guru->update($validated);

        $guruMataPelajaran = GuruMataPelajaran::where('guru_id', $guru->nip)->first();

        if ($guruMataPelajaran) {
            $guruMataPelajaran->update([
                'mata_pelajaran_id' => $validated['mata_pelajaran_id']
            ]);
        } else {
            GuruMataPelajaran::create([
                'guru_id' => $guru->nip,
                'mata_pelajaran_id' => $validated['mata_pelajaran_id']
            ]);
        }

        return redirect()->route('guru.daftar')->with('success', 'Guru berhasil diupdate.');
    }

    public function hapusGuru($nip)
    {
        $guru = Guru::findOrFail($nip);

        if ($guru->foto && $guru->foto !== 'assets/img/foto_guru.png') {
            Storage::delete($guru->foto);
        }

        $guru->delete();
        GuruMataPelajaran::where('guru_id', $nip)->delete();

        return redirect()->route('guru.daftar')->with('success', 'Guru berhasil dihapus.');
    }

    protected function bersihkanFoto()
    {
        // Get all photos currently referenced in the database
        $photos = Guru::whereNotNull('foto')->pluck('foto')->toArray();

        // Get all photo files in the directory
        $files = glob(public_path('assets/foto/*'));

        foreach ($files as $file) {
            // If the file is not in the database, delete it
            if (!in_array('assets/foto/' . basename($file), $photos)) {
                unlink($file);
            }
        }
    }
}
