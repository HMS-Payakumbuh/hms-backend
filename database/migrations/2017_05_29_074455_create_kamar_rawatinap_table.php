<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKamarRawatInapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar_rawatinap', function (Blueprint $table) {
            $table->string('no_kamar')->primary();
            $table->string('jenis_kamar');
            $table->string('kelas');
            $table->integer('harga_per_hari');
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
        Schema::dropIfExists('kamar_rawatinap');
    }
}
