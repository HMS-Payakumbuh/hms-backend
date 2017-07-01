<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelAsuransi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asuransi', function(Blueprint $table) {
            $table->increments('id');
            $table->string('no_kartu')->unique();
            $table->integer('id_pasien')->unsigned();
            $table->string('nama_asuransi');

            $table->timestamps();

            $table->foreign('id_pasien')
                    ->references('id')->on('pasien')
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
        Schema::table('asuransi', function (Blueprint $table) {
            $table->dropForeign('asuransi_id_pasien_foreign');
        });
        Schema::dropIfExists('asuransi');
    }
}
