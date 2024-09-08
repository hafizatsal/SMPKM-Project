<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataPelajaranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('mata_pelajaran', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nama_mapel', 100)->collation('utf8mb4_unicode_ci');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('mata_pelajaran');
}

};
