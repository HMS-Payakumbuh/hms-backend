<?php

namespace App\Http\Controllers;

use App\TenagaMedis;
use Illuminate\Http\Request;

class TenagaMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return TenagaMedis::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $tenagaMedis = new TenagaMedis;
      $tenagaMedis->no_pegawai = $request->input('no_pegawai');
      $tenagaMedis->nama = $request->input('nama');
      $tenagaMedis->jabatan = $request->input('jabatan');
      $tenagaMedis->save();

      return response($tenagaMedis, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_pegawai
     * @return \Illuminate\Http\Response
     */
    public function show($no_pegawai)
    {
      return TenagaMedis::findOrFail($no_pegawai);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_pegawai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_pegawai)
    {
      $tenagaMedis = TenagaMedis::findOrFail($no_pegawai);
      $tenagaMedis->no_pegawai = $request->input('no_pegawai');
      $tenagaMedis->nama = $request->input('nama');
      $tenagaMedis->jabatan = $request->input('jabatan');
      $tenagaMedis->save();

      return response($tenagaMedis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_pegawai
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_pegawai)
    {
      TenagaMedis::destroy($no_pegawai);
      return response('', 204);
    }
}
