<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ObatRusak;
use App\StokObat;
use Excel;
use DateTime;
use DateInterval;

class ObatRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatRusak::with('jenisObat','stokObat','lokasiAsal')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $obat_rusak = new ObatRusak;
        $obat_rusak->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_rusak->id_stok_obat = $request->input('id_stok_obat');

        date_default_timezone_set('Asia/Jakarta');
        $obat_rusak->waktu_keluar = date("Y-m-d H:i:s");
        
        $obat_rusak->jumlah = $request->input('jumlah');        
        $obat_rusak->alasan = $request->input('alasan');
        $obat_rusak->keterangan = $request->input('keterangan');
        $obat_rusak->asal = $request->input('asal');

        try {
            DB::beginTransaction();

            $stok_obat_asal = StokObat::findOrFail($obat_rusak->id_stok_obat);
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_rusak->jumlah);

            /* if ($stok_obat_asal->jumlah < 0) {
                return response("less than 0 error", 401);
            } */        

            $obat_rusak->save();
            $stok_obat_asal->save();

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'code' => '500',
                'message' => $e->getMessage()
            ], 500);
        }

        DB::commit();
        return response ($obat_rusak, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatRusak::with('jenisObat','stokObat','lokasiAsal')->findOrFail($id);
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
        $obat_rusak = ObatRusak::findOrFail($id);
        $obat_rusak->id_jenis_obat = $request->input('id_jenis_obat');
        $obat_rusak->id_obat_masuk = $request->input('id_obat_masuk');
        $obat_rusak->waktu_keluar = $request->input('waktu_keluar');
        $obat_rusak->jumlah = $request->input('jumlah');        
        $obat_rusak->alasan = $request->input('alasan');
        $obat_rusak->keterangan = $request->input('keterangan');
        $obat_rusak->asal = $request->input('asal');
        $obat_rusak->save();
        return response ($obat_rusak, 200)
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
        $obat_rusak = ObatRusak::find($id);
        $obat_rusak->delete();
        return response ($id.' deleted', 200);
    }

    /* public function getTodayObatRusakByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_rusak = ObatRusak::whereDate('waktu_keluar', '=', date("Y-m-d"))
                                ->where('id_stok_obat', $id_stok_obat)
                                ->get();
        return response ($obat_rusak, 200)
                -> header('Content-Type', 'application/json');
    } */

    /*
        Get Obat Rusak with same Stok Obat ID within a time range
    */
    public function getObatRusakByTime(Request $request)
    {
        $waktu_mulai = new DateTime($request->waktu_mulai);
        $waktu_selesai = new DateTime($request->waktu_selesai);
        $id_stok_obat = $request->id_stok_obat;

        date_default_timezone_set('Asia/Jakarta');
        $obat_rusak = ObatRusak::whereBetween('waktu_keluar', array($waktu_mulai, $waktu_selesai))
                                ->where('id_stok_obat', $id_stok_obat)
                                ->get();
        return response ($obat_rusak, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export(Request $request) 
    {
        $tanggal_mulai = new DateTime($request->tanggal_mulai);
        $tanggal_selesai = new DateTime($request->tanggal_selesai);
        $tanggal_selesai->add(new DateInterval("P1D")); // Plus 1 day

        $all_obat_rusak = ObatRusak::whereBetween('waktu_keluar', array($tanggal_mulai, $tanggal_selesai))
                            ->when($request->alasan != "Semua", function ($query) use ($request) {
                                 return $query->where('alasan', 'LIKE', $request->alasan);
                            })
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'obat_rusak.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_rusak.id_stok_obat')
                            ->join('lokasi_obat', 'lokasi_obat.id', '=', 'obat_rusak.asal')
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_rusak.waktu_keluar', 
                                    'obat_rusak.jumlah',
                                    'jenis_obat.satuan', 
                                    'obat_rusak.alasan',
                                    'obat_rusak.keterangan',
                                    'lokasi_obat.nama')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu keluar', 'Jumlah', 'Satuan', 'Alasan', 'Keterangan', 'Lokasi asal'];

        foreach($all_obat_rusak as $obat_rusak) {
            $data[] = $obat_rusak->toArray();
        }

        return Excel::create('obat_rusak', function($excel) use ($data) {
            $excel->setTitle('Obat ObatRusak')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat rusak');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
