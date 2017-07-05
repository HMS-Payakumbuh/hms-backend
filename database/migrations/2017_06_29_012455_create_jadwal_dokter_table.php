<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJadwalDokterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_poli');
            $table->string('np_dokter');
            $table->dateTime('tanggal');
            $table->time('waktu_mulai_praktik');
            $table->time('waktu_selesai_praktik');

            $table->unique(['nama_poli', 'np_dokter']);
            $table->foreign('nama_poli')->references('nama')->on('poliklinik')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('np_dokter')->references('no_pegawai')->on('dokter')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::table('jadwal_dokter', function (Blueprint $table) {
            $table->dropForeign(['nama_poli']);
            $table->dropForeign(['np_dokter']);
        });
        Schema::dropIfExists('jadwal_dokter');
    }
}
