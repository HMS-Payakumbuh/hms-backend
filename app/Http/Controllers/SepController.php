<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class SepController extends Controller
{
    public function insertSEP() {
    	$request = array(
            'noKartu' => '0000033420148',
            'tglSep' => '2017-08-3 15:09:09',
			'tglRujukan' => '2017-08-2 09:00:00',
			'noRujukan' => '12345',
			'ppkRujukan' => '0301R001',
			'ppkPelayanan' => '0301R001',
			'jnsPelayanan' => '2',
			'catatan' => 'test',
			'diagAwal' => 'A00.0',
			'poliTujuan' => 'UGD',
			'klsRawat' => '3',
			'lakaLantas' => '2',
			'lokasiLaka' => 'Jakarta',
			'user' => 'bpjs',
			'noMr' => '1234'
        );

        $t_sep = array(
            't_sep' => $request
        );

        $payload = array(
            'request' => $t_sep
        );

        $ext = env('SEP_WS_INSERT_SEP', 'SEP/insert');
        return $this->sendToBPJS('post', $ext, $payload);
    }

    public function getRujukan(Request $request, $no_rujukan) {
    	$tipe = $request->input('fk');
    	if (isset($status)) {
    		if ($tipe == 2) {
    			return $this->getRujukanFK2($no_rujukan);
    		}
    	}

    	return $this->getRujukanFK1($no_rujukan);
    }

    private function getRujukanFK1($no_rujukan) {
    	$metadata = array(
            'code' => '200',
            'message' => 'OK'
        );

        $item = array(
        	'catatan' => '',
        	'diagnosa' => array(
	        	'kdDiag' => 'B54',
	        	'nmDiag' => 'Unspecified malaria'
	        ),
        	'keluhan' => '',
        	'noKunjungan' => '030104021115Y000002',
        	'pemFisikLain' => '',
        	'peserta' => array(
        		'informasi' => array(
		        	'dinsos' => null,
		        	'iuran' => null,
		        	'noSKTM' => null,
		        	'prolanisPRB' => null,
		        ),
        		'jenisPeserta' => array(
		        	'kdJenisPeserta' => '1',
		        	'nmJenisPeserta' => 'PNS Daerah'
		        ),
		        'kelasTanggungan' => array(
		        	'kdKelas' => '3',
		        	'nmKelas' => 'Kelas III'
		        ),
		        'nama' => 'SITI AMINAH',
		        'nik' => null,
		        'noKartu' => '0000099799751',
		        'noMr' => null,
		        'pisa' => '1',
		        'provUmum' => array(
		        	'kdCabang' => null,
		        	'kdProvider' => '03010402',
		        	'nmCabang' => null,
		        	'nmProvider' => 'PEGAMBIRAN'
		        ),
		        'sex' => 'P',
		        'statusPeserta' => array(
		        	'keterangan' => 'AKTIF',
		        	'kode' => '0'
		        ),
		        'tglCetakKartu' => null,
		        'tglLahir' => '1965-01-11',
		        'tglTAT' => '2065-01-11',
		        'tglTMT' => '1994-06-01',
		        'umur' => null
        	),
			'poliRujukan' => array(
				'kdPoli' => 'INT',
				'nmPoli' => 'Poli Penyakit Dalam'
			),
			'provKunjungan' => array(
				'kdCabang' => null,
	        	'kdProvider' => '03010402',
	        	'nmCabang' => null,
	        	'nmProvider' => 'PEGAMBIRAN'
			),
			'provRujukan' => array(
				'kdCabang' => null,
	        	'kdProvider' => '0301R001',
	        	'nmCabang' => null,
	        	'nmProvider' => 'RSUP DR M JAMIL PADANG'
			),
			'tglKunjungan' => '2015-11-02',
			'tktPelayanan' => array(
				'nmPelayanan' => 'Rawat Jalan',
				'tktPelayanan' => '10'
			)
        );

        $mockup = array(
        	'metadata' => $metadata,
        	'response' => array(
        		'item' => $item
        	)
        );

        $mock_status = env('SEP_MOCK_STATUS', '1');
        
        if ($mock_status == '1') {
        	return response($mockup, 200);
        }
        else {
	    	$ext = env('SEP_WS_RUJUKAN_FK1', 'Rujukan');
	    	return $this->sendToBPJS('get', $ext, $no_rujukan);
        }
    }

    private function getRujukanFK2($no_rujukan) {
    	$metadata = array(
            'code' => '200',
            'message' => 'OK'
        );

        $item = array(
        	'catatan' => '',
        	'diagnosa' => array(
	        	'kdDiag' => 'B54',
	        	'nmDiag' => 'Unspecified malaria'
	        ),
        	'keluhan' => '',
        	'noKunjungan' => '0312R0010715A000058',
        	'pemFisikLain' => '',
        	'peserta' => array(
        		'jenisPeserta' => array(
		        	'kdJenisPeserta' => '1',
		        	'nmJenisPeserta' => 'PNS Daerah'
		        ),
		        'kelasTanggungan' => array(
		        	'kdKelas' => '3',
		        	'nmKelas' => 'Kelas III'
		        ),
		        'nama' => 'RIMBAR YUNUS, IR',
		        'nik' => null,
		        'noKartu' => '0000033420148',
		        'noMr' => null,
		        'pisa' => '1',
		        'provUmum' => array(
		        	'kdCabang' => null,
		        	'kdProvider' => '03010402',
		        	'nmCabang' => null,
		        	'nmProvider' => 'PEGAMBIRAN'
		        ),
		        'sex' => 'L',
		        'statusPeserta' => array(
		        	'keterangan' => 'AKTIF',
		        	'kode' => '0'
		        ),
		        'tglCetakKartu' => null,
		        'tglLahir' => '1965-01-11',
		        'tglTAT' => '2065-01-11',
		        'tglTMT' => '1994-06-01',
		        'umur' => null
        	),
			'poliRujukan' => array(
				'kdPoli' => 'MAT',
				'nmPoli' => 'Poli Mata'
			),
			'provKunjungan' => array(
				'kdCabang' => null,
	        	'kdProvider' => '03010402',
	        	'nmCabang' => null,
	        	'nmProvider' => 'PEGAMBIRAN'
			),
			'provRujukan' => array(
				'kdCabang' => null,
	        	'kdProvider' => '0301R001',
	        	'nmCabang' => null,
	        	'nmProvider' => 'RSUP DR M JAMIL PADANG'
			),
			'tglKunjungan' => '2015-07-14',
        );

        $mockup = array(
        	'metadata' => $metadata,
        	'response' => array(
        		'item' => $item
        	)
        );

        $mock_status = env('SEP_MOCK_STATUS', '1');
        
        if ($mock_status == '1') {
        	return response($mockup, 200);
        }
        else {
	    	$ext = env('SEP_WS_RUJUKAN_FK2', 'Rujukan/RS');
	    	return $this->sendToBPJS('get', $ext, $no_rujukan);
        }
    }

    public function getPeserta($no_kartu) {
    	$ext = env('SEP_WS_PESERTA', 'Peserta/Peserta');
    	return $this->sendToBPJS('get', $ext, $no_kartu);
    }

    private function sendToBPJS($method, $ext, $payload = null) {
    	$data = env('SEP_CONS_ID', '1000');
		$secretKey = env('SEP_SECRET', '7789'); //7789 1000 1112
		// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);

		// base64 encode…
		$encodedSignature = base64_encode($signature);

		// urlencode…
		// $encodedSignature = urlencode($encodedSignature);

		$host = env('SEP_WS_URL', 'http://dvlp.bpjs-kesehatan.go.id:8081/devWSLokalRest/');
		$client = new Client(['base_uri' => (string)$host]);
		if ($method == 'get') {
			$response = $client->request($method, $ext.'/'.$payload, [
				'headers' => [
					'X-Cons-ID' => $data,
					'X-Timestamp' => $tStamp,
					'X-Signature' => $encodedSignature
				]
			]);
		}
		else {
			$response = $client->request($method, $ext, [
				'headers' => [
					'X-Cons-ID' => $data,
					'X-Timestamp' => $tStamp,
					'X-Signature' => $encodedSignature,
					'Content-Type' => 'Application/x-www-form-urlencoded'
				],
				'json' => $payload
			]);
		}

		return $response->getBody();
    }
}
