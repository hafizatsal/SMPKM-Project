<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruMataPelajaranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guru_mata_pelajaran', function (Blueprint $table) {
            $table->increments('id'); // Menggunakan tipe data increments untuk id
            $table->unsignedBigInteger('guru_id'); // Menentukan tipe data untuk guru_id
            $table->unsignedInteger('mata_pelajaran_id'); // Menentukan tipe data untuk mata_pelajaran_id
            $table->integer('tingkat');
            $table->timestamps();

            // Menambahkan foreign key constraints
            $table->foreign('guru_id')
                  ->references('nip')->on('guru')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('mata_pelajaran_id')
                  ->references('id')->on('mata_pelajaran')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('guru_mata_pelajaran');
    }
};
