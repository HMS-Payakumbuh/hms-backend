<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatPindah;
use App\StokObat;
use Excel;
use DateTime;
use DateInterval;

class ObatPindahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatPindah::with('stokObatAsal',
            'stokObatTujuan','jenisObat','lokasiAsal','lokasiTujuan')->get();
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
        // TO-DO: Restriction checking (jumlah > 0 etc.)
        $obat_pindah = new ObatPindah;
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_stok_obat_asal = $request->input('id_stok_obat_asal');
        
        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah->waktu_pindah = date("Y-m-d H:i:s"); // Use default in DB instead?
        
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');        

        $stok_obat_asal = StokObat::findOrFail($obat_pindah->id_stok_obat_asal);
        $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_pindah->jumlah);

        if ($stok_obat_asal->jumlah < 0) {
            return response("less than 0 error", 401);
        }

        $stok_obat_tujuan = StokObat::where('barcode','LIKE','%'.$stok_obat_asal->barcode.'%')
                                    ->where('lokasi', '=', $obat_pindah->tujuan)
                                    ->first();

        if (is_null($stok_obat_tujuan)) {
            $stok_obat_tujuan = new StokObat;
            $stok_obat_tujuan->id_jenis_obat = $obat_pindah->id_jenis_obat;
            $stok_obat_tujuan->nomor_batch = $stok_obat_asal->nomor_batch;
            $stok_obat_tujuan->kadaluarsa = $stok_obat_asal->kadaluarsa;
            $stok_obat_tujuan->barcode = $stok_obat_asal->barcode;
            $stok_obat_tujuan->jumlah =  $obat_pindah->jumlah;  
            $stok_obat_tujuan->lokasi = $obat_pindah->tujuan;
        } else {
            $stok_obat_tujuan->jumlah =  ($stok_obat_tujuan->jumlah) + ($obat_pindah->jumlah);  
        }         

        $stok_obat_asal->save();
        $stok_obat_tujuan->save();

        $obat_pindah->id_stok_obat_tujuan = $stok_obat_tujuan->id;
        $obat_pindah->save();

        return response ($obat_pindah, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatPindah::with('stokObatAsal',
            'stokObatTujuan','jenisObat','lokasiAsal','lokasiTujuan')->findOrFail($id);
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
        $obat_pindah = ObatPindah::findOrFail($id);
        $obat_pindah->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_pindah->id_stok_obat_asal = $request->input('id_stok_obat_asal');
        $obat_pindah->id_stok_obat_tujuan = $request->input('id_stok_obat_tujuan');
        $obat_pindah->waktu_pindah = $request->input('waktu_pindah');
        $obat_pindah->jumlah = $request->input('jumlah');
        $obat_pindah->keterangan = $request->input('keterangan');
        $obat_pindah->asal = $request->input('asal');
        $obat_pindah->tujuan = $request->input('tujuan');
        $obat_pindah->save();
        return response ($obat_pindah, 200)
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
        $obat_pindah = ObatPindah::find($id);
        $obat_pindah->delete();
        return response ($id.' deleted', 200);
    }

    /* public function getTodayObatPindahKeluarByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah = ObatPindah::with('lokasiTujuan')
                                ->whereDate('waktu_pindah', '=', date("Y-m-d"))
                                ->where('id_stok_obat_asal', $id_stok_obat)
                                ->get();
        return response ($obat_pindah, 200)
                -> header('Content-Type', 'application/json');
    } *.

    /*
        Get Obat Pindah keluar with same Stok Obat ID within a time range
    */
    public function getObatPindahKeluarByTime(Request $request)
    {
        $waktu_mulai = new DateTime($request->waktu_mulai);
        $waktu_selesai = new DateTime($request->waktu_selesai);
        $id_stok_obat = $request->id_stok_obat;

        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah = ObatPindah::with('lokasiTujuan')
                                ->whereBetween('waktu_pindah', array($waktu_mulai, $waktu_selesai))
                                ->where('id_stok_obat_asal', $id_stok_obat)
                                ->get();
        return response ($obat_pindah, 200)
                -> header('Content-Type', 'application/json');
    }

    /* public function getTodayObatPindahMasukByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah = ObatPindah::with('lokasiAsal')
                                ->whereDate('waktu_pindah', '=', date("Y-m-d"))
                                ->where('id_stok_obat_tujuan', $id_stok_obat)
                                ->get();
        return response ($obat_pindah, 200)
                -> header('Content-Type', 'application/json');
    } */

    /*
        Get Obat Pindah masuk with same Stok Obat ID within a time range
    */
    public function getObatPindahMasukByTime(Request $request)
    {
        $waktu_mulai = new DateTime($request->waktu_mulai);
        $waktu_selesai = new DateTime($request->waktu_selesai);
        $id_stok_obat = $request->id_stok_obat;

        date_default_timezone_set('Asia/Jakarta');
        $obat_pindah = ObatPindah::with('lokasiAsal')
                                ->whereBetween('waktu_pindah', array($waktu_mulai, $waktu_selesai))
                                ->where('id_stok_obat_tujuan', $id_stok_obat)
                                ->get();
        return response ($obat_pindah, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export(Request $request) 
    {
        $tanggal_mulai = new DateTime($request->tanggal_mulai);
        $tanggal_selesai = new DateTime($request->tanggal_selesai);
        $tanggal_selesai->add(new DateInterval("P1D")); // Plus 1 day

        $all_obat_pindah = ObatPindah::whereBetween('waktu_pindah', array($tanggal_mulai, $tanggal_selesai))
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'obat_pindah.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_pindah.id_stok_obat_asal')
                            ->join('lokasi_obat as lokasi_asal', 'lokasi_asal.id', '=', 'obat_pindah.asal')
                            ->join('lokasi_obat as lokasi_tujuan', 'lokasi_tujuan.id', '=', 'obat_pindah.tujuan') // Error: Lokasi tujuan not displayed yet
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_pindah.waktu_pindah', 
                                    'obat_pindah.jumlah',
                                    'jenis_obat.satuan', 
                                    'lokasi_asal.nama',
                                    'lokasi_tujuan.nama',
                                    'obat_pindah.keterangan')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu pindah', 'Jumlah', 'Satuan', 'Lokasi asal', 'Lokasi tujuan', 'Keterangan'];

        foreach($all_obat_pindah as $obat_pindah) {
            $data[] = $obat_pindah->toArray();
        }

        return Excel::create('obat_pindah', function($excel) use ($data) {
            $excel->setTitle('Obat Pindah')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat pindah');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
