<?php

namespace App\Http\Controllers;

use App\PemakaianKamarJenazah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianKamarJenazahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemakaianKamarJenazah = PemakaianKamarJenazah
                            ::join('transaksi', 'pemakaian_kamar_jenazah.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->select(DB::raw('pemakaian_kamar_jenazah.id, pemakaian_kamar_jenazah.no_kamar, pasien.nama_pasien, pemakaian_kamar_jenazah.waktu_masuk, pemakaian_kamar_jenazah.waktu_keluar'))
                            ->get();          

        return $pemakaianKamarJenazah;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaianKamarJenazah = new PemakaianKamarJenazah;
        $pemakaianKamarJenazah->no_kamar = $request->input('no_kamar');
        $pemakaianKamarJenazah->id_transaksi = $request->input('id_transaksi');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarJenazah->waktu_masuk = date("Y-m-d H:i:s");
        $pemakaianKamarJenazah->waktu_keluar = null;
        $pemakaianKamarJenazah->harga = $request->input('harga');
        $pemakaianKamarJenazah->save();

        // $catatanKematian = new CatatanKematian;
        // $transaksi = Transaksi::findOrFail($request->input('id_transaksi'));
        // $catatanKematian->id_pasien = $transaksi->id_pasien;
        // $catatanKematian->waktu_kematian = $pemakaianKamarJenazah->waktu_masuk;
        // $catatanKematian->tempat_kematian = 'RS Payakumbuh';
        // $catatanKematian->perkiraan_penyebab = 'Sakit hati';
        // $catatanKematian->save();

        return response($pemakaianKamarJenazah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        return PemakaianKamarJenazah::findOrFail($no_kamar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pemakaianKamarJenazah = PemakaianKamarJenazah::findOrFail($id);

        // $pemakaianKamarJenazah->no_kamar = $request->input('no_kamar');
        // $pemakaianKamarJenazah->id_transaksi = $request->input('id_transaksi');
        // $pemakaianKamarJenazah->no_pembayaran = $request->input('no_pembayaran');
        // $pemakaianKamarJenazah->waktu_masuk = $request->input('waktu_masuk');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarJenazah->waktu_keluar = date("Y-m-d H:i:s");
        // $pemakaianKamarJenazah->harga = $request->input('harga');
        $pemakaianKamarJenazah->save();

        return response($pemakaianKamarJenazah, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pemakaianKamarJenazah = PemakaianKamarJenazah::findOrFail($id);
        $pemakaianKamarJenazah->delete();
        return response('', 204);

    }
}
