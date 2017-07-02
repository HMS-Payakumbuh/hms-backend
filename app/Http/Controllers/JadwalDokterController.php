<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return JadwalDokter::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $jadwalDokter = new JadwalDokter;
      $jadwalDokter->nama_poli = $request->input('nama_poli');
      $jadwalDokter->np_dokter = $request->input('np_dokter');
      $jadwalDokter->tanggal = $request->input('tanggal');
      $jadwalDokter->waktu_mulai_praktik = $request->input('waktu_mulai_praktik');
      $jadwalDokter->waktu_selesai_praktik = $request->input('waktu_selesai_praktik');
      $jadwalDokter->save();

      return response($jadwalDokter, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_poli
     * @return \Illuminate\Http\Response
     */
    public function show($nama_poli, $np_dokter)
    {
      return JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nama_poli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nama_poli)
    {
      $jadwalDokter = JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->first();
      $jadwalDokter->nama_poli = $request->input('nama_poli');
      $jadwalDokter->np_dokter = $request->input('np_dokter');
      $jadwalDokter->tanggal = $request->input('tanggal');
      $jadwalDokter->waktu_mulai_praktik = $request->input('waktu_mulai_praktik');
      $jadwalDokter->waktu_selesai_praktik = $request->input('waktu_selesai_praktik');
      $jadwalDokter->save();

      return response($jadwalDokter, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama_poli
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama_poli)
    {
      $deletedRows = JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->first()->delete;
      return response('', 204);
    }
}
