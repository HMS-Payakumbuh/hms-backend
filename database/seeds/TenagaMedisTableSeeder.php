<?php

use Illuminate\Database\Seeder;

class TenagaMedisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('tenaga_medis')->insert(array(
        array('no_pegawai'=>'D001', 'nama'=>'Dokter A', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'D002', 'nama'=>'Dokter B', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'P001', 'nama'=>'Perawat', 'jabatan'=>'Perawat'),
        array('no_pegawai'=>'L001', 'nama'=>'Petugas Administrasi Lab', 'jabatan'=>'Petugas Lab'),
        array('no_pegawai'=>'L002', 'nama'=>'Petugas Lab', 'jabatan'=>'Petugas Lab')
      ));
    }
}
