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
        array('no_pegawai'=>'D001', 'nama'=>'Dokter Umum', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'D002', 'nama'=>'Dokter Jantung', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'D003', 'nama'=>'Dokter Penyakit Dalam', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'D004', 'nama'=>'Dokter Umum 2', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'D005', 'nama'=>'Dokter THT', 'jabatan'=>'Dokter'),
        array('no_pegawai'=>'P001', 'nama'=>'Perawat', 'jabatan'=>'Perawat'),
        array('no_pegawai'=>'L001', 'nama'=>'Petugas Administrasi Lab', 'jabatan'=>'Petugas Lab'),
        array('no_pegawai'=>'L002', 'nama'=>'Petugas Lab', 'jabatan'=>'Petugas Lab'),
      ));
    }
}
