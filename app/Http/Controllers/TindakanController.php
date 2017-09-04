<?php

namespace App\Http\Controllers;

use App\Tindakan;
use App\DaftarTindakan;
use App\Transaksi;
use App\SettingBpjs;
use App\BpjsManager;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Tindakan::with('daftarTindakan', 'hasilLab')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $currentTindakan = '';
      $i = 0;
      $response = [];
      foreach ($request->all() as $key => $value) {
        $tindakan = new Tindakan;
        $tindakan->id_transaksi = $value['id_transaksi'];
        $tindakan->harga = $value['harga'];
        $tindakan->keterangan = $value['keterangan'];
        $tindakan->id_pembayaran = $value['id_pembayaran'];
        $tindakan->kode_tindakan = $value['kode_tindakan'];
        $tindakan->id_pasien = $value['id_pasien'];
        $tindakan->tanggal_waktu = $value['tanggal_waktu'];
        $tindakan->np_tenaga_medis = $value['np_tenaga_medis'];
        $tindakan->nama_poli = $value['nama_poli'];
        $tindakan->nama_lab = $value['nama_lab'];
        $tindakan->nama_ambulans = $value['nama_ambulans'];

        $response[$i] = $tindakan;
        $i++;

        if ($tindakan->save()) {
          $currentTindakan = $currentTindakan. "#". $tindakan->kode_tindakan;
          $transaksi = Transaksi::findOrFail($tindakan->id_transaksi);
          $transaksi->harga_total += $tindakan->harga;
          $transaksi->save();
        }
      }

      $transaksi = Transaksi::findOrFail($tindakan->id_transaksi);
      if ($transaksi->no_sep != null) {
        $settingBpjs = SettingBpjs::first();
        $coder_nik = $settingBpjs->coder_nik;
        $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
        $currentData = json_decode($bpjs->getClaimData()->getBody(), true);
        $currentTindakan = $currentData['response']['data']['procedure']. $currentTindakan;

        $requestSet = array(
          'procedure' => $currentTindakan
        );
        $bpjs->setClaimData($requestSet);
      }

      return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_pasien
     * @param  string $tanggal_waktu
     * @return \Illuminate\Http\Response
     */
    public function getTindakanOfRekamMedis($id_pasien, $tanggal_waktu)
    {
      return Tindakan::with('daftarTindakan', 'tenagaMedis', 'hasilLab')
                      ->where('id_pasien', '=', $id_pasien)
                      ->where('tanggal_waktu', '=', $tanggal_waktu)
                      ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  string $nama_lab
     * @return \Illuminate\Http\Response
     */
    public function getTindakanWithoutHasilLab ($nama_lab)
    {
      return Tindakan::doesntHave('hasilLab')
        ->with('daftarTindakan', 'transaksi', 'pasien')
        ->where('nama_lab', '=', $nama_lab)
        ->get();
    }

        /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function getTindakanWithoutAmbulans ()
     {
       return Tindakan::with('daftarTindakan', 'transaksi', 'pasien')
         ->where('nama_ambulans', '=', 'Ambulans belum dipilih')
         ->get();
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_transaksi
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_transaksi, $id = null)
    {
      if ($id != null) {
        return Tindakan::with('daftarTindakan', 'hasilLab')->findOrFail($id);
      }
      else {
        return $response = Tindakan::with('daftarTindakan', 'hasilLab')->where('id_transaksi', '=', $id_transaksi)->get();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_transaksi
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $tindakan = Tindakan::findOrFail($id);
      $tindakan->id_transaksi = $request->input('id_transaksi');
      $tindakan->harga = $request->input('harga');
      $tindakan->keterangan = $request->input('keterangan');
      $tindakan->id_pembayaran = $request->input('id_pembayaran');
      $tindakan->kode_tindakan = $request->input('kode_tindakan');
      $tindakan->id_pasien = $request->input('id_pasien');
      $tindakan->tanggal_waktu = $request->input('tanggal_waktu');
      $tindakan->np_tenaga_medis = $request->input('np_tenaga_medis');
      $tindakan->nama_poli = $request->input('nama_poli');
      $tindakan->nama_lab = $request->input('nama_lab');
      $tindakan->nama_ambulans = $request->input('nama_ambulans');
      $tindakan->save();
      return response($tindakan, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_transaksi
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_transaksi, $id = null)
    {
      if($id != null) {
        $deletedRows = Tindakan::where('id_transaksi', '=', $id_transaksi)
          ->where('id', '=', $id)
          ->first()
          ->delete();
      }
      else {
        $deletedRows = Tindakan::where('id_transaksi', '=', $id_transaksi)
          ->get()
          ->delete();
      }
      return response('', 204);
    }
}
