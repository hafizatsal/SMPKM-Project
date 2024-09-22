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
        // Set locale ke bahasa Indonesia
        Carbon::setLocale('id');

        // Get the current date and time
        $now = Carbon::now();
        $currentDay = $now->isoFormat('dddd'); // Menampilkan hari dalam bahasa Indonesia
        $currentDate = $now->isoFormat('D MMMM YYYY'); // Format tanggal
        $currentTime = $now->format('H:i'); // Waktu saat ini

        // Tentukan tahun ajaran berdasarkan bulan saat ini
        $currentYear = $now->year;
        if ($now->month >= 7) { // Juli hingga Desember
            $academicYear = $currentYear . '/' . ($currentYear + 1);
        } else { // Januari hingga Juni
            $academicYear = ($currentYear - 1) . '/' . $currentYear;
        }

        // Ambil jadwal hari ini
        $jadwalHariIni = Jadwal::where('hari', $currentDay)->get();

        // Ambil jadwal untuk waktu saat ini
        $jadwalSekarang = Jadwal::where('hari', $currentDay)
                                ->where('jam_mulai', '<=', $currentTime)
                                ->where('jam_selesai', '>=', $currentTime)
                                ->get();

        // Ambil tahun_ajaran_id untuk tahun ajaran saat ini
        $tahunAjaran = TahunAjaran::where('tahun', $academicYear)->first();
        $tahunAjaranId = $tahunAjaran ? $tahunAjaran->id : null; // Ambil ID atau null jika tidak ditemukan

        return view('admin.home', [
            'currentDay' => $currentDay,
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
            'jadwalHariIni' => $jadwalHariIni,
            'jadwalSekarang' => $jadwalSekarang,
            'academicYear' => $academicYear,
            'tahunAjaranId' => $tahunAjaranId, // Menyimpan ID tahun ajaran
        ]);
    }

    public function homeDaftarJadwal(Request $request)
{
    $tahunAjaranId = $request->input('tahun_ajaran', 1);

    $kelasTersedia = KelasTersedia::where('tahun_ajaran_id', $tahunAjaranId)->pluck('kelas_id');

    Log::info('Kelas Tersedia untuk tahun ajaran ID ' . $tahunAjaranId . ':', $kelasTersedia->toArray());

    $jadwals = Jadwal::with(['kelas', 'ruangan', 'mataPelajaran', 'guru'])
        ->whereIn('kelas_id', $kelasTersedia)
        ->where('tahun_ajaran_id', $tahunAjaranId)
        ->get();

    Log::info('Jadwals untuk tahun ajaran ID ' . $tahunAjaranId . ':', $jadwals->toArray());

    $jadwalsGrouped = $jadwals->groupBy('kelas.nama_kelas');

    // Ambil semua tahun ajaran
    $tahunAjarans = TahunAjaran::all();

    // Kirimkan variabel ke view
    return view('Admin.layout.Jadwal.HomeDaftarJadwal', [
        'jadwalsGrouped' => $jadwalsGrouped,
        'tahunAjarans' => $tahunAjarans,
        'tahunAjaranId' => $tahunAjaranId
    ]);
}
}
