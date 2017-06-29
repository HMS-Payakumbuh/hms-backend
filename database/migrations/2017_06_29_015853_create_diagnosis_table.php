<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiagnosisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diagnosis', function (Blueprint $table) {
            $table->integer('id_pasien');
            $table->dateTime('tanggal_waktu');
            $table->string('kode_diagnosis');

            $table->primary(['id_pasien', 'tanggal_waktu', 'kode_diagnosis']);
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('restrict');
            $table->foreign('tanggal_waktu')->references('tanggal_waktu')->on('rekam_medis')->onDelete('restrict');
            $table->foreign('kode_diagnosis')->references('kode')->on('daftar_diagnosis')->onDelete('restrict');
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
        Schema::table('diagnosis', function (Blueprint $table) {
            $table->dropForeign(['id_pasien']);
            $table->dropForeign(['tanggal_waktu']);
            $table->dropForeign(['kode_diagnosis']);
        });
        Schema::dropIfExists('diagnosis');
    }
}
