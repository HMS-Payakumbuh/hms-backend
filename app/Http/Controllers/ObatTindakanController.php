<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ObatTindakan;
use App\StokObat;
use Excel;
use DateTime;
use DateInterval;

class ObatTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ObatTindakan::with('obatMasuk','jenisObat','lokasiAsal')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            $obat_tindakan = new ObatTindakan;

            $obat_tindakan->id_jenis_obat = $value['id_jenis_obat'];
            $obat_tindakan->id_stok_obat = $value['id_stok_obat'];

            date_default_timezone_set('Asia/Jakarta');
            $obat_tindakan->waktu_keluar = date("Y-m-d H:i:s"); // Use default in DB instead?

            $obat_tindakan->jumlah = $value['jumlah'];
            $obat_tindakan->keterangan = $value['keterangan'];
            $obat_tindakan->asal = $value['asal'];
            $obat_tindakan->harga_jual_realisasi = $value['harga_jual_realisasi'];
            $obat_tindakan->id_transaksi = $value['id_transaksi'];
            $obat_tindakan->id_tindakan = $value['id_tindakan'];

            $obat_tindakan->save();

            $stok_obat_asal = StokObat::firstOrFail($obat_tindakan->id_stok_obat);
            $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tindakan->jumlah);
            $stok_obat_asal->save();
        }
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
        return ObatTindakan::with('stokObat','jenisObat','lokasiAsal')->findOrFail($id);
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
        $obat_tindakan = ObatTindakan::findOrFail($id);

        $obat_tindakan->id_jenis_obat = $value['id_jenis_obat'];
        $obat_tindakan->id_stok_obat = $value['id_stok_obat'];
        $obat_tindakan->jumlah = $value['jumlah'];
        $obat_tindakan->keterangan = $value['keterangan'];
        $obat_tindakan->asal = $value['asal'];
        $obat_tindakan->harga_jual_realisasi = $value['harga_jual_realisasi'];
        $obat_tindakan->id_transaksi = $value['id_transaksi'];
        $obat_tindakan->id_tindakan = $value['id_tindakan'];
        $obat_tindakan->save();

        $stok_obat_asal = StokObat::findOrFail($obat_tindakan->id_stok_obat);
        $stok_obat_asal->jumlah = ($stok_obat_asal->jumlah) - ($obat_tindakan->jumlah);
        $stok_obat_asal->save();

        return response ($obat_tindakan, 200)
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
        $obat_tindakan = ObatTindakan::find($id);
        $obat_tindakan->delete();
        return response ($id.' deleted', 200);
    }

    public function getTodayObatTindakanByStok($id_stok_obat)
    {
        date_default_timezone_set('Asia/Jakarta');
        $obat_tindakan = ObatTindakan::whereDate('waktu_keluar', '=', date("Y-m-d"))
                                ->where('id_stok_obat', $id_stok_obat)
                                ->get();
        return response ($obat_tindakan, 200)
                -> header('Content-Type', 'application/json');
    }

    public function export(Request $request) 
    {
        $tanggal_mulai = new DateTime($request->tanggal_mulai);
        $tanggal_selesai = new DateTime($request->tanggal_selesai);
        $tanggal_selesai->add(new DateInterval("P1D")); // Plus 1 day

        $all_obat_tindakan = ObatTindakan::join('jenis_obat', 'jenis_obat.id', '=', 'obat_tindakan.id_jenis_obat')
                            ->join('stok_obat', 'stok_obat.id', '=', 'obat_tindakan.id_stok_obat')
                            ->join('lokasi_obat', 'lokasi_obat.id', '=', 'obat_tindakan.asal')                           
                            ->whereBetween('obat_tindakan.waktu_keluar', array($tanggal_mulai, $tanggal_selesai))
                            ->select('jenis_obat.merek_obat',
                                    'jenis_obat.nama_generik',
                                    'jenis_obat.pembuat',
                                    'jenis_obat.golongan',
                                    'stok_obat.nomor_batch',
                                    'stok_obat.kadaluarsa',
                                    'stok_obat.barcode',
                                    'obat_tindakan.waktu_keluar', 
                                    'obat_tindakan.jumlah',
                                    'jenis_obat.satuan', 
                                    'lokasi_obat.nama',
                                    'obat_tindakan.keterangan')
                            ->get();

        $data = [];
        $data[] = ['Merek obat', 'Nama generik', 'Pembuat', 'Golongan', 'No. batch', 'Kadaluarsa', 'Kode obat', 'Waktu keluar', 'Jumlah', 'Satuan', 'Lokasi asal', 'Keterangan'];

        foreach($all_obat_tindakan as $obat_tindakan) {
            $data[] = $obat_tindakan->toArray();
        }

        return Excel::create('obat_tindakan', function($excel) use ($data) {
            $excel->setTitle('Obat Tindakan')
                    ->setCreator('user')
                    ->setCompany('RSUD Payakumbuh')
                    ->setDescription('Daftar obat tindakan');
            $excel->sheet('Sheet1', function($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download('xls');
    }
}
