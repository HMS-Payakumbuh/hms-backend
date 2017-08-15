<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StokObat;
use App\LokasiObat;
use Excel;

class StokObatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StokObat::with('obatMasuk','jenisObat','lokasiData')->get();
    }

    // TO-DO: Remove as updates will be done by other controllers
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stok_obat = new StokObat;
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return StokObat::with('obatMasuk','jenisObat','lokasiData')->findOrFail($id);
    }

    // TO-DO: Remove as updates will be done by other controllers
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stok_obat = StokObat::findOrFail($id);
        $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');
        $stok_obat->id_obat_masuk = $request->input('id_obat_masuk');
        $stok_obat->jumlah = $request->input('jumlah');       
        $stok_obat->lokasi = $request->input('lokasi');
        $stok_obat->save();
        return response ($stok_obat, 200)
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
        $stok_obat = StokObat::find($id);
        $stok_obat->delete();
        return response ($id.' deleted', 200);
    }

    public function searchByJenisObatAndBatch(Request $request)
    {
        $lokasi_obat = LokasiObat::where('jenis','=', $request->input('jenis_lokasi'))->first();  

        $stok_obat = StokObat::where('id_jenis_obat', $request->input('id_jenis_obat'))
                                ->where('nomor_batch', '=', $request->input('nomor_batch'))
                                ->where('jumlah','>',0)
                                ->where('lokasi', $lokasi_obat->id)
                                ->firstOrFail();
        return response ($stok_obat, 200)
                -> header('Content-Type', 'application/json');
    }

    public function searchByLocation(Request $request)
    {        
        $stok_obat = StokObat::with('jenisObat')
                                ->where('jumlah','>',0)
                                ->where('lokasi', $request->input('lokasi'))
                                ->get();
        return response ($stok_obat, 200)
                -> header('Content-Type', 'application/json');
    }

    public function searchByLocationType(Request $request)
    {
        $lokasi_obat = LokasiObat::where('jenis','=', $request->input('jenis_lokasi'))->first();  

        $stok_obat = StokObat::with('jenisObat')
                                ->where('jumlah','>',0)
                                ->where('lokasi', $lokasi_obat->id)
                                ->get();

        return response ($stok_obat, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export($lokasi) 
    {
        $all_stok_obat = StokObat::when($lokasi > 0, function ($query) use ($lokasi) {
                                 return $query->where('stok_obat.lokasi', '=', $lokasi);
                            })
                            ->where('jumlah','>',0)
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'stok_obat.id_jenis_obat')
                            ->join('lokasi_obat', 'lokasi_obat.id', '=', 'stok_obat.lokasi')
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode', 
                                    'stok_obat.jumlah',
                                    'jenis_obat.satuan', 
                                    'lokasi_obat.nama')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Jumlah', 'Satuan', 'Lokasi'];

        foreach($all_stok_obat as $stok_obat) {
            $data[] = $stok_obat->toArray();
        }

        return Excel::create('stok_obat', function($excel) use ($data) {
            $excel->setTitle('Stok Obat')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar stok obat');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
