<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTingkatToKelasTersediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas_tersedia', function (Blueprint $table) {
            $table->string('tingkat')->after('kelas_id'); // Tambahkan kolom tingkat setelah kelas_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas_tersedia', function (Blueprint $table) {
            $table->dropColumn('tingkat');
        });
    }
}
