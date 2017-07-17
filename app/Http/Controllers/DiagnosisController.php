<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use App\Transaksi;
use App\SettingBpjs;
use App\BpjsManager;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Diagnosis::with('daftarDiagnosis')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $currentDiagnosis = '';
      foreach ($request->all() as $key => $value) {
        $diagnosis = new Diagnosis;
        $diagnosis->id_pasien = $value['id_pasien'];
        $diagnosis->tanggal_waktu = $value['tanggal_waktu'];
        $diagnosis->kode_diagnosis = $value['kode_diagnosis'];
        $diagnosis->save();
        $currentDiagnosis = $currentDiagnosis. "#". $diagnosis->kode_diagnosis;
      }

      $transaksi = Transaksi::where([
        ['id_pasien', '=', $diagnosis->id_pasien]
      ])
      ->orderBy('transaksi.waktu_masuk_pasien', 'desc')
      ->first();

      $settingBpjs = SettingBpjs::first();
      $coder_nik = $settingBpjs->coder_nik;
      $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
      $currentData = json_decode($bpjs->getClaimData()->getBody(), true);
      $currentDiagnosis = $currentData['response']['data']['diagnosa']. $currentDiagnosis;

      $requestSet = array(
        'diagnosa' => $currentDiagnosis
      );
      // $bpjs->setClaimData($requestSet);

      return response($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Diagnosis::with('daftarDiagnosis')->findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_pasien
     * @param  string $tanggal_waktu
     * @return \Illuminate\Http\Response
     */
    public function getDiagnosisOfRekamMedis($id_pasien, $tanggal_waktu)
    {
      return Diagnosis::with('daftarDiagnosis')
                      ->where('id_pasien', '=', $id_pasien)
                      ->where('tanggal_waktu', '=', $tanggal_waktu)
                      ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $diagnosis = Diagnosis::findOrFail($id);
      $diagnosis->id_pasien = $value['id_pasien'];
      $diagnosis->tanggal_waktu = $value['tanggal_waktu'];
      $diagnosis->kode_diagnosis = $value['kode_diagnosis'];
      $diagnosis->save();
      return response($diagnosis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Diagnosis::destroy($id);
      return response('', 204);
    }
}
