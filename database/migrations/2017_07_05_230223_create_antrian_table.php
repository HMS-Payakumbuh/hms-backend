<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->increments('no_antrian');
            $table->integer('id_transaksi')->unsigned();
            $table->string('nama_layanan_poli')->nullable();
            $table->string('nama_layanan_lab')->nullable();
            $table->integer('jenis'); //0: umum, 1: khusus
            $table->integer('status'); //0: open, 1: close
            $table->integer('kesempatan');
            $table->dateTime('waktu_masuk_antrian');
            $table->dateTime('waktu_perubahan_antrian');

            $table->unique(['id_transaksi', 'no_antrian']);

            $table->foreign('id_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');
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
        Schema::table('antrian', function (Blueprint $table) {
            $table->dropForeign(['id_transaksi']);
            $table->dropForeign(['nama_layanan_poli']);
            $table->dropForeign(['nama_layanan_lab']);
        });
        Schema::dropIfExists('antrian');
    }
}
