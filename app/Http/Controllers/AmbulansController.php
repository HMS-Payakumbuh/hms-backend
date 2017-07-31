<?php

namespace App\Http\Controllers;

use App\Ambulans;
use Illuminate\Http\Request;

class AmbulansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Ambulans::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $ambulans = new Ambulans;
      $ambulans->nama = $request->input('nama');
      $ambulans->status = $request->input('status');
      $ambulans->save();

      return response($ambulans, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function show($nama)
    {
      return Ambulans::findOrFail($nama);
    }

    public function getAvailable()
    {
      return Ambulans::where('status', '=', 'Available')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $nama)
    {
      $ambulans = Ambulans::findOrFail($nama);
      $ambulans->nama = $request->input('nama');
      $ambulans->status = $request->input('status');
      $ambulans->save();

      return response($ambulans, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama)
    {
      Ambulans::destroy($nama);
      return response('', 204);
    }
}
