<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianFrontOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_front_office', function (Blueprint $table) {
            $table->increments('no_antrian');
            $table->string('nama_layanan');
            $table->integer('jenis'); //0: umum, 1: khusus
            $table->string('kategori_antrian');
            $table->dateTime('waktu_masuk_antrian');
            $table->dateTime('waktu_perubahan_antrian');

            $table->unique(['nama_layanan', 'no_antrian']);

            $table->foreign('nama_layanan')
                    ->references('nama')
                    ->on('poliklinik')
                    ->onDelete('cascade');      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('antrian_front_office', function (Blueprint $table) {
            $table->dropForeign(['nama_layanan']);
        });
        Schema::dropIfExists('antrian_front_office');
    }
}
