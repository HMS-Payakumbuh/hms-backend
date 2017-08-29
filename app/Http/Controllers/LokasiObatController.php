<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LokasiObat;

class LokasiObatController extends Controller
{
     /**
    * Display a listing of the resource.
    * @return Response
    */
    public function index()
    {
    	return LokasiObat::all();
    }
    
    /**
    * Store a newly created resource in storage.
    * @param  Request $request
    * @return Response
    */
    public function store(Request $request)
    {
    	$lokasi_obat = new LokasiObat;    	
    	$lokasi_obat->nama = $request->input('nama');
        $lokasi_obat->jenis = $request->input('jenis');

        if ($lokasi_obat->jenis == 0 || $lokasi_obat->jenis == 1) {
            $lokasi_obat_temp = LokasiObat::where('jenis', $lokasi_obat->jenis)->first();
            if (!is_null($lokasi_obat_temp)) {
                return response ('Duplicate jenis', 401);
            }   
        }

    	$lokasi_obat->save();
    	return response ($lokasi_obat, 201);
    }

    /**
    * Display the specified resource.
    * @param  int  $id
    * @return Response
    */
    public function show($id)
    {
    	return LokasiObat::findOrFail($id);
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
    	$lokasi_obat = LokasiObat::findOrFail($id);
    	$lokasi_obat->nama = $request->input('nama');
        $lokasi_obat->jenis = $request->input('jenis');

        if ($lokasi_obat->jenis == 0 || $lokasi_obat->jenis == 1) {
            $lokasi_obat_temp = LokasiObat::where('jenis', $lokasi_obat->jenis)->first();
            if (!is_null($lokasi_obat_temp)) {
                return response ('Duplicate jenis', 401);
            }   
        }

    	$lokasi_obat->save();
    	return response ($lokasi_obat, 200)
    		-> header('Content-Type', 'application/json');
    }

    /**
    * Remove the specified resource from storage.
    * @param  int  $id
    * @return Response
    */
    public function destroy($id)
    {
    	$lokasi_obat = LokasiObat::find($id);
    	$lokasi_obat->delete();
    	return response ($id + ' deleted', 200);
    }
}
