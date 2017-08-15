<?php

namespace App\Http\Controllers;

use App\JasaDokterRawatinap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JasaDokterRawatinapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $jasaDokterRawatinap = JasaDokterRawatinap
                            ::join('pemakaian_kamar_rawatinap', 'jasa_dokter_rawat_inap.id_pemakaian_kamar_rawatinap', '=', 'pemakaian_kamar_rawatinap.id')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('jasa_dokter_rawat_inap.*'))
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null)          
                            ->get();          

        return $jasaDokterRawatinap;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idPemakaian)
    {
        $jasaDokterRawatinap = new JasaDokterRawatinap;
        $jasaDokterRawatinap->id_pemakaian_kamar_rawatinap = $idPemakaian;
        $jasaDokterRawatinap->np_tenaga_medis =  $request->input('no_pegawai');
        $jasaDokterRawatinap->save();

        return response($jasaDokterRawatinap, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_pegawai)
    {
        $jasaDokterRawatinap = JasaDokterRawatinap
                            ::join('pemakaian_kamar_rawatinap', 'jasa_dokter_rawat_inap.id_pemakaian_kamar_rawatinap', '=', 'pemakaian_kamar_rawatinap.id')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('jasa_dokter_rawat_inap.*'))
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null) 
                            ->where('jasa_dokter_rawat_inap.np_tenaga_medis', '=', $no_pegawai)         
                            ->get();          

        return $jasaDokterRawatinap;
    }

    public function getJasaDokterByPemakaian($idPemakaian)
    {
        $jasaDokterRawatinap = JasaDokterRawatinap
                            ::join('pemakaian_kamar_rawatinap', 'jasa_dokter_rawat_inap.id_pemakaian_kamar_rawatinap', '=', 'pemakaian_kamar_rawatinap.id')
                            ->join('tenaga_medis', 'jasa_dokter_rawat_inap.np_tenaga_medis', '=', 'tenaga_medis.no_pegawai')
                            ->join('dokter', 'tenaga_medis.no_pegawai', '=', 'dokter.no_pegawai')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('jasa_dokter_rawat_inap.*, dokter.*, tenaga_medis.nama'))
                            ->where('pemakaian_kamar_rawatinap.id', '=', $idPemakaian)    
                            ->orderBy('tenaga_medis.no_pegawai')    
                            ->get();          

        return $jasaDokterRawatinap;
    }

    public function destroy($id)
    {
        $jasaDokterRawatinap = JasaDokterRawatinap::findOrFail($id);
        $jasaDokterRawatinap->delete();
        return response('', 204);
    }
}