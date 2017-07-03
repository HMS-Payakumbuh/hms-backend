<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class BpjsController extends Controller
{
    public function newClaim(Request $request) {
    	$metadata = array(
    		'method' => 'new_claim'
    	);

    	$data = array(
    		'nomor_sep' => '0301R00112140006067',
			'nomor_kartu' => '233333',
			'nomor_rm' => '123-45-67',
			'nama_pasien' => 'satini',
			'tgl_lahir' => '1940-01-01 02:00:00',
			'gender' => '2'
    	);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    public function updatePatient(Request $request) {
    	$metadata = array(
    		'method' => 'update_patient',
    		'nomor_rm' => '123-45-67'
    	);

    	$data = array(
			'nomor_kartu' => '233333',
			'nomor_rm' => '123-45-67',
			'nama_pasien' => 'satini',
			'tgl_lahir' => '1940-01-01 02:00:00',
			'gender' => '2'
    	);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    public function setClaimData(Request $request) {
    	$metadata = array(
    		'method' => 'set_claim_data',
    		'nomor_sep' => '0301R00112140006067'
    	);

   //  	$data = array(
   //  		'nomor_sep' => '0301R00112140006067',
			// 'nomor_kartu' => '233333',
			// 'tgl_masuk' => '2016-10-26 12:55:00',
			// 'tgl_pulang' => '2016-12-18 13:55:00',
			// 'jenis_rawat' => '1',
			// 'kelas_rawat' => '1',
			// 'adl_sub_acute' => '15',
			// 'adl_chronic' => '12',
			// 'icu_indikator' => '1',
			// 'icu_los' => '2',
			// 'ventilator_hour' => '5',
			// 'upgrade_class_ind' => '1',
			// 'upgrade_class_class' => 'vip',
			// 'upgrade_class_los' => '5',
			// 'add_payment_pct' => '35',
			// 'birth_weight' => '0',
			// 'discharge_status' => '1',
			// 'diagnosa' => 'S71.0#A00.1',
			// 'procedure' => '81.52#88.38',
			// 'tarif_rs' => '80000000',
			// 'nama_dokter' => 'RUDY, DR',
			// 'kode_tarif' => 'AP',
			// 'payor_id' => '3',
			// 'payor_cd' => 'JKN',
			// 'cob_cd' => '',
			// 'coder_nik' => '123123123123'
   //  	);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $request->input('data')
		);

		return $this->sendKlaim($payload);
    }

    public function group(Request $request) {
    	$metadata = array(
    		'method' => 'grouper',
    		'stage' => '1'
    	);

    	$data = array(
    		'nomor_sep' => '0301R00112140006067'
    	);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    private function sendKlaim($payload) {
    	$client = new Client();

		$response = $client->request('POST', env('BPJS_EKLAIM_URL'), [
			'json' => $payload
		]);

    	return $response;
    }

    public function process(Request $request) {
    	return $this->getSpecialCMG($request);
    }

    public function getSpecialCMG(Request $request) {
    	$claimData = array(
    		'metadata' => array(
    			'method' => 'set_claim_data',
	    		'nomor_sep' => '0301R00112140006067'
    		),
    		'data' => $request->input('data')
    	);
    	$this->sendKlaim($claimData);

    	$payload = array(
    		'metadata' => array(
				'method' => 'grouper',
    			'stage' => '1'
    		),
    		'data' => array(
    			'nomor_sep' => '0301R00112140006067'
    		)
		);

    	$response = json_decode($this->sendKlaim($payload)->getBody()->getContents(), true);
    	if (isset($response['special_cmg_option'])) {
    		return $response['special_cmg_option'];
    	}
    	return array();
    }
}
