<?php

namespace App\Http\Controllers;

use App\Tindakan;
use App\TindakanOperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TindakanOperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $i = 0;
        $response = [];

        $tindakan = Tindakan
                    ::select(DB::raw('tindakan.id'))
                    ->orderBy('tindakan.id','desc')
                    ->first();

        foreach ($request->all() as $key => $value) {
            $tindakanOperasi = new TindakanOperasi;
            $tindakanOperasi->id_transaksi = $value['id_transaksi'];
            $tindakanOperasi->np_tenaga_medis = $value['np_tenaga_medis'];
            $tindakanOperasi->id_tindakan = $tindakan->id;
            $tindakanOperasi->save();

            $response[$i] = $tindakanOperasi;
            $i++;
        }
        return response($response, 201);
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($pemakaianKamarOperasiId)
    {
        $tindakanOperasi = TindakanOperasi
                            ::join('tindakan', 'tindakan_operasi.id_tindakan', '=', 'tindakan.id')
                            ->join('pemakaian_kamar_operasi','pemakaian_kamar_operasi.no_tindakan','=', 'tindakan.id' )
                            ->join('tenaga_medis', 'tindakan_operasi.np_tenaga_medis', '=', 'tenaga_medis.no_pegawai')
                            ->join('dokter', 'dokter.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->select(DB::raw('tindakan_operasi.id, tenaga_medis.nama, tenaga_medis.no_pegawai, dokter.spesialis, tindakan_operasi.id_tindakan, tindakan_operasi.id_transaksi'))
                            ->where('pemakaian_kamar_operasi.id','=',$pemakaianKamarOperasiId)
                            ->get();


        return $tindakanOperasi;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer $no_tindakan
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer $no_tindakan
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tindakanOperasi = TindakanOperasi::findOrFail($id);
        $tindakanOperasi->delete();
        return response('', 204);
    }
}
