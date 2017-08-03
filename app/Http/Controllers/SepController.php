<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;

class SepController extends Controller
{
    public function insertSEP(Request $request, $no_rujukan) {
    	$type = $request->input('fk');
    	if ($type == '2') {
    		$rujukan = $this->getRujukanFK2($no_rujukan);
    	}
    	else {
    		$rujukan = $this->getRujukanFK1($no_rujukan);
    	}

    	$code = '200';
    	$message = 'OK';

    	if ($rujukan['metadata']['code'] == '200') {
    		$data_rujukan = $rujukan['response']['item'];
	    	$no_kartu = $data_rujukan['peserta']['noKartu'];
	    	$tgl_sep = date("Y-m-d H:i:s");
	    	$time = strtotime($data_rujukan['tglKunjungan']);
	    	$tgl_rujukan = date("Y-m-d H:i:s", $time);
	    	$ppk_rujukan = $data_rujukan['provKunjungan']['kdProvider'];
	    	$ppk_pelayanan = $data_rujukan['provRujukan']['kdProvider'];
	    	$jns_pelayanan = '2';
	    	$catatan = 'mockup';
	    	$diag_awal = $data_rujukan['diagnosa']['kdDiag'];
	    	$poli_tujuan = $data_rujukan['poliRujukan']['kdPoli'];
	    	$kls_rawat = $data_rujukan['peserta']['kelasTanggungan']['kdKelas'];
	    	$laka_lantas = '2';
	    	$lokasi_laka = 'Jakarta';
	    	$user = 'RS';
	    	$noMr = '1234';

	    	$request = array(
	            'noKartu' => $no_kartu,
	            'tglSep' => $tgl_sep,
				'tglRujukan' => $tgl_rujukan,
				'noRujukan' => $no_rujukan,
				'ppkRujukan' => $ppk_rujukan,
				'ppkPelayanan' => $ppk_pelayanan,
				'jnsPelayanan' => $jns_pelayanan,
				'catatan' => $catatan,
				'diagAwal' => $diag_awal,
				'poliTujuan' => $poli_tujuan,
				'klsRawat' => $kls_rawat,
				'lakaLantas' => $laka_lantas,
				'lokasiLaka' => $lokasi_laka,
				'user' => $user,
				'noMr' => $noMr
	        );

	        $t_sep = array(
	            't_sep' => $request
	        );

	        $payload = array(
	            'request' => $t_sep
	        );
    	}
    	else {
    		$code = '404';
    		$message = 'Rujukan Tidak Ditemukan';
    	}

        $no_sep = 'R';
        $rand1 = rand(1, 9999);
        $rand1 = str_pad($rand1, 4, '0', STR_PAD_LEFT);

        $rand2 = rand(1, 9999);
        $rand2 = str_pad($rand2, 4, '0', STR_PAD_LEFT);
        
        $rand3 = rand(1, 9999);
        $rand3 = str_pad($rand3, 4, '0', STR_PAD_LEFT);
        
        $rand4 = rand(1, 9999);
        $rand4 = str_pad($rand4, 4, '0', STR_PAD_LEFT);

        $rand5 = rand(1, 99);
        $rand5 = str_pad($rand5, 2, '0', STR_PAD_LEFT);
        
        $no_sep = $rand1.$no_sep.$rand2.$rand3.$rand4.$rand5;
        
        $mockup = array(
        	'metadata' => array(
        		'code' => $code,
        		'message' => $message
        	),
        );

        if ($code == '200') {
        	$mockup['response'] = $no_sep;
        	$mockup['data_rujukan'] = $rujukan;
        }
        $mock_status = env('SEP_MOCK_STATUS', '1');
        
        if ($mock_status == '1') {
        	return response($mockup, 200);
        }
        else {
        	$ext = env('SEP_WS_INSERT_SEP', 'SEP/insert');
        	return $this->sendToBPJS('post', $ext, $payload);
        }
    }

    public function getRujukan(Request $request, $no_rujukan) {
    	$tipe = $request->input('fk');
    	if (isset($status)) {
    		if ($tipe == 2) {
    			return response($this->getRujukanFK2($no_rujukan), 200);
    		}
    	}

    	return response($this->getRujukanFK1($no_rujukan), 200);
    }

    private function getRujukanFK1($no_rujukan) {
    	$metadata = array(
            'code' => '200',
            'message' => 'OK'
        );

        $item = array(
        	'catatan' => 'Pasien dalam kondisi sehat.',
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
        	return $mockup;
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
        	return $mockup;
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
