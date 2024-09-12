<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiWaktu extends Model
{
    protected $table = 'sesi_waktu'; // Pastikan nama tabel sesuai
    protected $fillable = ['hari', 'jam_mulai', 'jam_selesai'];
}