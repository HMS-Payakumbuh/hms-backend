<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatMasuk;
use App\StokObat;
use App\LokasiObat;
use Excel;

class ObatMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatMasuk::with('jenisObat','stokObat')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TO-DO: Make into transaction?
        $lokasi_obat = LokasiObat::where('jenis','=',0)->first();

        $id_jenis_append = sprintf("%05d", $request->input('id_jenis_obat'));
        $kadaluarsa_clean = str_replace(["-", "–"], '', $request->input('kadaluarsa'));
        $barcode = $id_jenis_append.$request->input('nomor_batch').$kadaluarsa_clean;

        $stok_obat = StokObat::where('barcode','LIKE','%'.$barcode.'%')
                            ->where('lokasi','=',$lokasi_obat->id)
                            ->first();

        if (is_null($stok_obat)) {
            $stok_obat = new StokObat;
            $stok_obat->id_jenis_obat = $request->input('id_jenis_obat');  
            $stok_obat->nomor_batch = $request->input('nomor_batch');
            $stok_obat->jumlah = $request->input('jumlah');
            $stok_obat->kadaluarsa = $request->input('kadaluarsa');
            $stok_obat->barcode = $barcode;
            $stok_obat->lokasi = $lokasi_obat->id;
        } else {
            $stok_obat->jumlah = $stok_obat->jumlah + $request->input('jumlah');
        }

        $stok_obat->save();

        $obat_masuk = new ObatMasuk;
        $obat_masuk->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_masuk->id_stok_obat = $stok_obat->id;

        date_default_timezone_set('Asia/Jakarta');
        $obat_masuk->waktu_masuk = date("Y-m-d H:i:s"); // Use default in DB instead?
        
        $obat_masuk->jumlah = $request->input('jumlah');
        $obat_masuk->harga_beli_satuan = $request->input('harga_beli_satuan');

        $obat_masuk->save();

        return response ($obat_masuk, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatMasuk::with('jenisObat','stokObat')->findOrFail($id);
    }

    // TO-DO: Remove or restrict updates
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $obat_masuk = ObatMasuk::findOrFail($id);
        $obat_masuk->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_masuk->id_stok_obat = $request->input('id_stok_obat');
        $obat_masuk->waktu_masuk = $request->input('waktu_masuk');
        $obat_masuk->jumlah = $request->input('jumlah');
        $obat_masuk->harga_beli_satuan = $request->input('harga_beli_satuan');
        $obat_masuk->save();
        return response ($obat_masuk, 200)
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
        $obat_masuk = ObatMasuk::find($id);
        $obat_masuk->delete();
        return response ($id.' deleted', 200);
    }

    public function getTodayObatMasukByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_masuk = ObatMasuk::whereDate('waktu_masuk', '=', date("Y-m-d"))
                                ->where('id_stok_obat', $id_stok_obat)
                                ->get();
        return response ($obat_masuk, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export() 
    {
        $all_obat_masuk = ObatMasuk::join('jenis_obat', 'jenis_obat.id', '=', 'obat_masuk.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_masuk.id_stok_obat')
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_masuk.waktu_masuk', 
                                    'obat_masuk.jumlah',
                                    'jenis_obat.satuan', 
                                    'obat_masuk.harga_beli_satuan')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu masuk', 'Jumlah', 'Satuan', 'Harga beli satuan'];

        foreach($all_obat_masuk as $obat_masuk) {
            $data[] = $obat_masuk->toArray();
        }

        return Excel::create('obat_masuk', function($excel) use ($data) {
            $excel->setTitle('Obat Masuk')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat masuk');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
