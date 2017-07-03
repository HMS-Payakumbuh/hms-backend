<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemakaianKamarRawatinapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_kamar_rawatinap', function (Blueprint $table) {
            $table->string('no_kamar');
            $table->integer('no_tempat_tidur')->nullable();
            $table->integer('no_transaksi');
            $table->integer('no_pembayaran');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');
            $table->integer('harga');
            $table->string('no_pegawai');

            $table->timestamps();

            $table->primary(['no_kamar', 'no_tempat_tidur', 'no_transaksi', 'waktu_masuk']);
            $table->foreign(['no_kamar', 'no_tempat_tidur'])
                    ->references(['no_kamar', 'no_tempat_tidur'])
                    ->on('tempat_tidur')
                    ->onDelete('cascade');

            $table->foreign('no_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('no_pembayaran')
                    ->references('id')
                    ->on('pembayaran')
                    ->onDelete('cascade');

            $table->foreign('no_pegawai')
                    ->references('no_pegawai')
                    ->on('tenaga_medis')
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
        Schema::dropIfExists('pemakaian_kamar_rawatinap');
    }
}
