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
            $table->integer('id_transaksi')->unsigned()->primary();
            $table->string('nama_layanan');
            $table->integer('jenis'); //0: umum, 1: khusus
            $table->integer('no_antrian');
            $table->integer('status'); //0: open, 1: close
            $table->timestamps();

            $table->foreign('id_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');
            $table->foreign('nama_layanan')
                    ->references('nama')
                    ->on('poliklinik')
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
        Schema::dropIfExists('antrian');
    }
}
