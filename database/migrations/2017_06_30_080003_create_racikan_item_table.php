<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRacikanItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('racikan_item', function (Blueprint $table) {
            $table->increments('id');
                    
            $table->integer('id_item')->unsigned();            
            $table->integer('id_jenis_obat')->unsigned();

            $table->integer('jumlah');

            $table->timestamps();

            $table
              ->foreign('id_item')
              ->references('id')
              ->on('resep_item')
              ->onDelete('restrict');

            $table
              ->foreign('id_jenis_obat')
              ->references('id')
              ->on('jenis_obat')
              ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('racikan_item', function (Blueprint $table) {
            $table->dropForeign('no_item');
            $table->dropForeign('id_jenis_obat');
        });
        Schema::dropIfExists('racikan_item');
    }
}
