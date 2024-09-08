<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRuanganTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ruangan', function (Blueprint $table) {
        $table->increments('id');
        $table->string('nama_ruangan', 50)->collation('utf8mb4_unicode_ci');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('ruangan');
}
};
