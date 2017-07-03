<?php

namespace App\Http\Controllers;

use App\DaftarDiagnosis;
use Illuminate\Http\Request;

class DaftarDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return DaftarDiagnosis::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $daftarDiagnosis = new daftarDiagnosis;
      $daftarDiagnosis->kode = $request->input('kode');
      $daftarDiagnosis->nama = $request->input('nama');
      $daftarDiagnosis->save();

      return response($daftarDiagnosis, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function show($kode)
    {
      return DaftarDiagnosis::findOrFail($kode);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kode)
    {
      $daftarDiagnosis = DaftarDiagnosis::findOrFail($kode);
      $daftarDiagnosis->kode = $request->input('kode');
      $daftarDiagnosis->nama = $request->input('nama');
      $daftarDiagnosis->save();

      return response($daftarDiagnosis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $kode
     * @return \Illuminate\Http\Response
     */
    public function destroy($kode)
    {
      DaftarDiagnosis::destroy($kode);
      return response('', 204);
    }
}
