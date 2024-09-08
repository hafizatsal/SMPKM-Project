<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJadwalTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tahun_ajaran_id')->nullable();
            $table->unsignedInteger('kelas_id');
            $table->unsignedInteger('ruangan_id');
            $table->unsignedInteger('mapel_id');
            $table->unsignedBigInteger('guru_id'); // Menggunakan bigInteger untuk guru_id
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'])->collation('utf8mb4_unicode_ci');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();

            // Menambahkan foreign key dengan onDelete dan onUpdate
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('mapel_id')->references('id')->on('mata_pelajaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('guru_id')->references('nip')->on('guru')->onDelete('cascade')->onUpdate('cascade'); // Menghubungkan dengan kolom nip pada tabel guru
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('jadwal');
    }
}
