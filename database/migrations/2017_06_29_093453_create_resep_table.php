<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep', function (Blueprint $table) {
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

            $table->string('nama_dokter');
            $table->boolean('eksternal');
            $table->boolean('tebus');

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
        Schema::table('resep', function (Blueprint $table) {
            $table->dropForeign(['id_transaksi']);
        });
        Schema::dropIfExists('resep');
    }
}
