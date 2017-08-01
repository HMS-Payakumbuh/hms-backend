<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelPembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function(Blueprint $table) {
            $table->increments('id');
            $table->string('no_pembayaran')->unique()->nullable();
            $table->integer('id_transaksi')->unsigned()->nullable();
            $table->integer('id_transaksi_eksternal')->unsigned()->nullable();
            $table->decimal('harga_bayar', 65, 2);
            $table->string('metode_bayar'); //tunai atau dengan asuransi
            $table->integer('pembayaran_tambahan'); //0: pembayaran biasa, 1: pembayaran tambahan

            $table->timestamps();

            $table->foreign('id_transaksi')
                    ->references('id')->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('id_transaksi_eksternal')
                    ->references('id')->on('transaksi_eksternal')
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
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropForeign('pembayaran_id_transaksi_foreign');
            $table->dropForeign('pembayaran_id_transaksi_eksternal_foreign');
        });
        Schema::dropIfExists('pembayaran');
    }
}
