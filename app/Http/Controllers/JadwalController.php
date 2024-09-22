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
        $tahunAjaranId = $request->input('tahun_ajaran', 1);

        $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)->pluck('kelas_id');

        \Log::info('Kelas Tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ':', $kelasTersedia->toArray());

        $jadwals = Jadwal::with(['kelas', 'ruangan', 'mataPelajaran', 'guru'])
            ->whereIn('kelas_id', $kelasTersedia)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->get();

        \Log::info('Jadwals untuk tahun ajaran ID ' . $tahunAjaranId . ':', $jadwals->toArray());

        $jadwalsGrouped = $jadwals->groupBy('kelas.nama_kelas');

        $tahunAjarans = TahunAjaran::all();

        return view('Admin.layout.Jadwal.DaftarJadwal', compact('jadwalsGrouped', 'tahunAjarans', 'tahunAjaranId'));
    }

    public function tambahJadwal()
    {
        $gurus = Guru::all();
        $mataPelajarans = MataPelajaran::all();
        
        $tingkatanKelas = KelasTersedia::distinct()->pluck('tingkat')->sort();
        $tahunAjaransTersedia = KelasTersedia::distinct()->pluck('tahun_ajaran_id');
        $tahunAjarans = TahunAjaran::whereIn('id', $tahunAjaransTersedia)->get();
        
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

        Log::info('Data yang diterima untuk menyimpan jadwal:', $validatedData);
        
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
        $jadwal = Jadwal::with(['kelas', 'ruangan', 'mataPelajaran', 'guru'])->findOrFail($id);
        $ruangans = Ruangan::all();
        $mataPelajarans = MataPelajaran::all();
        
        // Load all gurus with mata pelajaran relations
        $gurus = Guru::with('mataPelajarans')->get();
    
        return view('Admin.layout.Jadwal.EditJadwal', compact('jadwal', 'ruangans', 'mataPelajarans', 'gurus'));
    }


public function editByClass($kelas_id)
{
    // Fetch schedules for the given class
    $classJadwals = Jadwal::where('kelas_id', $kelas_id)->get();
    $ruangans = Ruangan::all();
    $mataPelajarans = MataPelajaran::all();
    $gurus = Guru::all();

    return view('Admin.layout.Jadwal.EditJadwal', [
        'classJadwals' => $classJadwals,
        'ruangans' => $ruangans,
        'mataPelajarans' => $mataPelajarans,
        'gurus' => $gurus,
        'kelas_id' => $kelas_id
    ]);
}


public function updateJadwal(Request $request, $id)
{
    // Validate request
    $request->validate([
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i',
        'hari' => 'required|string',
        'ruangan_id' => 'required|exists:ruangans,id',
        'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
        'guru_id' => 'required|exists:gurus,id',
    ]);

    // Fetch the schedule entry
    $jadwal = Jadwal::findOrFail($id);

    // Update the schedule with new values
    $jadwal->jam_mulai = $request->input('jam_mulai');
    $jadwal->jam_selesai = $request->input('jam_selesai');
    $jadwal->hari = $request->input('hari');
    $jadwal->ruangan_id = $request->input('ruangan_id');
    $jadwal->mata_pelajaran_id = $request->input('mata_pelajaran_id');
    $jadwal->guru_id = $request->input('guru_id');
    $jadwal->save();

    // Redirect with success message
    return redirect()->route('jadwal.index')->with('success', 'Jadwal updated successfully!');
}

    public function hapusJadwal($id)
    {
        Log::info('Menghapus semua jadwal untuk kelas dengan ID:', ['kelas_id' => $id]);
    
        try {
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

        $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)
                                      ->where('tingkat', $tingkatan)
                                      ->get();

        Log::info('Kelas Tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ' dan tingkat ' . $tingkatan, $kelasTersedia->toArray());

        if ($kelasTersedia->isEmpty()) {
            Log::error('Tidak ada kelas tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ' dan tingkat ' . $tingkatan);
            return;
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $mataPelajaranGuru = [];
        $guruJam = array_fill_keys($guruIds, 0);
        $mataPelajaranJam = count($hariList) * count($seninKamisMulai) * count($kelasTersedia);
        $bagiBebanJamGuru = $mataPelajaranJam / count($guruIds);

        foreach ($kelasTersedia as $kelasTersediaItem) {
            $kelas = $kelasTersediaItem->kelas;
            $ruangan = $kelasTersediaItem->ruangan;

            Log::info('Memproses kelas:', ['kelas_id' => $kelas->id, 'kelas_nama' => $kelas->nama_kelas]);

            foreach ($hariList as $hari) {
                $sesiWaktuMulai = ($hari === 'Jumat') ? $jumatMulai : $seninKamisMulai;
                $sesiWaktuSelesai = ($hari === 'Jumat') ? $jumatSelesai : $seninKamisSelesai;

                foreach ($sesiWaktuMulai as $index => $jamMulai) {
                    $jamSelesai = $sesiWaktuSelesai[$index];
                    $mataPelajaranId = $mataPelajaranIds[array_rand($mataPelajaranIds)];

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

                    $jadwal = Jadwal::create([
                        'tahun_ajaran_id' => $tahunAjaranId,
                        'kelas_id' => $kelas->id,
                        'ruangan_id' => $ruangan->id,
                        'mapel_id' => $mataPelajaranId,
                        'guru_id' => $guruId,
                        'hari' => $hari,
                        'jam_mulai' => $jamMulai,
                        'jam_selesai' => $jamSelesai,
                        'urutan' => $hari . ' ' . ($index + 1)
                    ]);

                    $guruJam[$guruId] += $this->hitungDurasiJam($jamMulai, $jamSelesai);

                    Log::info('Jadwal disimpan:', $jadwal->toArray());
                }
            }
        }
    }

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

    private function hitungDurasiJam($jamMulai, $jamSelesai)
    {
        $start = \Carbon\Carbon::createFromFormat('H:i', $jamMulai);
        $end = \Carbon\Carbon::createFromFormat('H:i', $jamSelesai);
        return $end->diffInMinutes($start);
    }
}
