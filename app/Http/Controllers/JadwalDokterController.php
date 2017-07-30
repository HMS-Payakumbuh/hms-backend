<?php

namespace App\Http\Controllers;

use App\JadwalDokter;
use Carbon\Carbon;
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
      return JadwalDokter::join('tenaga_medis', 'jadwal_dokter.np_dokter', '=', 'tenaga_medis.no_pegawai')
        ->select('jadwal_dokter.*', 'tenaga_medis.nama AS nama_dokter')
        ->get();
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
      $jadwalDokter->tanggal = Carbon::parse($request->input('tanggal'));
      $jadwalDokter->waktu_mulai_praktik = $request->input('waktu_mulai_praktik');
      $jadwalDokter->waktu_selesai_praktik = $request->input('waktu_selesai_praktik');
      $jadwalDokter->save();

      return response($jadwalDokter, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_poli
     * @param  string  $np_dokter
     * @param  string  $tanggal
     * @return \Illuminate\Http\Response
     */
    public function show($nama_poli, $np_dokter, $tanggal)
    {
      return JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->where('tanggal', '=', $tanggal)
        ->join('tenaga_medis', 'jadwal_dokter.np_dokter', '=', 'tenaga_medis.no_pegawai')
        ->select('jadwal_dokter.*', 'tenaga_medis.nama AS nama_dokter')
        ->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama_poli
     * @return \Illuminate\Http\Response
     */
    public function showAvailable($nama_poli)
    {
      return JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('tanggal', '=', Carbon::today()->toDateString())
        ->where('waktu_mulai_praktik', '<=', Carbon::now()->format('H:i:s'))
        ->where('waktu_selesai_praktik', '>=', Carbon::now()->format('H:i:s'))
        ->join('tenaga_medis', 'jadwal_dokter.np_dokter', '=', 'tenaga_medis.no_pegawai')
        ->select('jadwal_dokter.*', 'tenaga_medis.nama AS nama_dokter')
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nama_poli
     * @param  string  $np_dokter
     * @param  string  $tanggal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nama_poli, $np_dokter, $tanggal)
    {
      $jadwalDokter = JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->where('tanggal', '=', $tanggal)
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
     * @param  string  $np_dokter
     * @param  string  $tanggal
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama_poli, $np_dokter, $tanggal)
    {
      $deletedRows = JadwalDokter::where('nama_poli', '=', $nama_poli)
        ->where('np_dokter', '=', $np_dokter)
        ->where('tanggal', '=', $tanggal)
        ->first()
        ->delete();
      return response('', 204);
    }
}
