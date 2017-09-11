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
          array('merek_obat'=>'Panadol', 'nama_generik'=>'Paracetamol 500mg', 'pembuat'=>'GSK', 'golongan'=>'Analgesik', 'satuan'=>'blister', 'harga_jual_satuan'=>9500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Panadol Extra', 'nama_generik'=>'Paracetamol 500mg, Caffeine 10mg', 'pembuat'=>'GSK', 'golongan'=>'Analgesik', 'satuan'=>'blister', 'harga_jual_satuan'=>12000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Actifed', 'nama_generik'=>'Tripod HXL 1.25 mg/60 ml', 'pembuat'=>'GSK', 'golongan'=>'Dekongestan', 'satuan'=>'botol', 'harga_jual_satuan'=>50000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Lidocaine HCL', 'nama_generik'=>'Lidocaine 1 % inj', 'pembuat'=>'Generik', 'golongan'=>'Anestesi', 'satuan'=>'ampul', 'harga_jual_satuan'=>1700.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Lidocaine Comp', 'nama_generik'=>'Lidocaine 2 % inj', 'pembuat'=>'Generik', 'golongan'=>'Anestesi', 'satuan'=>'ampul', 'harga_jual_satuan'=>2200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Pehacaine', 'nama_generik'=>'Lidocaine 2 % inj', 'pembuat'=>'Phapros', 'golongan'=>'Anestesi', 'satuan'=>'ampul', 'harga_jual_satuan'=>2200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Acetosal', 'nama_generik'=>'Asam Asetilsalisilat 100 mg', 'pembuat'=>'Generik', 'golongan'=>'Analgesik', 'satuan'=>'tablet', 'harga_jual_satuan'=>1000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Rhonal', 'nama_generik'=>'Asam Asetilsalisilat 500 mg', 'pembuat'=>'RP', 'golongan'=>'Analgesik', 'satuan'=>'tablet', 'harga_jual_satuan'=>3000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Farmasal', 'nama_generik'=>'Asam Asetilsalisilat 80 mg', 'pembuat'=>'Fahrenheit', 'golongan'=>'Analgesik', 'satuan'=>'tablet', 'harga_jual_satuan'=>500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Aspilet', 'nama_generik'=>'Asam Asetilsalisilat 80 mg', 'pembuat'=>'Med', 'golongan'=>'Analgesik', 'satuan'=>'tablet', 'harga_jual_satuan'=>550.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Ampicillin', 'nama_generik'=>'Ampicillina 250 mg', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>7600.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Ampicil ', 'nama_generik'=>'Ampicillina 500 mg', 'pembuat'=>'Kalbe', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>8400.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Amcillin', 'nama_generik'=>'Ampicillina 125 mg/5 ml', 'pembuat'=>'Dum ', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>6400.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Standacillin', 'nama_generik'=>'Ampicillina 125 mg/5 ml', 'pembuat'=>'Kalbe', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>6500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Kalpicillin', 'nama_generik'=>'Ampicillina 1 gr', 'pembuat'=>'Kalbe', 'golongan'=>'Antibiotik', 'satuan'=>'ampul', 'harga_jual_satuan'=>10200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Ampicillina 2 gr', 'nama_generik'=>'Ampicillina 2 gr', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'ampul', 'harga_jual_satuan'=>13000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Amoxicillin', 'nama_generik'=>'Amoksisilina 250 mg', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>800.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Kimoxil', 'nama_generik'=>'Amoksisilina 500 mg', 'pembuat'=>'Kalbe', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>2000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Amoksisilina 125 mg/5 ml', 'nama_generik'=>'Amoksisilina 125 mg/5 ml', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'sirup', 'harga_jual_satuan'=>700.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Improvox', 'nama_generik'=>'Amoksilia trihidrat 500 mg', 'pembuat'=>'Scan', 'golongan'=>'Antibiotik', 'satuan'=>'kaplet', 'harga_jual_satuan'=>8500.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Amoksilia trihidrat 250 mg', 'nama_generik'=>'Amoksilia trihidrat 250 mg', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'kaplet', 'harga_jual_satuan'=>6000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Kalium Klavulanat 125 mg', 'nama_generik'=>'Kalium Klavulanat 125 mg', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'kaplet', 'harga_jual_satuan'=>1500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Dalacin C', 'nama_generik'=>'Klindamicin', 'pembuat'=>'UPJ', 'golongan'=>'Antibiotik', 'satuan'=>'tablet', 'harga_jual_satuan'=>1300.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Cindala', 'nama_generik'=>'Klindamicin', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'tablet', 'harga_jual_satuan'=>1000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Rovamicin', 'nama_generik'=>'Spiramicin 250 mg', 'pembuat'=>'RP', 'golongan'=>'Antibiotik', 'satuan'=>'tablet', 'harga_jual_satuan'=>2700.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Hypermicine', 'nama_generik'=>'Spiramicin 500 mg', 'pembuat'=>'Prafa', 'golongan'=>'Antibiotik', 'satuan'=>'tablet', 'harga_jual_satuan'=>5400.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Spirabiotik', 'nama_generik'=>'Spiramicin', 'pembuat'=>'Kalbe', 'golongan'=>'Antibiotik', 'satuan'=>'sirup', 'harga_jual_satuan'=>16200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Penadur LA', 'nama_generik'=>'Benzatina Benzilpenicillina', 'pembuat'=>'Wyeth', 'golongan'=>'Antibiotik', 'satuan'=>'ampul', 'harga_jual_satuan'=>39800.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Penicillin V', 'nama_generik'=>'Fenoksimetil Penisilin (V) 250 mg', 'pembuat'=>'Generik', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Ospen', 'nama_generik'=>'Fenoksimetil Penisilin (V) 500 mg', 'pembuat'=>'Biofarma', 'golongan'=>'Antibiotik', 'satuan'=>'kapsul', 'harga_jual_satuan'=>3400.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Melix', 'nama_generik'=>'Asam Mefenamat cap. 250 mg', 'pembuat'=>'MF', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>450.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Mectan', 'nama_generik'=>'Asam Mefenamat cap. 500 mg', 'pembuat'=>'Pra', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>670.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Ponstan', 'nama_generik'=>'Asam Mefenamat cap. 500 mg', 'pembuat'=>'PD', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>700.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Ibuprofen/ibufen', 'nama_generik'=>'Ibuprofen 400 mg', 'pembuat'=>'Generik', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Dofen/F', 'nama_generik'=>'Ibuprofen 400 mg', 'pembuat'=>'Dexa', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Kloteran', 'nama_generik'=>'Diclofenac Sodium tab 25 mg', 'pembuat'=>'Kalbe', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>820.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Voren 25/50 mg', 'nama_generik'=>'Diclofenac Sodium tab 500 mg', 'pembuat'=>'MP', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>4000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Indometasin', 'nama_generik'=>'Indometasina cap. 25 mg', 'pembuat'=>'Generik', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>7800.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Benocid', 'nama_generik'=>'Indometasina cap. 50 mg', 'pembuat'=>'Ber', 'golongan'=>'Antiinflamasi', 'satuan'=>'kapsul', 'harga_jual_satuan'=>8200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Profenid', 'nama_generik'=>'Ketoprofen supositori. 100 mg', 'pembuat'=>'Roi', 'golongan'=>'Antiinflamasi', 'satuan'=>'supositori', 'harga_jual_satuan'=>17000.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Piroxicam', 'nama_generik'=>'Piroxicam 10 mg', 'pembuat'=>'Generik', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>2700.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Indene', 'nama_generik'=>'Ibuprofen 400 mg', 'pembuat'=>'Kalbe', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>580.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Scandene', 'nama_generik'=>'Ibuprofen 400 mg', 'pembuat'=>'Scan', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>440.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Allopurinol', 'nama_generik'=>'Alopurinol 100 mg', 'pembuat'=>'Generik', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>860.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Lianol', 'nama_generik'=>'Alopurinol 30 mg', 'pembuat'=>'UAP', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>780.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Zyloric', 'nama_generik'=>'Alopurinol 30 mg', 'pembuat'=>'Well', 'golongan'=>'Antiinflamasi', 'satuan'=>'tablet', 'harga_jual_satuan'=>710.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'CTM', 'nama_generik'=>'Chaborfargiramin Maleat', 'pembuat'=>'Generik', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>5200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Cohistan', 'nama_generik'=>'Chaborfargiramin Maleat', 'pembuat'=>'Biofarma', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>5800.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Avil/Retard', 'nama_generik'=>'Feniramin Hydrogen Maleat', 'pembuat'=>'Generik', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>8200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Benochis', 'nama_generik'=>'Feniramin Hydrogen Maleat', 'pembuat'=>'Hoe', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>8300.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Incidal', 'nama_generik'=>'Mebhidrolina Napadisilat 50 mg', 'pembuat'=>'Bay', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>8100.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Incitin', 'nama_generik'=>'Mebhidrolina Napadisilat 50 mg', 'pembuat'=>'Ber', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>8200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Histapan', 'nama_generik'=>'Mebhidrolina Napadisilat 50 mg', 'pembuat'=>'Sanbe', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>8200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Prome', 'nama_generik'=>'Prometazin HCL 25 mg', 'pembuat'=>'NI', 'golongan'=>'Antihistamin', 'satuan'=>'tablet', 'harga_jual_satuan'=>1100.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Prometazin HCL 25 mg', 'nama_generik'=>'Prometazin HCL 25 mg', 'pembuat'=>'Generik', 'golongan'=>'Antihistamin', 'satuan'=>'sirup', 'harga_jual_satuan'=>8800.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Diazepam', 'nama_generik'=>'Diazepam 2 mg', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>4100.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Valium', 'nama_generik'=>'Diazepam 5 mg', 'pembuat'=>'Rol', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>8900.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Mentalium', 'nama_generik'=>'Diazepam 5 mg', 'pembuat'=>'SH', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>8200.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Stesolid Rectal', 'nama_generik'=>'Rectal 5 mg/ml ', 'pembuat'=>'Dumex', 'golongan'=>'Antikonvulsi', 'satuan'=>'tube', 'harga_jual_satuan'=>14700.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Rectal 10 mg/2.5ml ', 'nama_generik'=>'Rectal 10 mg/2.5ml ', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tube', 'harga_jual_satuan'=>22600.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Rectal 5 mg/2ml', 'nama_generik'=>'Rectal 5 mg/2ml', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tube', 'harga_jual_satuan'=>7500.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Stesolid  ', 'nama_generik'=>'Rectal 10 mg/2ml', 'pembuat'=>'Dum ', 'golongan'=>'Antikonvulsi', 'satuan'=>'ampul', 'harga_jual_satuan'=>19300.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Valium', 'nama_generik'=>'Rectal 10 mg/2ml', 'pembuat'=>'Rol', 'golongan'=>'Antikonvulsi', 'satuan'=>'ampul', 'harga_jual_satuan'=>24500.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Dilatin Loco', 'nama_generik'=>'Natrium Fenitoin 30 mg', 'pembuat'=>'Aptk', 'golongan'=>'Antikonvulsi', 'satuan'=>'sirup', 'harga_jual_satuan'=>17600.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Dilatin', 'nama_generik'=>'Natrium Fenitoin 100 mg', 'pembuat'=>'PD', 'golongan'=>'Antikonvulsi', 'satuan'=>'sirup', 'harga_jual_satuan'=>35600.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Phenitoin', 'nama_generik'=>'Natrium Fenitoin 100 mg', 'pembuat'=>'IKA', 'golongan'=>'Antikonvulsi', 'satuan'=>'sirup', 'harga_jual_satuan'=>38000.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Phernobarbital 30 mg', 'nama_generik'=>'Phernobarbital 30 mg', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1800.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Phernobarbital 50 mg', 'nama_generik'=>'Phernobarbital 50 mg', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>3400.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Phenobarbital 100 mg', 'nama_generik'=>'Phenobarbital 100 mg', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>6400.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Karbamazepin', 'nama_generik'=>'Karbamazepina 200 mg', 'pembuat'=>'Generik', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1200.00, 'dicover_bpjs'=>true, 'special_medicine'=>false),
          array('merek_obat'=>'Temporol', 'nama_generik'=>'Karbamazepina 200 mg', 'pembuat'=>'Soho', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1600.00, 'dicover_bpjs'=>false, 'special_medicine'=>false),
          array('merek_obat'=>'Tegretol', 'nama_generik'=>'Karbamazepina 200 mg', 'pembuat'=>'CG', 'golongan'=>'Antikonvulsi', 'satuan'=>'tablet', 'harga_jual_satuan'=>1700.00, 'dicover_bpjs'=>false, 'special_medicine'=>false)
       ));
    }
}