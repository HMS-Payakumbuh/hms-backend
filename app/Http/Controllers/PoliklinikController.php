<?php

namespace App\Http\Controllers;

use App\Poliklinik;
use App\AntrianFrontOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      self::resetKapasitasPelayanan();
      return Poliklinik::all();
    }

    public function resetKapasitasPelayanan()
    {
      $allPoliklinik = Poliklinik::whereDay('updated_at', '<', date('d'))->get();
      foreach ($allPoliklinik as $poliklinik) {
        $poliklinik->sisa_pelayanan = $poliklinik->kapasitas_pelayanan;
        $poliklinik->save();
      }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $poliklinik = new Poliklinik;
      $poliklinik->nama = $request->input('nama');
      $poliklinik->kategori_antrian = $request->input('kategori_antrian');
      $poliklinik->kapasitas_pelayanan = $request->input('kapasitas_pelayanan');
      $poliklinik->sisa_pelayanan = $request->input('sisa_pelayanan');
      $poliklinik->id_lokasi = $request->input('id_lokasi');
      $poliklinik->save();

      return response($poliklinik, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function show($nama)
    {
      return Poliklinik::findOrFail($nama);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nama)
    {
      $poliklinik = Poliklinik::findOrFail($nama);
      $kategori_antrian_lama = $poliklinik->kategori_antrian;
      $poliklinik->nama = $request->input('nama');
      $poliklinik->kategori_antrian = $request->input('kategori_antrian');
      $poliklinik->kapasitas_pelayanan = $request->input('kapasitas_pelayanan');
      $poliklinik->sisa_pelayanan = $request->input('sisa_pelayanan');
      $poliklinik->id_lokasi = $request->input('id_lokasi');
      $poliklinik->save();

      $last_antrian = AntrianFrontOffice::where('kategori_antrian', '=', $request->input('kategori_antrian'))
                                            ->max('no_antrian');
      $antrian_kategori = AntrianFrontOffice::where('kategori_antrian', '=', $request->input('kategori_antrian'))
                                            ->get();
      $last_waktu = $poliklinik->updated_at;                                      
      if (!empty($antrian_kategori[0])) {
        $last_waktu = $antrian_kategori[count($antrian_kategori) - 1]->waktu_perubahan_antrian;
      }
      
      $updateList = AntrianFrontOffice::where('nama_layanan_poli', '=', $poliklinik->nama)->get();
      foreach ($updateList as $antrian) {
        $antrian->kategori_antrian = $poliklinik->kategori_antrian;
        $last_antrian = $last_antrian + 1;
        $last_waktu = $last_waktu->addSeconds(1);
        $antrian->no_antrian = $last_antrian;
        $antrian->waktu_perubahan_antrian = $last_waktu;
        $antrian->save();
      }
      Redis::publish('antrian', json_encode(['kategori_antrian' => $kategori_antrian_lama]));
      Redis::publish('antrian', json_encode(['kategori_antrian' => $poliklinik->kategori_antrian]));
      return response($poliklinik, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama)
    {
      $poliklinik = Poliklinik::findOrFail($nama);
      $poliklinik->delete();
      return response($poliklinik, 200);
    }
}
