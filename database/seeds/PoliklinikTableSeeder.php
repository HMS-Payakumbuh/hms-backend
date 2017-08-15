<?php

use Illuminate\Database\Seeder;

class PoliklinikTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('poliklinik')->insert(array(
        array('nama'=>'Poli Umum', 'kategori_antrian'=>'A', 'kapasitas_pelayanan'=>100, 'sisa_pelayanan'=>100, 'id_lokasi'=>3),
        array('nama'=>'Poli Jantung', 'kategori_antrian'=>'B', 'kapasitas_pelayanan'=>40, 'sisa_pelayanan'=>40, 'id_lokasi'=>4),
        array('nama'=>'Poli THT', 'kategori_antrian'=>'B', 'kapasitas_pelayanan'=>50, 'sisa_pelayanan'=>50, 'id_lokasi'=>5),
        array('nama'=>'IGD', 'kategori_antrian'=>'IGD', 'kapasitas_pelayanan'=>100, 'sisa_pelayanan'=>100, 'id_lokasi'=>6),
      ));
    }
}
