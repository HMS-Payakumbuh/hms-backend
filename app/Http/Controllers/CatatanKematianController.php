<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CatatanKematian;
use Carbon\Carbon; 

class CatatanKematianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('catatanKematian.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $catatanKematian = new CatatanKematian;
        $catatanKematian->id_pasien = $request->input('id_pasien');
        $catatanKematian->waktu_kematian = $request->input('waktu_kematian');
        $catatanKematian->tempat_kematian = $request->input('tempat_kematian');
        $catatanKematian->perkiraan_penyebab = $request->input('perkiraan_penyebab');

        if (Carbon::now() < Carbon::parse($catatanKematian->waktu_kematian)) {
            return response()->json([
                'error' => "Waktu kematian salah."
            ], 202);
        } else {    
            $catatanKematian->save();
            return response($catatanKematian, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_pasien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id_pasien)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pasien)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_pasien)
    {
        //
    }
}
