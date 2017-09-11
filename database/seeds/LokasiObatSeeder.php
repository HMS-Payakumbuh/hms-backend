<?php

use Illuminate\Database\Seeder;

class LokasiObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lokasi_obat')->insert(array(
          array('nama'=>'Gudang Utama', 'jenis'=>0),          
          array('nama'=>'Apotek', 'jenis'=>1),
          array('nama'=>'Poli Umum', 'jenis'=>2), //3
          array('nama'=>'Poli Jantung', 'jenis'=>2), //4
          array('nama'=>'Poli THT', 'jenis'=>2), //5
          array('nama'=>'Poli Penyakit Dalam', 'jenis'=>2), //6
          array('nama'=>'IGD', 'jenis'=>2), //7
          array('nama'=>'Rawat Inap', 'jenis'=>3),
          array('nama'=>'ICU', 'jenis'=>4),
          array('nama'=>'Operasi', 'jenis'=>5)
       ));
    }
}
