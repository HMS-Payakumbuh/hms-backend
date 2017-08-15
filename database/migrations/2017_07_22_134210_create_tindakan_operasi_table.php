<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTindakanOperasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tindakan_operasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_transaksi');
            $table->integer('id_tindakan');
            $table->string('np_tenaga_medis');
            $table->timestamps();

            $table->unique(['id_transaksi', 'id_tindakan', 'np_tenaga_medis']);
            $table->foreign('id_tindakan')->references('id')->on('tindakan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_transaksi')->references('id')->on('transaksi')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('np_tenaga_medis')->references('no_pegawai')->on('tenaga_medis')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('tindakan_operasi', function (Blueprint $table) {
            $table->dropForeign(['id_transaksi']);
            $table->dropForeign(['id_tindakan']);
            $table->dropForeign(['np_tenaga_medis']);
        });
        Schema::dropIfExists('tindakan_operasi');
    }
}
