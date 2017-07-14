<?php

namespace App\Http\Controllers;

use App\Tindakan;
use App\Transaksi;
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
      $i = 0;
      $response = '{}';
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
          $transaksi = Transaksi::findOrFail($value['id_transaksi']);
          $transaksi->harga_total += $value['harga'];
          $transaksi->save();
        }
      }
      return response($response, 201);
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
    public function update(Request $request, $id_transaksi, $id)
    {
      $tindakan = Tindakan::where('id_transaksi', '=', $id_transaksi)
        ->where('id', '=', $id)
        ->first();
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
