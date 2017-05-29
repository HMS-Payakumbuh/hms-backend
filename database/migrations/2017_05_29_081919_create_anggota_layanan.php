<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnggotaLayanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anggota_layanan', function (Blueprint $table) {
            $table->integer('id_tenaga_medis');
            $table->string('nama_layanan');
            $table->integer('shift');
            
            $table->primary(['id_tenaga_medis', 'nama_layanan']);
            $table->foreign('id_tenaga_medis')->references('id')->on('tenaga_medis')->onDelete('cascade');
            $table->foreign('nama_layanan')->references('nama_layanan')->on('layanan')->onDelete('cascade');
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
        Schema::table('anggota_layanan', function (Blueprint $table) {
            $table->dropForeign(['id_tenaga_medis']);
            $table->dropForeign(['nama_layanan']);
        });
        Schema::dropIfExists('anggota_layanan');
    }
}
