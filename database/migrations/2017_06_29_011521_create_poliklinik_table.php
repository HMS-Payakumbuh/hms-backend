<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliklinikTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('poliklinik', function (Blueprint $table) {
        $table->string('nama')->primary();
        $table->string('kategori_antrian');
        $table->integer('kapasitas_pelayanan');
        $table->integer('sisa_pelayanan');
        $table->integer('id_lokasi');

        $table->foreign('id_lokasi')->references('id')->on('lokasi_obat')->onDelete('cascade');
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
      Schema::table('poliklinik', function (Blueprint $table) {
          $table->dropForeign(['id_lokasi']);
      });
      Schema::dropIfExists('poliklinik');
    }
}
