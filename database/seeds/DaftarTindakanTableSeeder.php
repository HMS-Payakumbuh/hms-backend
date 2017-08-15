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
        array('kode'=>'89.03', 'nama'=>'Interview and evaluation, described as comprehensive', 'harga'=>100000),
        array('kode'=>'33.01', 'nama'=>'Cek darah standar', 'harga'=>150000),
        array('kode'=>'33.02', 'nama'=>'Cek darah lengkap', 'harga'=>500000)
      ));
    }
}
