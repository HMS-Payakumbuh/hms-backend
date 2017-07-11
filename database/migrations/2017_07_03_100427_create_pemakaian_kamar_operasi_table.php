<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemakaianKamarOperasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_kamar_operasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_kamar');
            $table->integer('id_transaksi');
            $table->integer('no_pembayaran')->nullable();
            $table->integer('no_tindakan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');

            $table->timestamps();

            $table->unique(['no_kamar', 'no_tindakan', 'id_transaksi', 'waktu_masuk']);
            $table->foreign('no_kamar')
                    ->references('no_kamar')
                    ->on('kamar_operasi')
                    ->onDelete('cascade');

            $table->foreign('id_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('no_pembayaran')
                    ->references('id')
                    ->on('pembayaran')
                    ->onDelete('cascade');

            $table
              ->foreign(array('no_tindakan', 'id_transaksi'))
              ->references(array('id', 'id_transaksi'))
              ->on('tindakan')
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
        Schema::table('pemakaian_kamar_operasi', function (Blueprint $table) {
            $table->dropForeign(['no_kamar']);
            $table->dropForeign(['id_transaksi']);
            $table->dropForeign(['no_pembayaran']);
        });
        Schema::dropIfExists('pemakaian_kamar_operasi');
    }
}
