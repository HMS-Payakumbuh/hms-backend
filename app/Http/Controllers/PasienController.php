<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Asuransi;
use Carbon\Carbon;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pasien::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pasien = new Pasien;
        if ($request->input('id')) {
            $pasien = Pasien::findOrFail($request->input('id'));
            return response($pasien, 200);
        }
        $pasien->nama_pasien = $request->input('nama_pasien');
        $pasien->tanggal_lahir = Carbon::parse($request->input('tanggal_lahir'));
        $pasien->jender = $request->input('jender');
        $pasien->agama = $request->input('agama');
        $pasien->alamat = $request->input('alamat');
        $pasien->kontak = $request->input('kontak');
        $pasien->gol_darah = $request->input('gol_darah');
        $pasien->save();

        //generate kode
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;
        if (strlen($month) == 1)
            $month = '0'.$month;
        if (strlen($day) == 1)
            $day = '0'.$day;
        $kode_pasien = ($year.$month.$day.'0000') + $pasien->id;
        $pasien->kode_pasien = (string) ($kode_pasien);
        $pasien->save();

        return response($pasien, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Pasien::with('asuransi')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->nama_pasien = $request->input('nama_pasien');
        $pasien->tanggal_lahir = Carbon::parse($request->input('tanggal_lahir'));
        $pasien->jender = $request->input('jender');
        $pasien->agama = $request->input('agama');
        $pasien->alamat = $request->input('alamat');
        $pasien->kontak = $request->input('kontak');
        $pasien->gol_darah = $request->input('gol_darah');
        $pasien->save();

        return response($pasien, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pasien::destroy($id);
        return response('', 204);
    }
}
