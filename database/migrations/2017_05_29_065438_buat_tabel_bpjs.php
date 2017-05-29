<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelBpjs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bpjs', function(Blueprint $table) {
            $table->string('no_sep')->primary();
            $table->integer('id_pembayaran')->unsigned();
            $table->string('no_kartu_bpjs');
            $table->string('no_rujukan');
            $table->string('status_klaim');
            $table->dateTime('waktu_klaim');
            $table->decimal('tarif_ina_cbg', 65, 2);

            $table->foreign('id_pembayaran')
                    ->references('id')->on('pembayaran')
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
        Schema::drop('bpjs');
    }
}
