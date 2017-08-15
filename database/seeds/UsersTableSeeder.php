<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert(array(
          array('no_pegawai'=>'D001', 'name'=>'Dokter A', 'role'=>'dokter', 'password'=>Hash::make('dokter'), 'other'=>''),
          array('no_pegawai'=>'D002', 'name'=>'Dokter B', 'role'=>'dokter', 'password'=>Hash::make('dokter'), 'other'=>''),
          array('no_pegawai'=>'P001', 'name'=>'Perawat', 'role'=>'perawat', 'password'=>Hash::make('perawat'), 'other'=>''),
          array('no_pegawai'=>'L001', 'name'=>'Petugas Administrasi Lab', 'role'=>'petugasLab', 'password'=>Hash::make('petugaslab'), 'other'=>''),
          array('no_pegawai'=>'L002', 'name'=>'Petugas Lab', 'role'=>'petugasLab', 'password'=>Hash::make('petugaslab'), 'other'=>''),
          array('no_pegawai'=>'A001', 'name'=>'Admin', 'role'=>'admin', 'password'=>Hash::make('admin'), 'other'=>''),
          array('no_pegawai'=>'F001', 'name'=>'Front Office A', 'role'=>'frontOffice', 'password'=>Hash::make('frontOffice'), 'other'=>'{"kategori_antrian": "A"}'),
          array('no_pegawai'=>'F002', 'name'=>'Front Office B', 'role'=>'frontOffice', 'password'=>Hash::make('frontOffice'), 'other'=>'{"kategori_antrian": "C"}'),
          array('no_pegawai'=>'AP001', 'name'=>'Staf Apotek', 'role'=>'stafApotek', 'password'=>Hash::make('stafapotek'), 'other'=>''),
          array('no_pegawai'=>'GU001', 'name'=>'Gudang Utama', 'role'=>'gudangUtama', 'password'=>Hash::make('gudangutama'), 'other'=>''),
          array('no_pegawai'=>'K001', 'name'=>'Kasir', 'role'=>'kasir', 'password'=>Hash::make('kasir'), 'other'=>'')
       ));
    }
}
