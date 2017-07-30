<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use App\ObatTebus;
use App\StokObat;
use App\ObatTebusItem;
use App\Resep;
use Excel;

class ObatTebusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien','obatTebusItem.stokObat','obatTebusItem.jenisObat')->get();
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

        $obat_tebus = new ObatTebus;
        $obat_tebus->id_resep = $request->input('id_resep');

        $resep = Resep::findOrFail($obat_tebus->id_resep);

        if ($request->input('id_transaksi')) {
            $obat_tebus->id_transaksi = $request->input('id_transaksi');               
        } else {
            $transaksi = new Transaksi;        
            $transaksi->kode_jenis_pasien = 1;
            $transaksi->asuransi_pasien = 'tunai';        
            $transaksi->harga_total = 0;
            $transaksi->jenis_rawat = 2;
            $transaksi->kelas_rawat = 3;
            $transaksi->status_naik_kelas = 0;
            $transaksi->status = 'open';
            $transaksi->save();

            $transaksi = Transaksi::findOrFail($transaksi->id);
            $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
            $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
            $transaksi->no_transaksi = 'INV' . $code_str;
            $transaksi->save();

            $obat_tebus->id_transaksi = $transaksi->id;  
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

            if ($obat_tebus_item->save()) {
                $transaksi = Transaksi::findOrFail($obat_tebus->id_transaksi);
                $transaksi->harga_total += $obat_tebus_item->harga_jual_realisasi * $obat_tebus_item->jumlah;
                $transaksi->save();
            }

            $stok_obat_asal->save();
        }           

        $resep->tebus = true;
        $resep->save();
        
        return response ($request->all(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ObatTebus::with('obatTebusItem','resep','transaksi.pasien', 'obatTebusItem.stokObat','obatTebusItem.jenisObat')->findOrFail($id);
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

    public function getTodayObatTebusByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_tebus_items = ObatTebusItem::join('obat_tebus', 'obat_tebus.id', '=', 'obat_tebus_item.id_obat_tebus')
                                ->whereDate('obat_tebus.waktu_keluar', '=', date("Y-m-d"))
                                ->where('obat_tebus_item.id_stok_obat', $id_stok_obat)
                                ->select('obat_tebus_item.*','obat_tebus.waktu_keluar')
                                ->get();
        return response ($obat_tebus_items, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export() 
    {
        $all_obat_tebus_item = ObatTebusItem::join('obat_tebus', 'obat_tebus.id', '=', 'obat_tebus_item.id_obat_tebus')
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'obat_tebus_item.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_tebus_item.id_stok_obat')
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
