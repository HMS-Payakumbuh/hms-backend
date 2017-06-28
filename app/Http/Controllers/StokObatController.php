<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StokObat;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StokObat::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stok_obat = new StokObat;
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return StokObat::findOrFail($id);
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
        $stok_obat = StokObat::findOrFail($id);
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 200)
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
        $stok_obat = StokObat::find($id);
        $stok_obat->delete();
        return response ($id.' deleted', 200);
    }
}
