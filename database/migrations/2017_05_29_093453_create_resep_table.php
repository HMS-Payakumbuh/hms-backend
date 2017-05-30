<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resep', function (Blueprint $table) {
            $table->integer('no_resep');
            $table->integer('id_pasien_resep')->unsigned();
            $table->datetime('tanggal_waktu_resep');
            $table->foreign(['id_pasien_resep', 'tanggal_waktu_resep'])->references(['id_pasien', 'tanggal_waktu'])->on('rekam_medis')->onDelete('cascade');
            $table->string('jenis_resep');
            $table->jsonb('daftar_obat');
            $table->string('aturan_pemakaian');
            $table->string('petunjuk_peracikan');
            $table->timestamps();

            $table->primary(['no_resep', 'id_pasien_resep','tanggal_waktu_resep']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resep', function (Blueprint $table) {
            $table->dropForeign(['id_pasien_resep', 'tanggal_waktu_resep']);
        });
        Schema::dropIfExists('resep');
    }
}
