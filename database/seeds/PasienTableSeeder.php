<?php

use Illuminate\Database\Seeder;

class PasienTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('pasien')->insert(array(
        array('nama_pasien'=>'Agus Salim', 'tanggal_lahir'=>'1970-01-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010001'),
        array('nama_pasien'=>'Amita Sumoko', 'tanggal_lahir'=>'1970-01-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010002'),
        array('nama_pasien'=>'Amir Handoko', 'tanggal_lahir'=>'1970-01-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010003'),
        array('nama_pasien'=>'Anita Dina', 'tanggal_lahir'=>'1970-01-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010004'),
        array('nama_pasien'=>'Azka Sidabutar', 'tanggal_lahir'=>'1970-01-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010005'),
        array('nama_pasien'=>'Ari Tonang', 'tanggal_lahir'=>'1970-01-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010006'),
        array('nama_pasien'=>'Anindita Suganda', 'tanggal_lahir'=>'1970-01-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010007'),
        array('nama_pasien'=>'Artasarta Bagus', 'tanggal_lahir'=>'1970-01-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010008'),
        array('nama_pasien'=>'Ani Losari', 'tanggal_lahir'=>'1970-01-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010009'),
        array('nama_pasien'=>'Ali Pergantara', 'tanggal_lahir'=>'1970-01-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010010'),

        array('nama_pasien'=>'Basri Kirno', 'tanggal_lahir'=>'1970-02-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010011'),
        array('nama_pasien'=>'Benita Lemuela', 'tanggal_lahir'=>'1970-02-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010012'),
        array('nama_pasien'=>'Borat Jamsyeh', 'tanggal_lahir'=>'1970-02-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010013'),
        array('nama_pasien'=>'Bandanaira Patel', 'tanggal_lahir'=>'1970-02-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010014'),
        array('nama_pasien'=>'Bimo Syamsuddin', 'tanggal_lahir'=>'1970-02-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010015'),
        array('nama_pasien'=>'Bima Arya', 'tanggal_lahir'=>'1970-02-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010016'),
        array('nama_pasien'=>'Brigitta Simatupang', 'tanggal_lahir'=>'1970-02-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010017'),
        array('nama_pasien'=>'Barry Prima', 'tanggal_lahir'=>'1970-02-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010018'),
        array('nama_pasien'=>'Bella Monika', 'tanggal_lahir'=>'1970-02-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010019'),
        array('nama_pasien'=>'Baratha Jaya', 'tanggal_lahir'=>'1970-02-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010020'),

        array('nama_pasien'=>'Chandra Dimuka', 'tanggal_lahir'=>'1970-03-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010021'),
        array('nama_pasien'=>'Cynthia Supriatna', 'tanggal_lahir'=>'1970-03-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010022'),
        array('nama_pasien'=>'Coki Sitohang', 'tanggal_lahir'=>'1970-03-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010023'),
        array('nama_pasien'=>'Chika Bandung', 'tanggal_lahir'=>'1970-03-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010024'),
        array('nama_pasien'=>'Cecep Basuki', 'tanggal_lahir'=>'1970-03-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010025'),
        array('nama_pasien'=>'Catur Simarmata', 'tanggal_lahir'=>'1970-03-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010026'),
        array('nama_pasien'=>'Cinta Laura', 'tanggal_lahir'=>'1970-03-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010027'),
        array('nama_pasien'=>'Chigga Rich', 'tanggal_lahir'=>'1970-03-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010028'),
        array('nama_pasien'=>'Clara Widya', 'tanggal_lahir'=>'1970-03-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010029'),
        array('nama_pasien'=>'Carlo Munawar', 'tanggal_lahir'=>'1970-03-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010030'),

        array('nama_pasien'=>'Darsono Hasan', 'tanggal_lahir'=>'1970-04-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010031'),
        array('nama_pasien'=>'Diana Julianto', 'tanggal_lahir'=>'1970-04-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010032'),
        array('nama_pasien'=>'Didiet Latief', 'tanggal_lahir'=>'1970-04-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010033'),
        array('nama_pasien'=>'Dinda Fania', 'tanggal_lahir'=>'1970-04-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010034'),
        array('nama_pasien'=>'Dino Sawurus', 'tanggal_lahir'=>'1970-04-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010035'),
        array('nama_pasien'=>'Destra Kusuma', 'tanggal_lahir'=>'1970-04-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010036'),
        array('nama_pasien'=>'Dian Sistro', 'tanggal_lahir'=>'1970-04-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010037'),
        array('nama_pasien'=>'Dadang Rosada', 'tanggal_lahir'=>'1970-04-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010038'),
        array('nama_pasien'=>'Doriska Tampubolon', 'tanggal_lahir'=>'1970-04-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010039'),
        array('nama_pasien'=>'Deddy Combustier', 'tanggal_lahir'=>'1970-04-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010040'),

        array('nama_pasien'=>'Effendi Sinarta', 'tanggal_lahir'=>'1970-05-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010041'),
        array('nama_pasien'=>'Esti Aminah', 'tanggal_lahir'=>'1970-05-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010042'),
        array('nama_pasien'=>'Endang Sukamto', 'tanggal_lahir'=>'1970-05-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010043'),
        array('nama_pasien'=>'Elly Rini', 'tanggal_lahir'=>'1970-05-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010044'),
        array('nama_pasien'=>'Entis Sutisna', 'tanggal_lahir'=>'1970-05-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010045'),
        array('nama_pasien'=>'Eman Fariz', 'tanggal_lahir'=>'1970-05-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010046'),
        array('nama_pasien'=>'Elsa Sumarsono', 'tanggal_lahir'=>'1970-05-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010047'),
        array('nama_pasien'=>'Eriko Ghani', 'tanggal_lahir'=>'1970-05-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010048'),
        array('nama_pasien'=>'Elina Sitanggang', 'tanggal_lahir'=>'1970-05-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010049'),
        array('nama_pasien'=>'Enjin Honda', 'tanggal_lahir'=>'1970-05-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010050'),

        array('nama_pasien'=>'Firman Irwan', 'tanggal_lahir'=>'1970-06-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010051'),
        array('nama_pasien'=>'Firza Hussein', 'tanggal_lahir'=>'1970-06-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010052'),
        array('nama_pasien'=>'Fariz Pratama', 'tanggal_lahir'=>'1970-06-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010053'),
        array('nama_pasien'=>'Fariha Ahmad', 'tanggal_lahir'=>'1970-06-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010054'),
        array('nama_pasien'=>'Fata Lukman', 'tanggal_lahir'=>'1970-06-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010055'),
        array('nama_pasien'=>'Farhan Kamal', 'tanggal_lahir'=>'1970-06-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010056'),
        array('nama_pasien'=>'Fanya Ristiani', 'tanggal_lahir'=>'1970-06-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010057'),
        array('nama_pasien'=>'Fino Bastian', 'tanggal_lahir'=>'1970-06-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010058'),
        array('nama_pasien'=>'Fitra Trini', 'tanggal_lahir'=>'1970-06-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010059'),
        array('nama_pasien'=>'Fiqie Astahta', 'tanggal_lahir'=>'1970-06-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010060'),

        array('nama_pasien'=>'Gunawan Laksana', 'tanggal_lahir'=>'1970-07-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010061'),
        array('nama_pasien'=>'Gina Surya', 'tanggal_lahir'=>'1970-07-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010062'),
        array('nama_pasien'=>'Ginanjar Pasaribu', 'tanggal_lahir'=>'1970-07-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010063'),
        array('nama_pasien'=>'Gita Kutawa', 'tanggal_lahir'=>'1970-07-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010064'),
        array('nama_pasien'=>'Ghani Sukhman', 'tanggal_lahir'=>'1970-07-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010065'),
        array('nama_pasien'=>'Gedhe Bagus', 'tanggal_lahir'=>'1970-07-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010066'),
        array('nama_pasien'=>'Gemina Dwi', 'tanggal_lahir'=>'1970-07-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010067'),
        array('nama_pasien'=>'Ghazwan Mahmud', 'tanggal_lahir'=>'1970-07-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010068'),
        array('nama_pasien'=>'Gisella Sintia', 'tanggal_lahir'=>'1970-07-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010069'),
        array('nama_pasien'=>'Gerry Anto', 'tanggal_lahir'=>'1970-07-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010070'),

        array('nama_pasien'=>'Harry Manoe', 'tanggal_lahir'=>'1970-08-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010071'),
        array('nama_pasien'=>'Herlina Sindara', 'tanggal_lahir'=>'1970-08-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010072'),
        array('nama_pasien'=>'Hartono Budi', 'tanggal_lahir'=>'1970-08-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010073'),
        array('nama_pasien'=>'Harima Malina', 'tanggal_lahir'=>'1970-08-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010074'),
        array('nama_pasien'=>'Heri Ujang', 'tanggal_lahir'=>'1970-08-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010075'),
        array('nama_pasien'=>'Hotman Faris', 'tanggal_lahir'=>'1970-08-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010076'),
        array('nama_pasien'=>'Harsinah Kirana', 'tanggal_lahir'=>'1970-08-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010077'),
        array('nama_pasien'=>'Hasan Bolkiah', 'tanggal_lahir'=>'1970-08-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010078'),
        array('nama_pasien'=>'Hilda Pardamean', 'tanggal_lahir'=>'1970-08-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010079'),
        array('nama_pasien'=>'Hilmi Ramadhan', 'tanggal_lahir'=>'1970-08-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010080'),

        array('nama_pasien'=>'Jhon Seno', 'tanggal_lahir'=>'1970-09-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010081'),
        array('nama_pasien'=>'Jessica Nurul', 'tanggal_lahir'=>'1970-09-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010082'),
        array('nama_pasien'=>'Junaidi Aidin', 'tanggal_lahir'=>'1970-09-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010083'),
        array('nama_pasien'=>'Jayanti Rizka', 'tanggal_lahir'=>'1970-09-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010084'),
        array('nama_pasien'=>'Janto Erianto', 'tanggal_lahir'=>'1970-09-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010085'),
        array('nama_pasien'=>'Jajat Sudrajat', 'tanggal_lahir'=>'1970-09-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010086'),
        array('nama_pasien'=>'Jasmin Al-Addin', 'tanggal_lahir'=>'1970-09-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010087'),
        array('nama_pasien'=>'Joko Umar', 'tanggal_lahir'=>'1970-09-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010088'),
        array('nama_pasien'=>'Jenny Sutojo', 'tanggal_lahir'=>'1970-09-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010089'),
        array('nama_pasien'=>'Jamil Ipul', 'tanggal_lahir'=>'1970-09-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010090'),

        array('nama_pasien'=>'Kido Markis', 'tanggal_lahir'=>'1970-10-01', 'jender'=>1, 'alamat'=>'Jln. A', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010091'),
        array('nama_pasien'=>'Kartini', 'tanggal_lahir'=>'1970-10-02', 'jender'=>2, 'alamat'=>'Jln. B', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010092'),
        array('nama_pasien'=>'Kemal Mustafa', 'tanggal_lahir'=>'1970-10-03', 'jender'=>1, 'alamat'=>'Jln. C', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010093'),
        array('nama_pasien'=>'Kartika Piranti', 'tanggal_lahir'=>'1970-10-04', 'jender'=>2, 'alamat'=>'Jln. D', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010094'),
        array('nama_pasien'=>'Kadir Polim', 'tanggal_lahir'=>'1970-10-05', 'jender'=>1, 'alamat'=>'Jln. E', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010095'),
        array('nama_pasien'=>'Karno Rano', 'tanggal_lahir'=>'1970-10-06', 'jender'=>1, 'alamat'=>'Jln. F', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010096'),
        array('nama_pasien'=>'Kezia UlHaq', 'tanggal_lahir'=>'1970-10-07', 'jender'=>2, 'alamat'=>'Jln. G', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'B+', 'kode_pasien'=>'201001010097'),
        array('nama_pasien'=>'Kurniawan Hakim', 'tanggal_lahir'=>'1970-10-08', 'jender'=>1, 'alamat'=>'Jln. H', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010098'),
        array('nama_pasien'=>'Karnika Giardhani', 'tanggal_lahir'=>'1970-10-09', 'jender'=>2, 'alamat'=>'Jln. I', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'A+', 'kode_pasien'=>'201001010099'),
        array('nama_pasien'=>'Kresna Aditya', 'tanggal_lahir'=>'1970-10-10', 'jender'=>1, 'alamat'=>'Jln. J', 'agama'=>'Islam', 'kontak'=>'013518580151', 'gol_darah'=>'O+', 'kode_pasien'=>'201001010100'),
      ));
    }
}
