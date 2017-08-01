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
            $table->string('nama_layanan_poli')->nullable();
            $table->string('nama_layanan_lab')->nullable();
            $table->string('nama_pasien')->nullable();
            $table->integer('jenis'); //0: umum, 1: khusus
            $table->integer('kesempatan');
            $table->string('kategori_antrian');
            $table->boolean('via_sms')->nullable();
            $table->dateTime('waktu_masuk_antrian');
            $table->dateTime('waktu_perubahan_antrian');

            $table->unique(['nama_layanan_poli', 'no_antrian']);
            $table->unique(['nama_layanan_lab', 'no_antrian']);

            $table->foreign('nama_layanan_poli')
                    ->references('nama')
                    ->on('poliklinik')
                    ->onDelete('cascade');
                    
            $table->foreign('nama_layanan_lab')
                    ->references('nama')
                    ->on('laboratorium')
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
            $table->dropForeign(['nama_layanan_poli']);
            $table->dropForeign(['nama_layanan_lab']);
        });
        Schema::dropIfExists('antrian_front_office');
    }
}
