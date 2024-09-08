<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelasTersedia;

class UpdateTingkatSeeder extends Seeder
{
    public function run()
    {
        KelasTersedia::with('kelas')->each(function ($kelasTersedia) {
            $namaKelas = $kelasTersedia->kelas->nama_kelas ?? '';
            $tingkat = intval(substr($namaKelas, 0, 2));

            if (in_array($tingkat, [10, 11, 12])) {
                $kelasTersedia->update(['tingkat' => $tingkat]);
            }
        });
    }
}
