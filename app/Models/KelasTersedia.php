<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasTersedia extends Model
{
    use HasFactory;

    protected $table = 'kelas_tersedia';

    // Isi kolom yang dapat diisi secara massal
    protected $fillable = [
        'tahun_ajaran_id',
        'ruangan_id',
        'kelas_id',
        'tingkat', // Pastikan kolom tingkat ada di sini
    ];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }
}
