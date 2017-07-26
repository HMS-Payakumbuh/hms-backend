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
            $table->integer('id_transaksi')->unsigned();
            $table->decimal('harga_bayar', 65, 2);
            $table->string('metode_bayar'); //tunai atau dengan asuransi
            $table->integer('pembayaran_tambahan'); //0: pembayaran biasa, 1: pembayaran tambahan

            $table->timestamps();

            $table->foreign('id_transaksi')
                    ->references('id')->on('transaksi')
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
        });
        Schema::dropIfExists('pembayaran');
    }
}
