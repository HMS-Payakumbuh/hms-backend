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
                    
            $table->integer('resep_item_id')->unsigned();            
            $table->integer('id_jenis_obat')->unsigned();

            $table->integer('jumlah');

            $table->timestamps();

            $table
              ->foreign('resep_item_id')
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
        Schema::dropIfExists('racikan_item');
    }
}
