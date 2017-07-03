<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempatTidurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempat_tidur', function (Blueprint $table) {
            $table->string('no_kamar');
            $table->integer('no_tempat_tidur');
            $table->string('status',1);
            $table->timestamps();

            $table->primary(['no_kamar', 'no_tempat_tidur']);
            $table->foreign('no_kamar')
                    ->references('no_kamar')
                    ->on('kamar_rawatinap')
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
        Schema::dropIfExists('tempat_tidur');
    }
}
