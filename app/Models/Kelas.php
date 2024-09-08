<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'tingkat', // Menambahkan 'tingkat' ke atribut fillable
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'kelas_id');
    }

    public function kelasTersedia()
    {
        return $this->hasMany(KelasTersedia::class, 'kelas_id');
    }

    public function setNamaKelasAttribute($value)
    {
        $this->attributes['nama_kelas'] = $value;
        $this->attributes['tingkat'] = (int) substr($value, 0, 2); // Extract tingkat from nama_kelas
    }
}
