<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJasaDokterOperasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa_dokter_operasi', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pemakaian_kamar_operasi');
            $table->string('np_tenaga_medis');
            $table->timestamps();

            $table->unique(['id_pemakaian_kamar_operasi', 'np_tenaga_medis']);
            $table->foreign('id_pemakaian_kamar_operasi')->references('id')->on('pemakaian_kamar_operasi')->onDelete('restrict')->onUpdate('cascade');
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
         Schema::table('jasa_dokter_operasi', function (Blueprint $table) {
            $table->dropForeign(['id_pemakaian_kamar_operasi']);
            $table->dropForeign(['np_tenaga_medis']);
        });
        Schema::dropIfExists('jasa_dokter_operasi');
    }
}