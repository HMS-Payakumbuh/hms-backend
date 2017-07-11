<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHasilLabTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_lab', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_transaksi');
          $table->integer('id_tindakan');
          $table->binary('dokumen');

          $table->foreign('id_transaksi')->references('id')->on('transaksi');
          $table->foreign('id_tindakan')->references('id')->on('tindakan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hasil_lab', function (Blueprint $table) {
          $table->dropForeign(['id_transaksi']);
          $table->dropForeign(['id_tindakan']);
        });
        Schema::dropIfExists('hasil_lab');
    }
}
