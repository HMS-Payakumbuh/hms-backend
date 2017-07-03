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
            $table->string('no_kamar');
            $table->integer('no_transaksi');
            $table->integer('no_pembayaran');
            $table->integer('no_tindakan');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');
            $table->integer('harga');

            $table->timestamps();

            $table->primary(['no_kamar', 'no_tindakan', 'no_transaksi', 'waktu_masuk']);
            $table->foreign('no_kamar')
                    ->references('no_kamar')
                    ->on('kamar_operasi')
                    ->onDelete('cascade');

            $table->foreign('no_transaksi')
                    ->references('id')
                    ->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('no_pembayaran')
                    ->references('id')
                    ->on('pembayaran')
                    ->onDelete('cascade');

            $table
              ->foreign(array('no_tindakan', 'no_transaksi'))
              ->references(array('no_tindakan', 'no_transaksi'))
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
        Schema::dropIfExists('pemakaian_kamar_operasi');
    }
}
