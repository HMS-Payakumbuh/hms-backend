<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pasien;
use App\Asuransi;
use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

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
            $pasien->id = $request->input('id');
            return response($pasien, 201);
        }
        $pasien->nama_pasien = $request->input('nama_pasien');
        $pasien->tanggal_lahir = Carbon::parse($request->input('tanggal_lahir'));
        $pasien->jender = $request->input('jender');
        $pasien->agama = $request->input('agama');
        $pasien->alamat = $request->input('alamat');
        $pasien->kontak = $request->input('kontak');
        $pasien->gol_darah = $request->input('gol_darah');
        $pasien->save();

        //generate uuid
        $pasien->kode_pasien = Uuid::generate(3, $pasien->id, Uuid::NS_DNS);
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
