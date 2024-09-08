<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahunAjaranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('tahun_ajaran', function (Blueprint $table) {
        $table->increments('id');
        $table->string('tahun', 20)->collation('utf8mb4_unicode_ci');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('tahun_ajaran');
}

};
