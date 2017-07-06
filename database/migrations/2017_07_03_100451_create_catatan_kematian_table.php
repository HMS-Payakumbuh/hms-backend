<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatatanKematianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catatan_kematian', function (Blueprint $table) {
            $table->integer('id_pasien')->primary();
            $table->dateTime('waktu_kematian');
            $table->string('tempat_kematian');
            $table->text('perkiraan_penyebab');
            $table->timestamps();

            $table->foreign('id_pasien')
                    ->references('id')
                    ->on('pasien')
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
        Schema::table('catatan_kematian', function (Blueprint $table) {
            $table->dropForeign(['id_pasien']);
        });
        Schema::dropIfExists('catatan_kematian');
    }
}
