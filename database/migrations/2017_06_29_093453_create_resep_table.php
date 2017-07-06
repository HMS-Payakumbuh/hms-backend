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
            $table->integer('id_transaksi')->unsigned();
            $table->integer('no_tindakan')->unsigned();
            $table->integer('no_resep')->unsigned();

            $table->timestamps();

            $table
              ->foreign(array('id_transaksi', 'no_tindakan'))
              ->references(array('id_transaksi', 'no_tindakan'))
              ->on('tindakan')
              ->onDelete('restrict');

            $table->primary(['no_resep', 'id_transaksi', 'no_tindakan']);
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
            $table->dropForeign(['id_transaksi','no_tindakan']);
        });
        Schema::dropIfExists('resep');
    }
}
