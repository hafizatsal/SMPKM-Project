<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SesiWaktu;

class SesiWaktuSeeder extends Seeder
{
    public function run()
    {
        // Data sesi waktu untuk Senin-Kamis
        $sesiWaktuSeninKamis = [
            ['jam_mulai' => '08:00', 'jam_selesai' => '09:00'],
            ['jam_mulai' => '09:00', 'jam_selesai' => '10:00'],
            ['jam_mulai' => '10:00', 'jam_selesai' => '11:00'],
            ['jam_mulai' => '11:00', 'jam_selesai' => '12:00'],
            ['jam_mulai' => '13:30', 'jam_selesai' => '14:30'],
            ['jam_mulai' => '14:30', 'jam_selesai' => '15:30']
        ];

        // Data sesi waktu untuk Jumat
        $sesiWaktuJumat = [
            ['jam_mulai' => '08:00', 'jam_selesai' => '09:00'],
            ['jam_mulai' => '09:00', 'jam_selesai' => '10:00'],
            ['jam_mulai' => '10:00', 'jam_selesai' => '11:00'],
            ['jam_mulai' => '11:00', 'jam_selesai' => '12:00'],
            ['jam_mulai' => '13:30', 'jam_selesai' => '14:30']
        ];

        // Masukkan data ke tabel
        foreach ($sesiWaktuSeninKamis as $sesi) {
            SesiWaktu::create([
                'hari' => 'Senin-Kamis',
                'jam_mulai' => $sesi['jam_mulai'],
                'jam_selesai' => $sesi['jam_selesai']
            ]);
        }

        foreach ($sesiWaktuJumat as $sesi) {
            SesiWaktu::create([
                'hari' => 'Jumat',
                'jam_mulai' => $sesi['jam_mulai'],
                'jam_selesai' => $sesi['jam_selesai']
            ]);
        }
    }
}
