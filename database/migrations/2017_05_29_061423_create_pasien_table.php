<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasienTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_pasien');
            $table->date('tanggal_lahir')->nullable();
            $table->integer('jender'); //0 : Laki-laki, 1: Perempuan
            $table->text('alamat')->nullable();
            $table->string('agama')->nullable();
            $table->string('kontak')->nullable();
            $table->string('gol_darah')->nullable();
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
        Schema::dropIfExists('pasien');
    }
}
