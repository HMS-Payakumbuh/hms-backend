<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJasaDokterRawatinapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa_dokter_rawatinap', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pemakaian_kamar_rawatinap');
            $table->string('np_tenaga_medis');
            $table->timestamps();

            $table->unique(['id_pemakaian_kamar_rawatinap', 'np_tenaga_medis']);
            $table->foreign('id_pemakaian_kamar_rawatinap')->references('id')->on('pemakaian_kamar_rawatinap')->onDelete('restrict')->onUpdate('cascade');
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
         Schema::table('jasa_dokter_rawatinap', function (Blueprint $table) {
            $table->dropForeign(['id_pemakaian_kamar_rawatinap']);
            $table->dropForeign(['np_tenaga_medis']);
        });
        Schema::dropIfExists('jasa_dokter_rawatinap');
    }
}
