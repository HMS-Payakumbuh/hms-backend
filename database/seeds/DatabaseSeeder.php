<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LokasiObatSeeder::class);
        $this->call(JenisObatSeeder::class);
        $this->call(DaftarTindakanTableSeeder::class);
        $this->call(DaftarDiagnosisTableSeeder::class);
        $this->call(TenagaMedisTableSeeder::class);
        $this->call(DokterTableSeeder::class);
        $this->call(PoliklinikTableSeeder::class);
        $this->call(LaboratoriumTableSeeder::class);
        $this->call(AmbulansTableSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(KamarRawatInapSeeder::class);
        $this->call(KamarOperasiSeeder::class);
        $this->call(KamarJenazahSeeder::class);
        $this->call(TempatTidurSeeder::class);
    }
}
