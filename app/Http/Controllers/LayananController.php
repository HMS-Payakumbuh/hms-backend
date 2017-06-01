<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Layanan;

class LayananController extends Controller
{
  public function create(Request $request) {
  	
  }

  public function store(Request $request) {
  	$layanan = new Layanan;

  	$layanan->nama_layanan = $request->nama_layanan;
  	$layanan->jenis = $request->jenis;
  	$layanan->kategori = $request->kategori;
  	$layanan->kapasitas_pelayanan = $request->kapasitas_pelayanan;
  	$layanan->sisa_pelayanan = $request->sisa_pelayanan;

  	$layanan->save();
  }

  public function save(Request $request) {
  	$layanan = Layanan::find($request->nama_layanan);

  	$layanan->nama_layanan = $request->nama_layanan;
  	$layanan->jenis = $request->jenis;
  	$layanan->kategori = $request->kategori;
  	$layanan->kapasitas_pelayanan = $request->kapasitas_pelayanan;
  	$layanan->sisa_pelayanan = $request->sisa_pelayanan;

  	$layanan->save();
  }

  public function delete(Request $request) {
  	Layanan::destroy($request->nama_layanan);
  }
}
