<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BpjsManager;

class BpjsController extends Controller
{
    public function process(Request $request) {
        $data = array(
            'nomor_kartu' => '233333',
            'tgl_masuk' => '2016-10-26 12:55:00',
            'tgl_pulang' => '2016-12-18 13:55:00',
            'jenis_rawat' => '1',
            'kelas_rawat' => '1',
            'adl_sub_acute' => '15',
            'adl_chronic' => '12',
            'icu_indikator' => '1',
            'icu_los' => '2',
            'ventilator_hour' => '5',
            'upgrade_class_ind' => '1',
            'upgrade_class_class' => 'vip',
            'upgrade_class_los' => '5',
            'add_payment_pct' => '35',
            'birth_weight' => '0',
            'discharge_status' => '1',
            'diagnosa' => 'S71.0#A00.1',
            'procedure' => '81.52#88.38',
            'tarif_rs' => '80000000',
            'nama_dokter' => 'RUDY, DR',
            'kode_tarif' => 'AP',
            'payor_id' => '3',
            'payor_cd' => 'JKN',
            'cob_cd' => ''
    );

        $bpjs = new BpjsManager('0301R00112140006067', '123123123123');
    	return $bpjs->setClaimData($data);
    }
}
