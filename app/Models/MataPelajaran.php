<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama_mapel'
    ];

    public function guruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'mata_pelajaran_id');
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'mapel_id');
    }
}
