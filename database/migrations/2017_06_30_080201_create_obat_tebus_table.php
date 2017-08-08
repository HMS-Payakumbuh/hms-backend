<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObatTebusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obat_tebus', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('id_transaksi')->unsigned()->nullable();
            $table
              ->foreign('id_transaksi')
              ->references('id')
              ->on('transaksi')
              ->onDelete('restrict');

            $table->integer('id_transaksi_eksternal')->unsigned()->nullable();
            $table
              ->foreign('id_transaksi_eksternal')
              ->references('id')
              ->on('transaksi_eksternal')
              ->onDelete('restrict');

            $table->boolean('eksternal');

            $table->integer('id_resep')->unsigned(); 
            $table->foreign('id_resep')
                  ->references('id')->on('resep')
                  ->onDelete('restrict');

            $table->dateTime('waktu_keluar');   // Atau pakai timestamp?  
                  
            $table->timestamps();               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat_tebus');
    }
}
