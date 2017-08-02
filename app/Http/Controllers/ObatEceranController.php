<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ObatEceran;
use App\StokObat;
use App\ObatEceranItem;
use App\TransaksiEksternal;
use Excel;
use DateTime;
use DateInterval;

class ObatEceranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return ObatEceran::with('transaksiEksternal','obatEceranItem.stokObat','obatEceranItem.jenisObat')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obat_eceran = new ObatEceran;

        date_default_timezone_set('Asia/Jakarta');
        $obat_eceran->waktu_transaksi = date("Y-m-d H:i:s"); // Use default in DB instead?

        if ($request->input('id_transaksi')) {
            $obat_eceran->id_transaksi = $request->input('id_transaksi');               
        } else {
            $transaksi = new TransaksiEksternal;             
            $transaksi->harga_total = 0;
            $transaksi->status = 'open';
            $transaksi->nama = $request->input('nama');
            $transaksi->alamat = $request->input('alamat');
            $transaksi->no_telepon = $request->input('no_telepon');
            $transaksi->umur = $request->input('umur');
            $transaksi->save();

            $transaksi = TransaksiEksternal::findOrFail($transaksi->id);
            $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
            $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
            $transaksi->no_transaksi = 'EKS' . $code_str;
            $transaksi->save();

            $obat_eceran->id_transaksi = $transaksi->id;  
        }

        $obat_eceran->save();

        foreach ($request->input('obat_eceran_item') as $key => $value) {
            $obat_eceran_item = new ObatEceranItem;

            $obat_eceran_item->id_obat_eceran = $obat_eceran->id;
            $obat_eceran_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_eceran_item->id_stok_obat = $value['id_stok_obat'];
            $obat_eceran_item->jumlah = $value['jumlah'];
            $obat_eceran_item->harga_jual_realisasi = $value['harga_jual_realisasi'];

            $stok_obat_asal = StokObat::findOrFail($obat_eceran_item->id_stok_obat);
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_eceran_item->jumlah);    

            if ($obat_eceran_item->save()) {
                $transaksi = TransaksiEksternal::findOrFail($obat_eceran->id_transaksi);
                $transaksi->harga_total += $obat_eceran_item->harga_jual_realisasi * $obat_eceran_item->jumlah;
                $transaksi->save();
            }

            $stok_obat_asal->save();
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
        return ObatEceran::with('transaksiEksternal','obatEceranItem.obatMasuk','obatEceranItem.jenisObat')->findOrFail($id);
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
        $obat_eceran = ObatEceran::with('obatEceranItem')->findOrFail($id);

        $obat_eceran->nama_pembeli = $request->input('nama_pembeli');
        $obat_eceran->alamat = $request->input('alamat');

        date_default_timezone_set('Asia/Jakarta');
        $obat_eceran->waktu_transaksi = date("Y-m-d H:i:s"); // Use default in DB instead?

        $obat_eceran->save();

        foreach ($obat_eceran->obat_eceran_item as $key => $value) {
            $obat_eceran_item = new ObatEceranItem;

            $obat_eceran_item->id_obat_eceran = $value['id_obat_eceran'];
            $obat_eceran_item->id_jenis_obat = $value['id_jenis_obat'];
            $obat_eceran_item->id_stok_obat = $value['id_stok_obat'];
            $obat_eceran_item->jumlah = $value['jumlah'];
            $obat_eceran_item->harga_jual_realisasi = $value['harga_jual_realisasi'];  

            $stok_obat_asal = StokObat::findOrFail($obat_eceran_item->id_stok_obat);
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_eceran_item->jumlah);

            $obat_eceran_item->save();
            $stok_obat_asal->save();
        }   

        return response ($obat_eceran, 200)
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
        $obat_eceran = ObatEceran::find($id);
        $obat_eceran->delete();
        return response ($id.' deleted', 200);
    }

    public function getTodayObatEceranByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_eceran_items = ObatEceranItem::join('obat_eceran', 'obat_eceran.id', '=', 'obat_eceran_item.id_obat_eceran')
                                ->whereDate('obat_eceran.waktu_transaksi', '=', date("Y-m-d"))
                                ->where('obat_eceran_item.id_stok_obat', $id_stok_obat)
                                ->select('obat_eceran_item.*','obat_eceran.waktu_transaksi')
                                ->get();
        return response ($obat_eceran_items, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export(Request $request) 
    {
        $tanggal_mulai = new DateTime($request->tanggal_mulai);
        $tanggal_selesai = new DateTime($request->tanggal_selesai);
        $tanggal_selesai->add(new DateInterval("P1D")); // Plus 1 day

        $all_obat_eceran_item = ObatEceranItem::join('obat_eceran', 'obat_eceran.id', '=', 'obat_eceran_item.id_obat_eceran')
                            ->join('jenis_obat', 'jenis_obat.id', '=', 'obat_eceran_item.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_eceran_item.id_stok_obat')
                            ->whereBetween('obat_eceran.waktu_transaksi', array($tanggal_mulai, $tanggal_selesai))
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_eceran.waktu_transaksi', 
                                    'obat_eceran_item.jumlah',
                                    'jenis_obat.satuan', 
                                    'obat_eceran_item.harga_jual_realisasi')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu keluar', 'Jumlah', 'Satuan', 'Harga jual satuan'];

        foreach($all_obat_eceran_item as $obat_eceran_item) {
            $data[] = $obat_eceran_item->toArray();
        }

        return Excel::create('obat_eceran', function($excel) use ($data) {
            $excel->setTitle('Obat Eceran')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat eceran');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
