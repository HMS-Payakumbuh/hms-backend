<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JenisObat;

class JenisObatController extends Controller
{
     /**
    * Display a listing of the resource.
    * @return Response
    */
    public function index()
    {
    	return JenisObat::all();
    }
    
    /**
    * Store a newly created resource in storage.
    * @param  Request $request
    * @return Response
    */
    public function store(Request $request)
    {
    	$jenis_obat = new JenisObat;
    	$jenis_obat->merek_obat = $request->input('merek_obat');
    	$jenis_obat->nama_generik = $request->input('nama_generik');
    	$jenis_obat->pembuat = $request->input('pembuat');
    	$jenis_obat->golongan = $request->input('golongan');
    	$jenis_obat->satuan = $request->input('satuan');
    	$jenis_obat->harga_jual_satuan = $request->input('harga_jual_satuan');
    	$jenis_obat->save();
    	return response ($jenis_obat, 201);
    }

    /**
    * Display the specified resource.
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    	return JenisObat::findOrFail($id);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  Request $request
    * @param  int  $id
    * @return Response
    */
    public function update(Request $request, $id)
    {
    	$jenis_obat = JenisObat::findOrFail($id);
    	$jenis_obat->merek_obat = $request->input('merek_obat');
    	$jenis_obat->nama_generik = $request->input('nama_generik');
    	$jenis_obat->pembuat = $request->input('pembuat');
    	$jenis_obat->golongan = $request->input('golongan');
    	$jenis_obat->satuan = $request->input('satuan');
    	$jenis_obat->harga_jual_satuan = $request->input('harga_jual_satuan');
    	$jenis_obat->save();
    	return response ($jenis_obat, 200)
    		-> header('Content-Type', 'application/json');
    }

    /**
    * Remove the specified resource from storage.
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
    	$jenis_obat = JenisObat::find($id);
    	$jenis_obat->delete();
    	return response ($id.' deleted', 200);
    }

    public function search(Request $request)
    {
        $jenis_obat = JenisObat::where('merek_obat','LIKE','%'.$request->input('merek_obat').'%')
                                ->get();
        return response ($jenis_obat, 200)
                -> header('Content-Type', 'application/json');
    }
}
