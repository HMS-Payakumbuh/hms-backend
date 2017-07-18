<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLokasiObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lokasi_obat', function (Blueprint $table) {
            $table->increments('id');
			$table->string('nama');            
            $table->integer('jenis'); //0 : Gudang Utama, 1: Apotek, 2: Poliklinik, 3: Lain-lain
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
        Schema::dropIfExists('lokasi_obat');
    }
}
