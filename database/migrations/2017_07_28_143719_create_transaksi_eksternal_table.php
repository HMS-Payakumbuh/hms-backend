<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiEksternalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_eksternal', function(Blueprint $table) {
            $table->increments('id');
            $table->string('no_transaksi')->unique()->nullable();
            $table->decimal('harga_total', 65, 2);
            $table->string('status'); //status transaksi (open/closed)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
