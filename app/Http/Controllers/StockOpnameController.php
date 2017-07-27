<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\StockOpname;
use App\StockOpnameItem;

class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StockOpname::with('stockOpnameItem.jenisObat','stockOpnameItem.stokObat','lokasiData')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock_opname = new StockOpname;
        $stock_opname->lokasi = $request->input('lokasi');

        $stock_opname->save();

        foreach ($request->input('stock_opname_item') as $key => $value) {
            $stock_opname_item = new StockOpnameItem;

            $stock_opname_item->id_stock_opname = $stock_opname->id;
            $stock_opname_item->id_jenis_obat = $value['id_jenis_obat'];
            $stock_opname_item->id_stok_obat = $value['id_stok_obat'];
            $stock_opname_item->jumlah_awal = $value['jumlah_awal'];
            $stock_opname_item->jumlah_akhir = $value['jumlah_akhir'];
            $stock_opname_item->jumlah_fisik = $value['jumlah_fisik'];

            $stock_opname_item->save();
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
         return StockOpname::with('stockOpnameItem.jenisObat','stockOpnameItem.stokObat','lokasiData')->findOrFail($id);
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
        // TO-DO: Make into transaction?
        // TO-DO: Restriction checking (jumlah > 0 etc.)
        $stock_opname = StockOpname::with('stockOpnameItem')->findOrFail($id);

        $stock_opname->lokasi = $request->input('lokasi');

        $stock_opname->save();

        foreach ($request->input('stock_opname_item') as $key => $value) {
            $stock_opname_item = new StockOpnameItem;

            $stock_opname_item->id_stock_opname = $stock_opname->id;
            $stock_opname_item->id_jenis_obat = $value['id_jenis_obat'];
            $stock_opname_item->id_stok_obat = $value['id_stok_obat'];
            $stock_opname_item->jumlah_awal = $value['jumlah_awal'];
            $stock_opname_item->jumlah_akhir = $value['jumlah_akhir'];
            $stock_opname_item->jumlah_fisik = $value['jumlah_fisik'];

            $stock_opname_item->save();
        }

        return response ($stock_opname, 200)
            -> header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock_opname = StockOpname::find($id);
        $stock_opname->delete();
        return response ($id.' deleted', 200);
    }

    public function searchByLocation(Request $request)
    {
        $stock_opname = StockOpname::with('stockOpnameItem.jenisObat','stockOpnameItem.stokObat','lokasiData')
                        ->where('lokasi', $request->input('lokasi'))
                        ->get();
        return response ($stock_opname, 200)
                -> header('Content-Type', 'application/json');
    }
}
