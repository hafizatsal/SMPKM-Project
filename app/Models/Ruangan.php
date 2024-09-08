<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    protected $fillable = [
        'nama_ruangan'
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'ruangan_id');
    }

    public function kelasTersedia()
    {
        return $this->hasMany(KelasTersedia::class, 'ruangan_id');
    }
}
