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
            $table->integer('no_transaksi')->unsigned();
            $table->dateTime('waktu');
            $table->decimal('harga_bayar', 65, 2);
            $table->string('metode_bayar');
            
            $table->timestamps();

            $table->foreign('no_transaksi')
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
        Schema::drop('pembayaran');
    }
}
