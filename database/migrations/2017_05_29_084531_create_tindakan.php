<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTindakan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tindakan', function (Blueprint $table) {
            $table->integer('nomor_tindakan');
            $table->string('nama');
            $table->decimal('harga', 65, 2);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->integer('nomor_transaksi');
            $table->string('nama_layanan');
            $table->integer('id_tenaga_medis');

            $table->primary(['nomor_tindakan', 'nomor_transaksi']);
            $table->foreign('nomor_transaksi')->references('id')->on('transaksi')->onDelete('restrict');
            $table->foreign('nama_layanan')->references('nama_layanan')->on('layanan')->onDelete('restrict');
            $table->foreign('id_tenaga_medis')->references('id')->on('tenaga_medis')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tindakan', function (Blueprint $table) {
            $table->dropForeign(['nomor_transaksi']);
            $table->dropForeign(['nama_layanan']);
            $table->dropForeign(['id_tenaga_medis']);
        });
        Schema::dropIfExists('tindakan');
    }
}
