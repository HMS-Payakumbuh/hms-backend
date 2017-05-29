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
            $table->foreign('no_transaksi')->references('no_transaksi')->on('transaksi')->primary()->onDelete('cascade');
            $table->foreign('nama_layanan')->references('nama_layanan')->on('layanan')->onDelete('cascade');
            $table->timestamps('waktu_masuk_antrian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian');
    }
}
