<?php

use Illuminate\Database\Seeder;

class DaftarTindakanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('daftar_tindakan')->insert(array(
        array('kode'=>'100.01', 'nama'=>'Cek darah standar', 'harga'=>150000),
        array('kode'=>'100.02', 'nama'=>'Cek darah lengkap', 'harga'=>500000),
        array('kode'=>'00.00', 'nama'=>'Pemakaian ambulans', 'harga'=>50000),
      ));
    }
}
