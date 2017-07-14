<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResepItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('resep_id')->unsigned();
            $table->string('aturan_pemakaian')->nullable();
            $table->string('petunjuk_peracikan')->nullable();
            $table->timestamps();

            $table
              ->foreign('resep_id')
              ->references('id')
              ->on('resep')
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
        Schema::dropIfExists('resep_item');
    }
}
