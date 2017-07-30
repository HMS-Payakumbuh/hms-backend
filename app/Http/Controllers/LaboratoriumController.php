<?php

namespace App\Http\Controllers;

use App\Laboratorium;
use App\AntrianFrontOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Laboratorium::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $laboratorium = new Laboratorium;
      $laboratorium->nama = $request->input('nama');
      $laboratorium->kategori_antrian = $request->input('kategori_antrian');
      $laboratorium->save();

      return response($laboratorium, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function show($nama)
    {
      return Laboratorium::findOrFail($nama);
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
      $laboratorium = Laboratorium::findOrFail($nama);
      $kategori_antrian_lama = $laboratorium->kategori_antrian;
      $laboratorium->nama = $request->input('nama');
      $laboratorium->kategori_antrian = $request->input('kategori_antrian');
      $laboratorium->save();

      $updateList = AntrianFrontOffice::where('nama_layanan_lab', '=', $laboratorium->nama)->get();
      foreach ($updateList as $antrian) {
        $antrian->kategori_antrian = $laboratorium->kategori_antrian;
        $antrian->save();
      }
      Redis::publish('antrian', json_encode(['kategori_antrian' => $kategori_antrian_lama]));
      Redis::publish('antrian', json_encode(['kategori_antrian' => $laboratorium->kategori_antrian]));
      return response($laboratorium, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama)
    {
      Laboratorium::destroy($nama);
      return response('', 204);
    }
}
