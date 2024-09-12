<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\GuruMataPelajaran;
use App\Models\Ruangan;
use App\Models\KelasTersedia;
use App\Models\TahunAjaran;
use Illuminate\Support\Facades\Log;

class JadwalController extends Controller
{
    public function daftarJadwal(Request $request)
    {
        $tahunAjarans = TahunAjaran::all();
        $query = Jadwal::with(['kelas', 'tahunAjaran', 'ruangan', 'mataPelajaran', 'guru']);

        // Ambil data tahun ajaran dan tingkatan kelas dari tabel kelas_tersedia
        $kelasTersediaQuery = KelasTersedia::query();
        if ($request->filled('tahun_ajaran')) {
            $kelasTersediaQuery->where('tahun_ajaran_id', $request->input('tahun_ajaran'));
        }
        if ($request->filled('tingkat')) {
            $kelasTersediaQuery->where('tingkat', $request->input('tingkat'));
        }
        $kelasTersedia = $kelasTersediaQuery->get();

        if ($kelasTersedia->isNotEmpty()) {
            $tahunAjaranIds = $kelasTersedia->pluck('tahun_ajaran_id')->unique();
            $tingkatanKelas = $kelasTersedia->pluck('tingkat')->unique();
            
            $query->whereIn('tahun_ajaran_id', $tahunAjaranIds);
            $query->whereHas('kelas', function($q) use ($tingkatanKelas) {
                $q->whereIn('tingkat', $tingkatanKelas);
            });
        }

        // Debugging
        Log::info('Query untuk daftar jadwal:', ['sql' => $query->toSql(), 'bindings' => $query->getBindings()]);
        $jadwals = $query->get()->groupBy('kelas.nama_kelas');
        // Debugging
        Log::info('Jadwal yang ditemukan:', $jadwals->toArray());
        return view('Admin.layout.Jadwal.DaftarJadwal', compact('jadwals', 'tahunAjarans'));
    }

    public function tambahJadwal()
    {
        $tahunAjarans = TahunAjaran::all();
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        
        // Mengambil data tingkat dari tabel kelas_tersedia
        $tingkatanKelas = KelasTersedia::distinct()->pluck('tingkat');
        
        // Mengambil data tahun ajaran dari tabel kelas_tersedia
        $tahunAjaransTersedia = KelasTersedia::distinct()->pluck('tahun_ajaran_id');
        $tahunAjarans = TahunAjaran::whereIn('id', $tahunAjaransTersedia)->get();
        
        // Debugging
        Log::info('Data yang diambil untuk form tambah jadwal:', [
            'tahunAjarans' => $tahunAjarans->toArray(),
            'gurus' => $gurus->toArray(),
            'mataPelajarans' => $mataPelajarans->toArray(),
            'tingkatanKelas' => $tingkatanKelas->toArray(),
        ]);
        
        return view('Admin.layout.Jadwal.TambahJadwal', compact('tahunAjarans', 'gurus', 'mataPelajarans', 'tingkatanKelas'));
    }

