<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekamMedisEksternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekam_medis_eksternal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_pasien')->unsigned();
            $table->integer('id_pasien')->unsigned();
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('cascade');
            $table->dateTime('tanggal_waktu');
            $table->jsonb('identitas_pasien')->nullable();
            $table->jsonb('identitas_dokter')->nullable();
            $table->jsonb('komponen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('rekam_medis_eksternal', function (Blueprint $table) {
            $table->dropForeign(['id_pasien']);
        });
        Schema::dropIfExists('rekam_medis_eksternal');
    }
}
