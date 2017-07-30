<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BpjsManager;

class BpjsController extends Controller
{
    public function process(Request $request) {
    	return $this->sendToBPJS();
    }

    private function sendToBPJS() {
    	$data = "1000";
		$secretKey = "1112"; //7789 1000 1112
		// Computes the timestamp
		date_default_timezone_set('UTC');
		$tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);

		// base64 encode…
		$encodedSignature = base64_encode($signature);

		
		$request = array(
            'noKartu' => '0000033420148',
            'tglSep' => '2017-07-27 15:09:09',
			'tglRujukan' => '2017-07-23 09:00:00',
			'noRujukan' => '12345',
			'ppkRujukan' => '03010402',
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

		// urlencode…
		// $encodedSignature = urlencode($encodedSignature);
		$client = new Client();
		$response = $client->request('GET', 'http://api.asterix.co.id/SepWebRest/peserta/0000110507578', [
			'headers' => [
				'X-cons-id' => $data,
				'X-timestamp' => $tStamp,
				'X-signature' => $encodedSignature
			]
		]);
		return $response->getBody();
    }
}
