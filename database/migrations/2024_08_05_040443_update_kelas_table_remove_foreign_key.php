<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKelasTableRemoveForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['tahun_ajaran_id']);

            // Modify the column to not have foreign key constraint
            $table->unsignedInteger('tahun_ajaran_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kelas', function (Blueprint $table) {
            // Re-add the foreign key constraint
            $table->foreign('tahun_ajaran_id')->references('id')->on('tahun_ajaran')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
