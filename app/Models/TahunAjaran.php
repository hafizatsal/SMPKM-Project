<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_ajaran';

    protected $fillable = [
        'tahun'
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'tahun_ajaran_id');
    }

    public function kelasTersedia()
    {
        return $this->hasMany(KelasTersedia::class, 'tahun_ajaran_id');
    }
}
