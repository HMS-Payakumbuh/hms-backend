<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAntrianFrontOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian_front_office', function (Blueprint $table) {
            $table->string('nama_layanan');
            $table->integer('no_antrian');
            $table->integer('jenis'); //0: umum, 1: khusus
            $table->string('kategori_antrian');
            $table->timestamps();

            $table->primary(['nama_layanan', 'no_antrian']);

            $table->foreign('nama_layanan')
                    ->references('nama')
                    ->on('poliklinik')
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
        Schema::dropIfExists('antrian_front_office');
    }
}
