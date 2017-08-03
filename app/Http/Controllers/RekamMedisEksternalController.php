<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RekamMedisEksternal;
use GuzzleHttp\Client;
use Carbon\Carbon;

class RekamMedisEksternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RekamMedisEksternal::all();
    }

    public function getEksternalRekamMedis($kode_pasien) {
        $client = new Client();
        $response = $client->request('GET', 'http://127.0.0.1:8001/api/rekam_medis/'.$kode_pasien)->getBody();
        return response($response)->header('Content-Type', 'application/json');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rekam_medis_exist = RekamMedisEksternal::where('id_pasien', '=', $request->input('id_pasien'))
                                                ->where('kode_pasien', '=', $request->input('kode_pasien'))
                                                ->first();
        if ($rekam_medis_exist) {
            $rekam_medis_exist->tanggal_waktu = Carbon::now();
            $rekam_medis_exist->identitas_pasien = $request->input('identitas_pasien');
            $rekam_medis_exist->identitas_dokter = $request->input('identitas_dokter');
            $rekam_medis_exist->komponen = $request->input('komponen');
            $rekam_medis_exist->save();
            return response($rekam_medis_exist, 201);
        } else {
            $rekam_medis = new RekamMedisEksternal;
            $rekam_medis->id_pasien = $request->input('id_pasien');
            $rekam_medis->kode_pasien = $request->input('kode_pasien');
            $rekam_medis->tanggal_waktu = Carbon::now();
            $rekam_medis->identitas_pasien = $request->input('identitas_pasien');
            $rekam_medis->identitas_dokter = $request->input('identitas_dokter');
            $rekam_medis->komponen = $request->input('komponen');
            $rekam_medis->save();
            return response($rekam_medis, 201);
        }                                       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_pasien
     * @return \Illuminate\Http\Response
     */
    public function show($id_pasien)
    {
        $rekam_medis = RekamMedisEksternal
                            ::with('pasien')
                            ->orderBy('tanggal_waktu', 'desc')
                            ->where('id_pasien', '=', $id_pasien)
                            ->get();
        return $rekam_medis;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_pasien
     * @param  string  $tanggal_waktu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pasien, $tanggal_waktu)
    {
        /*$rekam_medis = RekamMedisEksternal::where('id_pasien', '=', $id_pasien)
                                ->where('tanggal_waktu', '=', $tanggal_waktu)
                                ->first();
        $rekam_medis->id_pasien = $request->input('id_pasien');
        $rekam_medis->np_dokter = $request->input('np_dokter');
        $rekam_medis->hasil_pemeriksaan = $request->input('hasil_pemeriksaan');
        $rekam_medis->anamnesis = $request->input('anamnesis');
        $rekam_medis->rencana_penatalaksanaan = $request->input('rencana_penatalaksanaan');
        $rekam_medis->pelayanan_lain = $request->input('pelayanan_lain');
        $rekam_medis->perkembangan_pasien = $request->input('perkembangan_pasien');
        $rekam_medis->save();
        return response($rekam_medis, 200);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RekamMedis::destroy($id);
        return response('', 204);
    }
}
