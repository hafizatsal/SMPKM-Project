<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KelasTersedia;

class UpdateTingkatKelasSeeder extends Seeder
{
    public function run()
    {
        $kelasTersediaList = KelasTersedia::with('kelas')->get();

        foreach ($kelasTersediaList as $kelasTersedia) {
            if ($kelasTersedia->kelas) {
                $kelasNama = $kelasTersedia->kelas->nama_kelas;

                // Debug output
                $this->command->info("Checking kelas: {$kelasNama}");

                if (preg_match('/^\d+/', $kelasNama, $matches)) {
                    $tingkat = (int) $matches[0];

                    // Update nilai tingkat di database
                    $kelasTersedia->update(['tingkat' => $tingkat]);

                    $this->command->info("Updated ID {$kelasTersedia->id} with tingkat $tingkat");
                } else {
                    $this->command->warn("No match for {$kelasNama}");
                }
            } else {
                $this->command->warn("No related kelas for ID {$kelasTersedia->id}");
            }
        }
    }
}