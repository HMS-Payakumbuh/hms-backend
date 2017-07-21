<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RekamMedis;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RekamMedis::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rekam_medis = new RekamMedis;
        $rekam_medis->id_pasien = $request->input('id_pasien');
        $rekam_medis->tanggal_waktu = $request->input('tanggal_waktu');
        $rekam_medis->np_dokter = $request->input('np_dokter');
        $rekam_medis->hasil_pemeriksaan = $request->input('hasil_pemeriksaan');
        $rekam_medis->anamnesis = $request->input('anamnesis');
        $rekam_medis->rencana_penatalaksanaan = $request->input('rencana_penatalaksanaan');
        $rekam_medis->pelayanan_lain = $request->input('pelayanan_lain');
        $rekam_medis->save();

        return response($rekam_medis, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_pasien)
    {
        $rekam_medis = RekamMedis
                            ::with('pasien')
                            ->orderBy('tanggal_waktu', 'desc')
                            ->where('id_pasien', '=', $id_pasien)
                            ->get();
        return $rekam_medis;
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
        $rekam_medis = RekamMedis::findOrFail($id);
        $rekam_medis->id_pasien = $request->input('id_pasien');
        $rekam_medis->np_dokter = $request->input('np_dokter');
        $rekam_medis->hasil_pemeriksaan = $request->input('hasil_pemeriksaan');
        $rekam_medis->anamnesis = $request->input('anamnesis');
        $rekam_medis->rencana_penatalaksanaan = $request->input('rencana_penatalaksanaan');
        $rekam_medis->pelayanan_lain = $request->input('pelayanan_lain');
        $rekam_medis->save();
        return response($rekam_medis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RekamMedis::destroy($id);
        return response('', 204);
    }
}
