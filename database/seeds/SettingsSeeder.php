<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_bpjs')->insert([
        	'tarif_rs' => 10000000,
        	'kd_tarif_rs' => 'AP',
        	'coder_nik' => '123123123123',
        	'add_payment_pct' => 15
        ]);
    }
}
