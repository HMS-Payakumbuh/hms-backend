<?php

namespace App;

use GuzzleHttp\Client;

class BpjsManager
{
	private $nomor_sep;
	private $coder_nik;

	public function __construct($nomor_sep, $coder_nik) {
		$this->nomor_sep = $nomor_sep;
		$this->coder_nik = $coder_nik;
	}


	// Input:
			//	'nomor_kartu' => '233333',
			//	'nomor_rm' => '123-45-67',
			//	'nama_pasien' => 'satini',
			//	'tgl_lahir' => '1940-01-01 02:00:00',
			//	'gender' => '2'
	public function newClaim($input) {
    	$metadata = array(
    		'method' => 'new_claim'
    	);

    	$data = array(
    		'nomor_sep' => $this->nomor_sep,
    	);

    	$data = array_merge($data, $input);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

   //  	$data = array(
			// 'nomor_kartu' => '233333',
			// 'nomor_rm' => '123-45-67',
			// 'nama_pasien' => 'satini',
			// 'tgl_lahir' => '1940-01-01 02:00:00',
			// 'gender' => '2'
   //  	);
    public function updatePatient($data) {
    	$metadata = array(
    		'method' => 'update_patient',
    		'nomor_rm' => $data['nomor_rm']
    	);


    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    // Input:
	 //	   'nomor_kartu' => '233333',
     //    'tgl_masuk' => '2016-10-26 12:55:00',
     //    'tgl_pulang' => '2016-12-18 13:55:00',
     //    'jenis_rawat' => '1',
     //    'kelas_rawat' => '1',
     //    'adl_sub_acute' => '15',
     //    'adl_chronic' => '12',
     //    'icu_indikator' => '1',
     //    'icu_los' => '2',
     //    'ventilator_hour' => '5',
     //    'upgrade_class_ind' => '1',
     //    'upgrade_class_class' => 'vip',
     //    'upgrade_class_los' => '5',
     //    'add_payment_pct' => '35',
     //    'birth_weight' => '0',
     //    'discharge_status' => '1',
     //    'diagnosa' => 'S71.0#A00.1',
     //    'procedure' => '81.52#88.38',
     //    'tarif_rs' => '80000000',
     //    'nama_dokter' => 'RUDY, DR',
     //    'kode_tarif' => 'AP',
     //    'payor_id' => '3',
     //    'payor_cd' => 'JKN',
     //    'cob_cd' => ''
    public function setClaimData($input) {
    	$metadata = array(
    		'method' => 'set_claim_data',
    		'nomor_sep' => $this->nomor_sep
    	);
    	$data = array(
    		'nomor_sep' => $this->nomor_sep,
    		'coder_nik' => $this->coder_nik
    	);
    	$data = array_merge($data, $input);

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    // $stage = 1 atau 2
    // $specialCMG = rr04#yy05#dst..
    public function group($stage, $specialCMG = null) {
    	$metadata = array(
    		'method' => 'grouper',
    		'stage' => $stage
    	);

    	$data = array(
    		'nomor_sep' => $this->nomor_sep
    	);

    	if ($stage == 2 && isset($specialCMG)) {
    		$data['special_cmg'] = $specialCMG;
    	}

    	$payload = array(
    		'metadata' => $metadata,
    		'data' => $data
		);

		return $this->sendKlaim($payload);
    }

    public function finalizeClaim() {
    	$metadata = array(
    		'method' => 'claim_final'
    	);

    	$data = array(
    		'nomor_sep' => $this->nomor_sep,
    		'coder_nik' => $this->coder_nik
    	);

        $payload = array(
            'metadata' => $metadata,
            'data' => $data
        );

        return $this->sendKlaim($payload);
    }

    public function getClaimData() {
        $metadata = array(
            'method' => 'get_claim_data'
        );

        $data = array(
            'nomor_sep' => $this->nomor_sep
        );

        $payload = array(
            'metadata' => $metadata,
            'data' => $data
        );

        return $this->sendKlaim($payload);
    }

    private function sendKlaim($payload) {
    	/*$client = new Client();

		$response = $client->request('POST', env('BPJS_EKLAIM_URL'), [
			'json' => $payload
		]);
        sleep(1);

    	return $response;*/
    }
}