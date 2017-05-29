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
            $table->integer('id_pasien')->unsigned();
            $table->datetime('tanggal_waktu');
            $table->foreign('id_pasien')->references('id_pasien')->on('rekam_medis')->primary()->onDelete('cascade');
            $table->foreign('tanggal_waktu')->references('tanggal_waktu')->on('rekam_medis')->onDelete('cascade');
            $table->string('jenis_resep');
            $table->jsonb('daftar_obat');
            $table->string('aturan_pemakaian');
            $table->string('petunjuk_peracikan');
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
        Schema::table('resep', function (Blueprint $table) {
            $table->dropForeign('resep_id_pasien_foreign');
            $table->dropForeign('resep_tanggal_waktu_foreign');
        });
        Schema::dropIfExists('resep');
    }
}
