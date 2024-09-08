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

        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->input('tahun_ajaran'));
        }
        if ($request->filled('tingkat')) {
            $query->whereHas('kelas', function($q) use ($request) {
                $q->where('tingkat', $request->input('tingkat'));
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
            'tahun_ajaran_id' => 'required|integer',
            'guru_ids' => 'required|string',
            'mata_pelajaran_ids' => 'required|string',
            'tingkatan' => 'required|string',
        ]);
        $guruIds = array_filter(explode(',', $validatedData['guru_ids']));
        $mataPelajaranIds = array_filter(explode(',', $validatedData['mata_pelajaran_ids']));
        if (empty($guruIds) || empty($mataPelajaranIds)) {
            return redirect()->back()->withErrors('Pilih guru dan mata pelajaran dengan benar.')->withInput();
        }
        try {
            $this->penjadwalanOtomatis($validatedData['tahun_ajaran_id'], $guruIds, $mataPelajaranIds, $validatedData['tingkatan']);
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
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();
        return redirect()->route('jadwal.daftar')->with('success', 'Jadwal berhasil dihapus.');
    }
    private function penjadwalanOtomatis($tahunAjaranId, $guruIds, $mataPelajaranIds, $tingkatan)
{
    // Debugging
    Log::info('Mulai proses penjadwalan otomatis', [
        'tahun_ajaran_id' => $tahunAjaranId,
        'guru_ids' => $guruIds,
        'mata_pelajaran_ids' => $mataPelajaranIds,
        'tingkatan' => $tingkatan,
    ]);


    // Mengambil data kelas dan ruangan yang tersedia sesuai dengan tahun ajaran dan tingkat
    $kelasTersedia = ($tingkatan !== 'semua')
        ? KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)
                      ->where('tingkat', $tingkatan)
                      ->get()
        : KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)->get();


    // Daftar sesi waktu untuk Senin-Kamis dan Jumat
    $sesiWaktuSeninKamis = [
        '08:00 - 09:00',
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '13:30 - 14:30',
        '14:30 - 15:30'
    ];


    $sesiWaktuJumat = [
        '08:00 - 09:00',
        '09:00 - 10:00',
        '10:00 - 11:00',
        '11:00 - 12:00',
        '13:30 - 14:30'
    ];


    // Daftar hari
    $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];


    // Menyimpan pasangan mata pelajaran dan guru yang sudah digunakan
    $mataPelajaranGuru = [];


    // Menyimpan jam mengajar guru
    $guruJam = array_fill_keys($guruIds, 0);


    // Menyimpan ruangan yang tersedia
    $ruanganTersedia = Ruangan::all(); // Mengambil semua ruangan


    // Hitung total jam per mata pelajaran
    $mataPelajaranJam = count($hariList) * count($sesiWaktuSeninKamis) * count($kelasTersedia);


    // Membagi beban jam ke setiap guru
    $bagiBebanJamGuru = $mataPelajaranJam / count($guruIds);


    foreach ($kelasTersedia as $kelasTersediaItem) {
        $kelas = $kelasTersediaItem->kelas;
        $tingkat = $kelasTersediaItem->tingkat;


        // Debugging
        Log::info('Memproses kelas:', ['kelas_id' => $kelas->id, 'tingkat' => $tingkat]);


        foreach ($hariList as $hari) {
            $sesiWaktu = ($hari === 'Jumat') ? $sesiWaktuJumat : $sesiWaktuSeninKamis;


            foreach ($sesiWaktu as $index => $sesi) {
                // Mengambil mata pelajaran secara acak
                $mataPelajaranId = $mataPelajaranIds[array_rand($mataPelajaranIds)];


                // Memastikan mata pelajaran ini belum memiliki guru yang ditetapkan untuk kelas ini
                if (!isset($mataPelajaranGuru[$kelas->id][$mataPelajaranId])) {
                    // Ambil guru yang sesuai dengan mata pelajaran ini
                    $validGuruIds = GuruMataPelajaran::where('mata_pelajaran_id', $mataPelajaranId)
                                                    ->pluck('guru_id')
                                                    ->intersect($guruIds)
                                                    ->toArray();                    if (empty($validGuruIds)) {
                        // Jika tidak ada guru yang valid untuk mata pelajaran ini
                        Log::error('Tidak ada guru yang valid untuk mata pelajaran ID ' . $mataPelajaranId);
                        continue; // Skip ke iterasi berikutnya
                    }

                    // Pilih guru dengan beban jam terendah
                    $guruId = $this->pilihGuruDenganBebanJamTerdekat($validGuruIds, $guruJam, $bagiBebanJamGuru);
                    $mataPelajaranGuru[$kelas->id][$mataPelajaranId] = $guruId;
                } else {
                    $guruId = $mataPelajaranGuru[$kelas->id][$mataPelajaranId];
                }

                // Mendapatkan jam mulai dan selesai
                list($jamMulai, $jamSelesai) = explode(' - ', $sesi);

                // Pilih ruangan secara acak
                $ruanganId = $ruanganTersedia->random()->id;

                // Menyimpan jadwal
                $jadwal = Jadwal::create([
                    'tahun_ajaran_id' => $tahunAjaranId,
                    'kelas_id' => $kelas->id,
                    'ruangan_id' => $ruanganId,
                    'mapel_id' => $mataPelajaranId,
                    'guru_id' => $guruId,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'urutan' => $hari . ' ' . ($index + 1) // Format urutan
                ]);

                // Update waktu mengajar guru
                $guruJam[$guruId] += $this->hitungDurasiJam($jamMulai, $jamSelesai);

                // Debugging
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