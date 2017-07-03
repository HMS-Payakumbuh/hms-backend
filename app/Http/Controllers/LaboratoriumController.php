<?php

namespace App\Http\Controllers;

use App\Laboratorium;
use Illuminate\Http\Request;

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
      $laboratorium->nama = $request->input('nama');
      $laboratorium->kategori_antrian = $request->input('kategori_antrian');
      $laboratorium->save();

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
