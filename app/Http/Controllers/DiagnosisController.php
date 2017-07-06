<?php

namespace App\Http\Controllers;

use App\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Diagnosis::with('daftarDiagnosis')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      foreach ($request->all() as $key => $value) {
        $diagnosis = new Diagnosis;
        $diagnosis->id_pasien = $value['id_pasien'];
        $diagnosis->tanggal_waktu = $value['tanggal_waktu'];
        $diagnosis->kode_diagnosis = $value['kode_diagnosis'];
        $diagnosis->save();
      }
      return response($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Diagnosis::with('daftarDiagnosis')->findOrFail($id);
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
      $diagnosis = Diagnosis::findOrFail($id);
      $diagnosis->id_pasien = $value['id_pasien'];
      $diagnosis->tanggal_waktu = $value['tanggal_waktu'];
      $diagnosis->kode_diagnosis = $value['kode_diagnosis'];
      $diagnosis->save();
      return response($diagnosis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Diagnosis::destroy($id);
      return response('', 204);
    }
}
