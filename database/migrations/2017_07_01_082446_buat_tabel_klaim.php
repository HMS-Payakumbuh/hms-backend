<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelKlaim extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klaim', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('id_pembayaran')->unsigned();
            $table->integer('id_asuransi')->unsigned();
            $table->string('status');
            $table->decimal('tarif', 65, 2);

            $table->timestamps();

            $table->foreign('id_pembayaran')
                    ->references('id')->on('transaksi')
                    ->onDelete('cascade');

            $table->foreign('id_asuransi')
                    ->references('id')->on('asuransi')
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
        Schema::table('klaim', function (Blueprint $table) {
            $table->dropForeign('klaim_id_pembayaran_foreign');
            $table->dropForeign('klaim_id_asuransi_foreign');
        });
        Schema::dropIfExists('klaim');
    }
}
