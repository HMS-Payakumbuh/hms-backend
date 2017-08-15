<?php

use Illuminate\Database\Seeder;

class KamarRawatInapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('kamar_rawatinap')->insert(array(
          array('no_kamar'=>'Melati-001', 'jenis_kamar'=>'Rawat Inap', 'kelas'=>'VIP', 'harga_per_hari'=>1200000),
          array('no_kamar'=>'Melati-002', 'jenis_kamar'=>'Rawat Inap', 'kelas'=>'1', 'harga_per_hari'=>1000000),
          array('no_kamar'=>'Melati-003', 'jenis_kamar'=>'Rawat Inap', 'kelas'=>'2', 'harga_per_hari'=>800000),
          array('no_kamar'=>'Melati-004', 'jenis_kamar'=>'Rawat Inap', 'kelas'=>'3', 'harga_per_hari'=>600000),
          array('no_kamar'=>'Anggrek-001', 'jenis_kamar'=>'ICU', 'kelas'=>'VIP', 'harga_per_hari'=>1500000),
          array('no_kamar'=>'Anggrek-002', 'jenis_kamar'=>'ICU', 'kelas'=>'1', 'harga_per_hari'=>1200000)
       ));
    }
}