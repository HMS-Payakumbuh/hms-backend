<?php

use Illuminate\Database\Seeder;

class JenisObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('jenis_obat')->insert(array(
          array('merek_obat'=>'Panadol', 'nama_generik'=>'Paracetamol', 'pembuat'=>'GSK', 'golongan'=>'Bebas', 'satuan'=>'blister', 'harga_jual_satuan'=>9500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Panadol Extra', 'nama_generik'=>'Paracetamol, Caffeine', 'pembuat'=>'GSK', 'golongan'=>'Bebas', 'satuan'=>'blister', 'harga_jual_satuan'=>12000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Actifed', 'nama_generik'=>'Pseudoephedrine', 'pembuat'=>'GSK', 'golongan'=>'Bebas', 'satuan'=>'botol', 'harga_jual_satuan'=>50000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false)
       ));
    }
}