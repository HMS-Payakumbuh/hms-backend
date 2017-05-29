<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePemakaianTempatTidurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemakaian_tempat_tidur', function (Blueprint $table) {
            $table->integer('no_kamar');
            $table->integer('no_tempat_tidur');
            $table->integer('no_transaksi');
            $table->timestamps();

            $table->primary(['no_kamar', 'no_tempat_tidur', 'no_transaksi']);
            $table->foreign(['no_kamar', 'no_tempat_tidur'])
                    ->references(['no_kamar', 'no_tempat_tidur'])
                    ->on('tempat_tidur')
                    ->onDelete('cascade');

            $table->foreign('no_transaksi')
                    ->references('id')
                    ->on('transaksi')
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
        Schema::dropIfExists('pemakaian_tempat_tidur');
    }
}