    public function simpanJadwal(Request $request)
    {
        $validatedData = $request->validate([
            'tahun_ajaran_id' => 'required|integer|exists:tahun_ajaran,id',
            'guru_ids' => 'required|string',
            'mata_pelajaran_ids' => 'required|string',
            'tingkatan' => 'required|string',
            'senin_kamis_mulai' => 'required|array',
            'senin_kamis_mulai.*' => 'required|date_format:H:i',
            'senin_kamis_selesai' => 'required|array',
            'senin_kamis_selesai.*' => 'required|date_format:H:i|after:senin_kamis_mulai.*',
            'jumat_mulai' => 'required|array',
            'jumat_mulai.*' => 'required|date_format:H:i',
            'jumat_selesai' => 'required|array',
            'jumat_selesai.*' => 'required|date_format:H:i|after:jumat_mulai.*',
        ]);
    
        // Ambil waktu sesi dari input
        $seninKamisMulai = $request->input('senin_kamis_mulai');
        $seninKamisSelesai = $request->input('senin_kamis_selesai');
        $jumatMulai = $request->input('jumat_mulai');
        $jumatSelesai = $request->input('jumat_selesai');
    
        $guruIds = array_filter(explode(',', $validatedData['guru_ids']));
        $mataPelajaranIds = array_filter(explode(',', $validatedData['mata_pelajaran_ids']));
    
        if (empty($guruIds) || empty($mataPelajaranIds)) {
            return redirect()->back()->withErrors('Pilih guru dan mata pelajaran dengan benar.')->withInput();
        }
    
        try {
            $this->penjadwalanOtomatis($validatedData['tahun_ajaran_id'], $guruIds, $mataPelajaranIds, $validatedData['tingkatan'], $seninKamisMulai, $seninKamisSelesai, $jumatMulai, $jumatSelesai);
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan jadwal: ' . $e->getMessage());
            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan jadwal.')->withInput();
        }
    
        return redirect()->route('jadwal.daftar')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function editJadwal($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        return view('Admin.layout.Jadwal.EditJadwal', compact('jadwal'));
    }

    public function updateJadwal(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|integer',
            'guru_id' => 'required|integer',
            'mata_pelajaran_id' => 'required|integer',
            'hari' => 'required|string|max:10',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ]);
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());
        return redirect()->route('jadwal.daftar')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function hapusJadwal($id)
    {
        Log::info('Menghapus semua jadwal untuk kelas dengan ID:', ['kelas_id' => $id]);
    
        try {
            // Temukan semua jadwal yang terkait dengan kelas tertentu
            Jadwal::where('kelas_id', $id)->delete();
    
            Log::info('Semua jadwal untuk kelas berhasil dihapus:', ['kelas_id' => $id]);
            return redirect()->route('jadwal.daftar')->with('success', 'Semua jadwal untuk kelas tersebut berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus jadwal berdasarkan kelas:', ['kelas_id' => $id, 'error' => $e->getMessage()]);
            return redirect()->route('jadwal.daftar')->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }

    private function penjadwalanOtomatis($tahunAjaranId, $guruIds, $mataPelajaranIds, $tingkatan, $seninKamisMulai, $seninKamisSelesai, $jumatMulai, $jumatSelesai)
{
    Log::info('Mulai proses penjadwalan otomatis', [
        'tahun_ajaran_id' => $tahunAjaranId,
        'guru_ids' => $guruIds,
        'mata_pelajaran_ids' => $mataPelajaranIds,
        'tingkatan' => $tingkatan,
        'senin_kamis_mulai' => $seninKamisMulai,
        'senin_kamis_selesai' => $seninKamisSelesai,
        'jumat_mulai' => $jumatMulai,
        'jumat_selesai' => $jumatSelesai,
    ]);

    // Ambil data kelas tersedia berdasarkan tahun ajaran dan tingkat
    $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)
                                  ->where('tingkat', $tingkatan)
                                  ->get();

    Log::info('Kelas Tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ' dan tingkat ' . $tingkatan, $kelasTersedia->toArray());

    if ($kelasTersedia->isEmpty()) {
        Log::error('Tidak ada kelas tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ' dan tingkat ' . $tingkatan);
        return; // Jika tidak ada kelas tersedia, tidak melakukan penjadwalan
    }

    // Daftar hari yang akan diproses
    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $mataPelajaranGuru = [];
    $guruJam = array_fill_keys($guruIds, 0);

    // Hitung jumlah sesi mata pelajaran
    $mataPelajaranJam = count($hariList) * count($seninKamisMulai) * count($kelasTersedia);
    $bagiBebanJamGuru = $mataPelajaranJam / count($guruIds);

    foreach ($kelasTersedia as $kelasTersediaItem) {
        $kelas = $kelasTersediaItem->kelas;
        $ruangan = $kelasTersediaItem->ruangan; // Mengambil ruangan yang sesuai dengan kelas

        Log::info('Memproses kelas:', ['kelas_id' => $kelas->id]);

        foreach ($hariList as $hari) {
            $sesiWaktuMulai = ($hari === 'Jumat') ? $jumatMulai : $seninKamisMulai;
            $sesiWaktuSelesai = ($hari === 'Jumat') ? $jumatSelesai : $seninKamisSelesai;

            foreach ($sesiWaktuMulai as $index => $jamMulai) {
                $jamSelesai = $sesiWaktuSelesai[$index];
                $mataPelajaranId = $mataPelajaranIds[array_rand($mataPelajaranIds)];

                // Pilih guru yang tepat untuk mata pelajaran
                if (!isset($mataPelajaranGuru[$kelas->id][$mataPelajaranId])) {
                    $validGuruIds = GuruMataPelajaran::where('mata_pelajaran_id', $mataPelajaranId)
                                                    ->pluck('guru_id')
                                                    ->intersect($guruIds)
                                                    ->toArray();
                    if (empty($validGuruIds)) {
                        Log::error('Tidak ada guru yang valid untuk mata pelajaran ID ' . $mataPelajaranId);
                        continue;
                    }

                    $guruId = $this->pilihGuruDenganBebanJamTerdekat($validGuruIds, $guruJam, $bagiBebanJamGuru);
                    $mataPelajaranGuru[$kelas->id][$mataPelajaranId] = $guruId;
                } else {
                    $guruId = $mataPelajaranGuru[$kelas->id][$mataPelajaranId];
                }

                // Simpan jadwal
                $jadwal = Jadwal::create([
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'kelas_id' => $kelas->id,
                    'ruangan_id' => $ruangan->id, // Menggunakan ruangan yang sesuai dengan kelas
                    'mapel_id' => $mataPelajaranId,
                    'guru_id' => $guruId,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'urutan' => $hari . ' ' . ($index + 1)
                ]);

                // Update beban jam guru
                $guruJam[$guruId] += $this->hitungDurasiJam($jamMulai, $jamSelesai);

                Log::info('Jadwal disimpan:', $jadwal->toArray());
            }
        }
    }
}

    // Fungsi untuk memilih guru dengan beban jam terdekat
    private function pilihGuruDenganBebanJamTerdekat($guruIds, $guruJam, $bagiBebanJamGuru)
    {
        $guruDenganBebanTerdekat = array_reduce($guruIds, function ($carry, $guruId) use ($guruJam, $bagiBebanJamGuru) {
            if ($carry === null || abs($guruJam[$guruId] - $bagiBebanJamGuru) < abs($guruJam[$carry] - $bagiBebanJamGuru)) {
                return $guruId;
            }
            return $carry;
        });
        return $guruDenganBebanTerdekat;
    }

    // Fungsi untuk menghitung durasi jam
    private function hitungDurasiJam($jamMulai, $jamSelesai)
    {
        $start = \Carbon\Carbon::createFromFormat('H:i', $jamMulai);
        $end = \Carbon\Carbon::createFromFormat('H:i', $jamSelesai);
        return $end->diffInMinutes($start);
    }
}
