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
            $table->increments('id');
            $table->string('no_kamar');
            $table->integer('no_tempat_tidur');
            $table->integer('id_transaksi');
            $table->integer('id_pembayaran')->nullable();
            $table->dateTime('waktu_masuk')->nullable();
            $table->dateTime('waktu_keluar')->nullable();
            $table->date('tanggal_booking')->nullable();
            $table->integer('harga');
            $table->string('no_pegawai');

            $table->timestamps();

            $table->unique(['no_kamar', 'no_tempat_tidur', 'id_transaksi', 'waktu_masuk']);
            $table->foreign(['no_kamar', 'no_tempat_tidur'])
                    ->references(['no_kamar', 'no_tempat_tidur'])
                    ->on('tempat_tidur')
                    ->onDelete('cascade');

            $table->foreign('id_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('id_pembayaran')
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
        Schema::table('pemakaian_kamar_rawatinap', function (Blueprint $table) {
            $table->dropForeign(['no_kamar', 'no_tempat_tidur']);
            $table->dropForeign(['no_pegawai']);
            $table->dropForeign(['id_transaksi']);
            $table->dropForeign(['id_pembayaran']);
        });
        Schema::dropIfExists('pemakaian_kamar_rawatinap');
    }
}
