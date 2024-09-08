<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTersediaTable extends Migration
{
    public function up()
    {
        Schema::create('kelas_tersedia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tahun_ajaran_id'); // Menambahkan unsigned
            $table->unsignedInteger('kelas_id'); // Menambahkan unsigned
            $table->unsignedInteger('ruangan_id'); // Menambahkan unsigned
            $table->timestamps();

            // Foreign key constraints dengan onDelete dan onUpdate
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ruangan_id')->references('id')->on('ruangan')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('kelas_tersedia', function (Blueprint $table) {
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['ruangan_id']);
        });

        Schema::dropIfExists('kelas_tersedia');
    }
}
