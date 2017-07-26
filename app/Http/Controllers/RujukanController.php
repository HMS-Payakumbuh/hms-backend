<?php

namespace App\Http\Controllers;

use App\Rujukan;
use Illuminate\Http\Request;

class RujukanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Rujukan::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rujukan = new Rujukan;
      $rujukan->id_transaksi = $request->input('id_transaksi');
      $rujukan->no_rujukan = $request->input('no_rujukan');
      $rujukan->asal_rujukan = $request->input('asal_rujukan');
      $rujukan->diagnosis = $request->input('diagnosis');
      $rujukan->keterangan = $request->input('keterangan');
      $rujukan->save();

      return response($rujukan, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return Rujukan::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer  $id_transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_transaksi)
    {
      $rujukan = Rujukan::where('id_transaksi', '=', $id_transaksi)->first();
      $rujukan->no_rujukan = $request->input('no_rujukan');
      $rujukan->asal_rujukan = $request->input('asal_rujukan');
      $rujukan->diagnosis = $request->input('diagnosis');
      $rujukan->keterangan = $request->input('keterangan');
      $rujukan->save();

      return response($rujukan, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  integer  $id_transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_transaksi)
    {
      $rujukan = Rujukan::where('id_transaksi', '=', $id_transaksi)->first();
      $rujukan->delete();
      return response('', 204);
    }
}
