<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaksi;
use App\TransaksiEksternal;
use App\ObatTebus;
use App\StokObat;
use App\ObatTebusItem;
use App\Resep;
use Excel;
use DateTime;
use DateInterval;

class ObatTebusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien','obatTebusItem.stokObat','obatTebusItem.jenisObat','transaksiEksternal')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $obat_tebus = new ObatTebus;
            $obat_tebus->id_resep = $request->input('id_resep');        

            $resep = Resep::findOrFail($obat_tebus->id_resep);

            $obat_tebus->eksternal = $resep->eksternal;

            if ($obat_tebus->eksternal) {
                $obat_tebus->id_transaksi_eksternal = $resep->id_transaksi_eksternal; 
            } else {
                $obat_tebus->id_transaksi = $resep->id_transaksi;    
            }

            date_default_timezone_set('Asia/Jakarta');
            $obat_tebus->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?
            $obat_tebus->save();

            foreach ($request->input('obat_tebus_item') as $key => $value) {
                $obat_tebus_item = new ObatTebusItem;

                $obat_tebus_item->id_obat_tebus = $obat_tebus->id;
                $obat_tebus_item->id_jenis_obat = $value['id_jenis_obat'];
                $obat_tebus_item->id_stok_obat = $value['id_stok_obat'];
                $obat_tebus_item->jumlah = $value['jumlah'];
                $obat_tebus_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
                $obat_tebus_item->keterangan = $value['keterangan'];
                $obat_tebus_item->asal = $value['asal'];
                $obat_tebus_item->id_resep_item = $value['id_resep_item'];
                $obat_tebus_item->id_racikan_item = $value['id_racikan_item'];         

                $stok_obat_asal = StokObat::findOrFail($obat_tebus_item->id_stok_obat);
                $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tebus_item->jumlah);

                if ($stok_obat_asal->jumlah < 0) {
                    return response("less than 0 error", 401);
                }   

                if ($obat_tebus_item->save()) {
                    if ($obat_tebus->eksternal) {
                        $transaksi = TransaksiEksternal::findOrFail($obat_tebus->id_transaksi_eksternal);
                        $transaksi->harga_total += $obat_tebus_item->harga_jual_realisasi * $obat_tebus_item->jumlah;
                        $transaksi->save();
                    } else {
                        $transaksi = Transaksi::findOrFail($obat_tebus->id_transaksi);
                        $transaksi->harga_total += $obat_tebus_item->harga_jual_realisasi * $obat_tebus_item->jumlah;
                        $transaksi->save();
                    }
                }

                $stok_obat_asal->save();
            }           

            $resep->tebus = true;
            $resep->save();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'code' => '500',
                'message' => $e->getMessage()
            ], 500);
        }

        DB::commit();        
        return response ($obat_tebus, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien', 'obatTebusItem.stokObat','obatTebusItem.jenisObat','transaksiEksternal')->findOrFail($id);
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
        $obat_tebus = ObatTebus::findOrFail($id);
        $obat_tebus->id_transaksi = $request->input('id_transaksi');   
        $obat_tebus->id_resep = $request->input('id_resep');
        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?
        $obat_tebus->save();

        foreach ($request->input('obat_tebus_item') as $key => $value) {
            $obat_tebus_item = new ObatTebusItem;

            $obat_tebus_item->id_obat_tebus = $obat_tebus->id;
            $obat_tebus_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_tebus_item->id_stok_obat = $value['id_stok_obat'];
            $obat_tebus_item->jumlah = $value['jumlah'];
            $obat_tebus_item->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_tebus_item->keterangan = $value['keterangan'];
            $obat_tebus_item->asal = $value['asal'];
            $obat_tebus_item->id_resep_item = $value['id_resep_item'];
            $obat_tebus_item->id_racikan_item = $value['id_racikan_item'];            

            $stok_obat_asal = StokObat::findOrFail($obat_tebus_item->id_stok_obat);
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tebus_item->jumlah);

            $obat_tebus_item->save();
            $stok_obat_asal->save();
        }           

        return response ($obat_tebus, 200)
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
        $obat_tebus = ObatTebus::find($id);
        $obat_tebus->delete();
        return response ($id.' deleted', 200);
    }

    /* public function getTodayObatTebusByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus_items = ObatTebusItem::join('obat_tebus', 'obat_tebus.id', '=', 'obat_tebus_item.id_obat_tebus')
                                ->whereDate('obat_tebus.waktu_keluar', '=', date("Y-m-d"))
                                ->where('obat_tebus_item.id_stok_obat', $id_stok_obat)
                                ->select('obat_tebus_item.*','obat_tebus.waktu_keluar')
                                ->get();
        return response ($obat_tebus_items, 200)
                -> header('Content-Type', 'application/json');
    } */

    /*
        Get Obat Tebus with same Stok Obat ID within a time range
    */
    public function getObatTebusByTime(Request $request)
    {
        $waktu_mulai = new DateTime($request->waktu_mulai);
        $waktu_selesai = new DateTime($request->waktu_selesai);
        $id_stok_obat = $request->id_stok_obat;

        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus_items = ObatTebusItem::join('obat_tebus', 'obat_tebus.id', '=', 'obat_tebus_item.id_obat_tebus')
                                ->whereBetween('obat_tebus.waktu_keluar', array($waktu_mulai, $waktu_selesai))
                                ->where('obat_tebus_item.id_stok_obat', $id_stok_obat)                                
                                ->select('obat_tebus_item.*','obat_tebus.waktu_keluar')
                                ->get();
        return response ($obat_tebus_items, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export(Request $request) 
    {
        $tanggal_mulai = new DateTime($request->tanggal_mulai);
        $tanggal_selesai = new DateTime($request->tanggal_selesai);
        $tanggal_selesai->add(new DateInterval("P1D")); // Plus 1 day

        $all_obat_tebus_item = ObatTebusItem::join('obat_tebus', 'obat_tebus.id', '=', 'obat_tebus_item.id_obat_tebus')
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'obat_tebus_item.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_tebus_item.id_stok_obat')
                            ->whereBetween('obat_tebus.waktu_keluar', array($tanggal_mulai, $tanggal_selesai))
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_tebus.waktu_keluar', 
                                    'obat_tebus_item.jumlah',
                                    'jenis_obat.satuan', 
                                    'obat_tebus_item.harga_jual_realisasi')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu keluar', 'Jumlah', 'Satuan', 'Harga jual satuan'];

        foreach($all_obat_tebus_item as $obat_tebus_item) {
            $data[] = $obat_tebus_item->toArray();
        }

        return Excel::create('obat_tebus', function($excel) use ($data) {
            $excel->setTitle('Obat Tebus')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat tebus');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
