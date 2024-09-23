<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Jadwal; 
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use App\Models\GuruMataPelajaran;
use App\Models\Ruangan;
use App\Models\KelasTersedia;
use App\Models\TahunAjaran;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function home()
    {
        Carbon::setLocale('id');

        $now = Carbon::now();
        $currentDay = $now->isoFormat('dddd');
        $currentDate = $now->isoFormat('D MMMM YYYY');
        $currentTime = $now->format('H:i');

        $currentYear = $now->year;
        $academicYear = ($now->month >= 7) 
            ? $currentYear . '/' . ($currentYear + 1) 
            : ($currentYear - 1) . '/' . $currentYear;

        // Ambil tahun ajaran
        $tahunAjaran = TahunAjaran::where('tahun', $academicYear)->first();
        $tahunAjaranId = $tahunAjaran ? $tahunAjaran->id : null;

        if (!$tahunAjaranId) {
            Log::warning('Tahun ajaran tidak ditemukan untuk akademik tahun: ' . $academicYear);
            return view('admin.home', [
                'currentDay' => $currentDay,
                'currentDate' => $currentDate,
                'currentTime' => $currentTime,
                'jadwalHariIni' => collect(),
                'jadwalSekarang' => collect(),
                'academicYear' => $academicYear,
                'tahunAjaranId' => null,
                'kelasList' => collect(),
                'currentClass' => 'A',
                'currentGrade' => '10',
                'currentKelas' => 'Tidak ada kelas',
                'jadwalsGrouped' => collect()
            ]);
        }

        // Ambil jadwal hari ini berdasarkan tahun ajaran
        $jadwalHariIni = Jadwal::where('hari', $currentDay)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->get();

        // Ambil jadwal yang sedang berlangsung sekarang
$jadwalSekarang = Jadwal::where('hari', $currentDay)
->where('jam_mulai', '<=', $currentTime)
->where('jam_selesai', '>', $currentTime) // Mengubah ini dari '>=' ke '>'
->where('tahun_ajaran_id', $tahunAjaranId)
->get();


        // Kelompokkan jadwal berdasarkan kelas
        $jadwalsGrouped = $jadwalHariIni->groupBy(function($jadwal) {
            return $jadwal->kelas->nama_kelas;
        });

        // Ambil daftar kelas dari database
        $kelasList = Kelas::whereHas('kelasTersedia', function ($query) use ($tahunAjaranId) {
            $query->where('tahun_ajaran_id', $tahunAjaranId);
        })->get();

        // Tentukan kelas saat ini
        $currentKelas = $jadwalHariIni->isNotEmpty() ? $jadwalHariIni->first()->kelas->nama_kelas : 'Tidak ada kelas';
        if ($currentKelas === 'Tidak ada kelas' && $jadwalSekarang->isNotEmpty()) {
            $currentKelas = $jadwalSekarang->first()->kelas->nama_kelas;
        }

        return view('admin.home', [
            'currentDay' => $currentDay,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwalSekarang' => $jadwalSekarang,
            'academicYear' => $academicYear,
            'tahunAjaranId' => $tahunAjaranId,
            'kelasList' => $kelasList,
            'currentClass' => 'A', // Misal kelas default
            'currentGrade' => '10', // Misal tingkat default
            'currentKelas' => $currentKelas,
            'jadwalsGrouped' => $jadwalsGrouped
        ]);
    }

    public function getJadwal(Request $request)
    {
        $tingkat = $request->input('tingkat');
        $kelas = $request->input('kelas');

        // Memfilter jadwal berdasarkan tingkat dan kelas
        $jadwals = Jadwal::whereHas('kelas', function($query) use ($tingkat, $kelas) {
            $query->where('tingkat', $tingkat)
                  ->where('nama_kelas', $kelas);
        })->get();

        return response()->json(['jadwal' => $jadwals]);
    }

    public function homeDaftarJadwal(Request $request)
    {
        // Ambil ID tahun ajaran dari permintaan
        $tahunAjaranId = $request->input('tahun_ajaran', 1);
        $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)->pluck('kelas_id');

        Log::info('Kelas Tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ':', $kelasTersedia->toArray());

        // Ambil jadwal berdasarkan kelas yang tersedia dan tahun ajaran
        $jadwals = Jadwal::with(['kelas', 'ruangan', 'mataPelajaran', 'guru'])
            ->whereIn('kelas_id', $kelasTersedia)
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->get();

        Log::info('Jadwals untuk tahun ajaran ID ' . $tahunAjaranId . ':', $jadwals->toArray());

        // Kelompokkan jadwal berdasarkan kelas
        $jadwalsGrouped = $jadwals->groupBy('kelas.nama_kelas');

        // Ambil semua tahun ajaran
        $tahunAjarans = TahunAjaran::all();

        return view('Admin.layout.Jadwal.HomeDaftarJadwal', [
            'jadwalsGrouped' => $jadwalsGrouped,
            'tahunAjarans' => $tahunAjarans,
            'tahunAjaranId' => $tahunAjaranId
        ]);
    }
}
