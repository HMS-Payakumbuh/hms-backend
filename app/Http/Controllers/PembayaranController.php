<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\BpjsManager;
use App\SettingBpjs;
use App\Pembayaran;
use App\Klaim;
use App\Transaksi;
use App\TransaksiEksternal;
use App\Asuransi;
use App\Tindakan;
use App\ObatTebusItem;
use App\ObatEceranItem;
use App\PemakaianKamarRawatInap;
use App\PemakaianKamarJenazah;
use Excel;
use DateTime;
use DateInterval;

class PembayaranController extends Controller
{
    private function getPembayaran($id = null)
    {
        if (isset($id)) {
            return Pembayaran::with(['transaksi.pasien', 'transaksi.obatTebus.resep', 'transaksi.obatEceran', 'tindakan.daftarTindakan', 'klaim', 'obatTebusItem.jenisObat', 'obatEceranItem.jenisObat', 'pemakaianKamarRawatInap.kamar_rawatinap'])->findOrFail($id);
        } else {
            return Pembayaran::with(['transaksi.pasien', 'transaksi.obatTebus.resep', 'transaksi.obatEceran'])->get();
        }
    }

    public function export(Request $request)
    {
        if ($request->input('tanggal_awal') !== null && $request->input('tanggal_akhir') !== null) {
            $tanggal_awal = new DateTime($request->input('tanggal_awal'));
            $tanggal_akhir = new DateTime($request->input('tanggal_akhir'));
            $tanggal_akhir->add(new DateInterval("P1D")); // Plus 1 day

            $all_pembayaran = Pembayaran::with(['transaksi.pasien'])
                ->whereBetween('created_at', array($tanggal_awal, $tanggal_akhir))
                ->get();

            $data = array(
                array('Waktu Pembayaran', 'Nama Pasien', 'Kode Pasien', 'Nomor Pembayaran', 'Total Pembayaran', 'Metode Pembayaran')
            );

            $total_pembayaran = 0;
            foreach ($all_pembayaran as $pembayaran) {
                if (isset($pembayaran->transaksi)) {
                    $total_pembayaran += $pembayaran->harga_bayar;

                    $pembayaran_array = array(
                        $pembayaran->created_at,
                        $pembayaran->transaksi->pasien->nama_pasien,
                        $pembayaran->transaksi->pasien->kode_pasien,
                        $pembayaran->no_pembayaran,
                        $pembayaran->harga_bayar,
                        $pembayaran->metode_bayar
                    );

                    array_push($data, $pembayaran_array);
                }
            }

            $total_array = array('Total', '', '', '', $total_pembayaran);
            array_push($data, $total_array);

            $tanggal_awal = $tanggal_awal->format('Y/m/d');
            $tanggal_akhir = $tanggal_akhir->format('Y/m/d');
            $title = "Data Pembayaran ".$tanggal_awal." - ".$tanggal_akhir;
            return Excel::create($title, function($excel) use ($data) {
                $excel->setTitle('Data Pembayaran')
                        ->setCreator('user')
                        ->setCompany('RSUD Payakumbuh')
                        ->setDescription('Data Pembayaran');
                $excel->sheet('Sheet1', function($sheet) use ($data) {
                    $sheet->fromArray($data);
                });
            })->download('xls');
        }

        return response()->json([
            'code' => '500',
            'message' => 'Malformed Request'
        ], 500);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'allPembayaran' => $this->getPembayaran()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->input('pembayaran');
        $pembayaran = new Pembayaran;
        if ($payload['id_transaksi'] != 0) {
            $pembayaran->id_transaksi = $payload['id_transaksi'];
        }
        else {
            $pembayaran->id_transaksi_eksternal = $payload['id_transaksi_eksternal'];
        }
        $pembayaran->harga_bayar = $payload['harga_bayar'];
        $pembayaran->metode_bayar = $payload['metode_bayar'];
        $pembayaran->pembayaran_tambahan = $payload['pembayaran_tambahan'];
        $pembayaran->save();

        $pembayaran = Pembayaran::findOrFail($pembayaran->id);
        $code_str = strtoupper(base_convert($pembayaran->id, 10, 36));
        $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
        $pembayaran->no_pembayaran = 'PMB' . $code_str;
        $pembayaran->save();

        if ($pembayaran->pembayaran_tambahan == 1) {
            if ($pembayaran->id_transaksi != null) {
                $kamarRawatInap = PemakaianKamarRawatInap::where('id_transaksi', '=', $pembayaran->id_transaksi)
                    ->where('waktu_keluar', '=', null)
                    ->first();

                if ($kamarRawatInap != null) {
                    if ($kamarRawatInap->waktu_keluar == null) {
                        date_default_timezone_set('Asia/Jakarta');
                        $kamarRawatInap->waktu_keluar = date("Y-m-d H:i:s");

                        $kamarBaru = new PemakaianKamarRawatInap;
                        $kamarBaru->no_kamar = $kamarRawatInap->no_kamar;
                        $kamarBaru->no_tempat_tidur = $kamarRawatInap->no_tempat_tidur;
                        $kamarBaru->id_transaksi = $kamarRawatInap->id_transaksi;
                        $kamarBaru->waktu_masuk = date("Y-m-d H:i:s");
                        $kamarBaru->waktu_keluar = null;
                        $kamarBaru->harga = $kamarRawatInap->harga; 
                        $kamarBaru->no_pegawai = $kamarRawatInap->no_pegawai;
                        $kamarBaru->tanggal_booking = null;
                        $kamarBaru->save();

                        $waktu_masuk = Carbon::parse($kamarRawatInap->waktu_masuk);
                        $waktu_keluar = Carbon::parse($kamarRawatInap->waktu_keluar);
                        $los = $waktu_masuk->diffInDays($waktu_keluar);

                        $transaksi = Transaksi::findOrFail($kamarRawatInap->id_transaksi);
                        $transaksi->harga_total += $los * $kamarRawatInap->kamar_rawatinap->harga_per_hari;
                        $transaksi->save();
                    }
                    $kamarRawatInap->save();
                }
            }
        }
        else {
            if (isset($payload['tindakan']) && count($payload['tindakan']) > 0) {
                $arrTindakan = $payload['tindakan'];
                foreach ($arrTindakan as $value) {
                    $tindakan = Tindakan::findOrFail($value);
                    $tindakan->id_pembayaran = $pembayaran->id;
                    $tindakan->save();
                }
            }

            if (isset($payload['obatTebus']) && count($payload['obatTebus']) > 0) {
                $arrObatTebus = $payload['obatTebus'];
                foreach ($arrObatTebus as $value) {
                    $obatTebus = ObatTebusItem::findOrFail($value);
                    $obatTebus->id_pembayaran = $pembayaran->id;
                    $obatTebus->save();
                }
            }

            if (isset($payload['obatEceran']) && count($payload['obatEceran']) > 0) {
                $arrObatEceran = $payload['obatEceran'];
                foreach ($arrObatEceran as $value) {
                    $obatEceran = ObatEceranItem::findOrFail($value);
                    $obatEceran->id_pembayaran = $pembayaran->id;
                    $obatEceran->save();
                }
            }

            if (isset($payload['kamarJenazah']) && count($payload['kamarJenazah']) > 0) {
                $arrKamarJenazah = $payload['kamarJenazah'];
                foreach ($arrKamarJenazah as $value) {
                    $kamarJenazah = PemakaianKamarJenazah::findOrFail($value);
                    $kamarJenazah->no_pembayaran = $pembayaran->id;
                    $kamarJenazah->save();
                }
            }

            if (isset($payload['kamarRawatInap']) && count($payload['kamarRawatInap']) > 0) {
                $arrKamarRawatInap = $payload['kamarRawatInap'];
                foreach ($arrKamarRawatInap as $value) {
                    $kamarRawatInap = PemakaianKamarRawatInap::findOrFail($value);
                    $kamarRawatInap->id_pembayaran = $pembayaran->id;

                    if ($kamarRawatInap->waktu_keluar == null) {
                        date_default_timezone_set('Asia/Jakarta');
                        $kamarRawatInap->waktu_keluar = date("Y-m-d H:i:s");

                        $kamarBaru = new PemakaianKamarRawatInap;
                        $kamarBaru->no_kamar = $kamarRawatInap->no_kamar;
                        $kamarBaru->no_tempat_tidur = $kamarRawatInap->no_tempat_tidur;
                        $kamarBaru->id_transaksi = $kamarRawatInap->id_transaksi;
                        $kamarBaru->waktu_masuk = date("Y-m-d H:i:s");
                        $kamarBaru->waktu_keluar = null;
                        $kamarBaru->harga = $kamarRawatInap->harga; 
                        $kamarBaru->no_pegawai = $kamarRawatInap->no_pegawai;
                        $kamarBaru->tanggal_booking = null;
                        $kamarBaru->save();

                        $waktu_masuk = Carbon::parse($kamarRawatInap->waktu_masuk);
                        $waktu_keluar = Carbon::parse($kamarRawatInap->waktu_keluar);
                        $los = $waktu_masuk->diffInDays($waktu_keluar);

                        $transaksi = Transaksi::findOrFail($kamarRawatInap->id_transaksi);
                        $transaksi->harga_total += $los * $kamarRawatInap->kamar_rawatinap->harga_per_hari;
                        $transaksi->save();
                    }
                    $kamarRawatInap->save();
                }
            }
        }

        if ($pembayaran->metode_bayar != 'tunai') {
            $transaksi = Transaksi::findOrFail($pembayaran->id_transaksi);
            $asuransi = DB::table('asuransi')->select('id')->where([
                ['nama_asuransi', '=', $pembayaran->metode_bayar],
                ['id_pasien', '=', $transaksi->id_pasien]
            ])->first();

            $klaim = new Klaim;
            $klaim->id_pembayaran = $pembayaran->id;
            $klaim->id_asuransi = $asuransi->id;
            $klaim->status = 'processed';
            $klaim->save();

            if ($pembayaran->metode_bayar == 'bpjs') {
                $settingBpjs = SettingBpjs::first();
                $coder_nik = $settingBpjs->coder_nik;
                $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);

                // $bpjs->group(1);
                // $dataKlaim = json_decode($bpjs->getClaimData()->getBody(), true);
                // $tarif = $dataKlaim['response']['data']['grouper']['response']['cbg']['tariff'];
                // if (isset($dataKlaim['response']['data']['grouper']['response']['special_cmg'])) {
                //     foreach ($dataKlaim['response']['data']['grouper']['response']['special_cmg'] as $cmg) {
                //         $tarif += $cmg['tariff'];
                //     }
                // }
                // $klaim->tarif = $tarif;
                // $klaim->save();
            }
        }

        if ($payload['id_transaksi'] == 0) {
            $transaksiEksternal = TransaksiEksternal::findOrFail($pembayaran->id_transaksi_eksternal);
            $transaksiEksternal->status = 'closed';
            $transaksiEksternal->save();
        }

        return response()->json([
            'pembayaran' => $pembayaran
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'pembayaran' => $this->getPembayaran($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $payload = $request->input('pembayaran');
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->harga_bayar = $payload['harga_bayar'];
        $pembayaran->metode_bayar = $payload['metode_bayar'];
        $pembayaran->save();

        return response()->json([
            'pembayaran' => $pembayaran
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pembayaran::destroy($id);
    }
}
