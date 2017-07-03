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
            $table->string('no_kamar');
            $table->integer('no_transaksi');
            $table->integer('no_pembayaran');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar');
            $table->integer('harga');

            $table->timestamps();

            $table->primary(['no_kamar', 'no_transaksi', 'waktu_masuk']);
            $table->foreign('no_kamar')
                    ->references('no_kamar')
                    ->on('kamar_jenazah')
                    ->onDelete('cascade');

            $table->foreign('no_transaksi')
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
        //
    }
}
