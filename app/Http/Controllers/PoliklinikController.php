<?php

namespace App\Http\Controllers;

use App\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Poliklinik::all();
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
      $poliklinik->nama = $request->input('nama');
      $poliklinik->kategori_antrian = $request->input('kategori_antrian');
      $poliklinik->kapasitas_pelayanan = $request->input('kapasitas_pelayanan');
      $poliklinik->sisa_pelayanan = $request->input('sisa_pelayanan');
      $poliklinik->id_lokasi = $request->input('id_lokasi');
      $poliklinik->save();

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
