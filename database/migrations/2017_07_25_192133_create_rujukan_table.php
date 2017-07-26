<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRujukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rujukan', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_transaksi')->unsigned();
            $table->string('asal_rujukan');
            $table->string('no_rujukan');
            $table->string('diagnosis');
            $table->string('keterangan');
            $table->timestamps();

            $table->foreign('id_transaksi')
                    ->references('id')->on('transaksi')
                    ->onDelete('restrict')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rujukan', function (Blueprint $table) {
            $table->dropForeign(['id_transaksi']);
        });
        Schema::dropIfExists('transaksi');
    }
}
