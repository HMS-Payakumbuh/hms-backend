<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemakaianKamarJenazah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_kamar_jenazah', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_kamar');
            $table->integer('id_transaksi');
            $table->integer('no_pembayaran')->nullable();
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->integer('harga');

            $table->timestamps();

            $table->unique(['no_kamar', 'no_transaksi', 'waktu_masuk']);
            $table->foreign('no_kamar')
                    ->references('no_kamar')
                    ->on('kamar_jenazah')
                    ->onDelete('cascade');

            $table->foreign('id_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('no_pembayaran')
                    ->references('id')
                    ->on('pembayaran')
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
        Schema::table('pemakaian_kamar_jenazah', function (Blueprint $table) {
            $table->dropForeign(['no_kamar']);
            $table->dropForeign(['id_transaksi']);
            $table->dropForeign(['no_pembayaran']);
        });
        Schema::dropIfExists('pemakaian_kamar_jenazah');
    }
}
