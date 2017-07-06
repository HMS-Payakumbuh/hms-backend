<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AntrianFrontOffice;
use Carbon\Carbon;

class AntrianFrontOfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AntrianFrontOffice::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $antrian_front_office = new AntrianFrontOffice;
        $antrian_front_office->nama_layanan = $request->input('nama_layanan');
        $antrian_front_office->jenis = $request->input('jenis');
        $antrian_front_office->kategori_antrian = $request->input('kategori_antrian');
        $antrian_front_office->save();

        return response($antrian_front_office, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kategori_antrian
     * @return \Illuminate\Http\Response
     */
    public function show($kategori_antrian)
    {
        AntrianFrontOffice::findOrFail($kategori_antrian);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function update($nama_layanan, $no_antrian)
    {
        $antrian_front_office = AntrianFrontOffice::where('nama_layanan', '=', $nama_layanan)
        ->where('no_antrian', '=', $no_antrian)
        ->first();
        $antrian_front_office->waktu_perubahan_antrian = Carbon::now();
        $antrian_front_office->save();
		return response($antrian_front_office, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama_layanan, $no_antrian)
    {
        $deletedRows = AntrianFrontOffice::where('nama_layanan', '=', $nama_layanan)
          ->where('no_antrian', '=', $no_antrian)
          ->first()
          ->delete();
        return response('', 204);
    }
}
