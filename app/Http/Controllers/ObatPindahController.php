<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatPindah;

class ObatPindahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatPindah::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obat_pindah = new ObatPindah;
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_pindah->waktu_pindah = $request->input('waktu_pindah');
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');
        $obat_pindah->save();
        return response ($obat_pindah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatPindah::findOrFail($id);
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
        $obat_pindah = ObatPindah::findOrFail($id);
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_pindah->waktu_pindah = $request->input('waktu_pindah');
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');
        $obat_pindah->save();
        return response ($obat_pindah, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $obat_pindah = ObatPindah::find($id);
        $obat_pindah->delete();
        return response ($id.' deleted', 200);
    }
}
