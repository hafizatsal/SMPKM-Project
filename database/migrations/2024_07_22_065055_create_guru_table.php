<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('guru', function (Blueprint $table) {
        $table->unsignedBigInteger('nip')->primary();
        $table->string('nama', 100)->collation('utf8mb4_unicode_ci');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->collation('utf8mb4_unicode_ci');
        $table->date('tanggal_lahir');
        $table->text('alamat')->collation('utf8mb4_unicode_ci');
        $table->string('telepon', 15)->nullable()->collation('utf8mb4_unicode_ci');
        $table->string('email', 100)->nullable()->collation('utf8mb4_unicode_ci');
        $table->string('foto', 255)->nullable()->collation('utf8mb4_unicode_ci');
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('guru');
}

};
