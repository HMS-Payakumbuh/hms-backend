<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\BpjsManager;

class BpjsController extends Controller
{
    public function process(Request $request) {
        $data = array(
            'no_sep' => '0301R00112140006067'
    );

        $bpjs = new BpjsManager('0301R00112140006067', '123123123123');
        $string = json_decode($bpjs->getClaimData($data)->getBody(), true);
    	return $string['response']['data']['procedure'];
    }
}
