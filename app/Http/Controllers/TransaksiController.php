<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Input;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Transaksi;
use App\Asuransi;
use App\Pasien;
use App\BpjsManager;
use App\SettingBpjs;

class TransaksiController extends Controller
{
    private function getTransaksi($id = null, $field = null, $kode_pasien = null)
    {
        if (isset($id)) {
          if (isset($field)) {
            if ($field == 'kode_pasien') {
              return Transaksi::with('pasien')
                ->whereHas('pasien', function ($query) use ($id) {
                  $query->where('kode_pasien', '=', $id);
                })
                ->where('status', '=', 'open')
                ->orderBy('transaksi.waktu_masuk_pasien', 'desc')
                ->get();
            }
            else {
              return response('', 500);
            }
          }
          else {
            return Transaksi::with(['pasien', 'tindakan.daftarTindakan', 'pembayaran', 'obatTebus.obatTebusItem.jenisObat', 'obatTebus.resep', 'obatEceran.obatEceranItem.jenisObat', 'pemakaianKamarRawatInap.kamar_rawatinap'])->findOrFail($id);
          }
        }
        else {
            if (isset($kode_pasien) && isset($field)) {
                return Transaksi::with(['pasien', 'obatTebus.resep', 'obatEceran'])
                    ->whereHas('pasien', function ($query) use ($kode_pasien) {
                      $query->where('kode_pasien', '=', $kode_pasien);
                    })
                    ->where('status', '=', $field)
                    ->get();
            }
            else {
                if (isset($kode_pasien)) {
                    return Transaksi::with(['pasien', 'obatTebus.resep', 'obatEceran'])
                        ->whereHas('pasien', function ($query) use ($kode_pasien) {
                          $query->where('kode_pasien', '=', $kode_pasien);
                        })
                        ->get();
                }

                if (isset($field)) {
                    return Transaksi::with(['pasien', 'obatTebus.resep', 'obatEceran'])
                        ->where('status', '=', $field)
                        ->get();
                }

                return Transaksi::with(['pasien', 'obatTebus.resep', 'obatEceran'])
                    ->get();
            }
        }
    }

    public function getRecentTransaksi($nama_pasien)
    {
        $transaksi = Transaksi
                            ::join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->orderBy('transaksi.waktu_masuk_pasien', 'desc')
                            ->where('nama_pasien', '=', $nama_pasien)
                            ->select(DB::raw('transaksi.*'))
                            ->get();
        return $transaksi;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->input('status');
        $kode_pasien = $request->input('kode_pasien');
        return response()->json([
            'allTransaksi' => $this->getTransaksi(null, $status, $kode_pasien)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = $request->input('transaksi');
        $transaksi = new Transaksi;
        $transaksi->id_pasien = $payload['id_pasien'];

        $transaksiLama = Transaksi::where('id_pasien', '=', $transaksi->id_pasien)
            ->where('status', '=', 'open')
            ->first();

        if ($transaksiLama != null) {
            $transaksiLama->status = 'closed';
            $transaksiLama->save();
        }

        $transaksi->kode_jenis_pasien = $payload['kode_jenis_pasien']; //1: pasien umum, 2: pasien asuransi

        if ($transaksi->kode_jenis_pasien == 2) {
            $transaksi->asuransi_pasien = $payload['asuransi_pasien'];
        }
        else {
            $transaksi->asuransi_pasien = 'tunai';
        }

        $transaksi->harga_total = 0;
        $transaksi->jenis_rawat = $payload['jenis_rawat']; //1: rawat inap, 2: rawat jalan

        if ($transaksi->jenis_rawat == 2) {
            $transaksi->kelas_rawat = 3;
        }
        else {
            $transaksi->kelas_rawat = $payload['kelas_rawat']; //kelas perawatan saat pasien mendaftar
        }
        $transaksi->status_naik_kelas = 0; //0: pasien tidak naik kelas, 1: pasien naik kelas
        $transaksi->status = 'open'; //status transaksi (open/closed)
        $transaksi->save();

        $newClaimResponse = '';
        $setClaimResponse = '';
        if (isset($payload['no_sep']) && $transaksi->kode_jenis_pasien == 2 && $transaksi->asuransi_pasien
             == 'bpjs') {
            $transaksi->no_sep = $payload['no_sep'];
            $transaksi->save();

            $settingBpjs = SettingBpjs::first();
            $coder_nik = $settingBpjs->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);

            $asuransi = Asuransi::where('id_pasien', $transaksi->id_pasien)->where('nama_asuransi', 'bpjs')->first();
            $pasien = Pasien::findOrFail($transaksi->id_pasien);
            $requestNew = array(
                'nomor_kartu' => $asuransi->no_kartu,
                'nomor_rm' => $asuransi->id_pasien,
                'nama_pasien' => $pasien->nama_pasien,
                'tgl_lahir' => $pasien->tanggal_lahir,
                'gender' => $pasien->jender
            );

            $newClaimResponse = $bpjs->newClaim($requestNew);

            $carbon = Carbon::instance($transaksi->waktu_masuk_pasien);
            $requestSet = array(
                'nomor_kartu' => $asuransi->no_kartu,
                'tgl_masuk' => $carbon->toDateTimeString(),
                'jenis_rawat' => $transaksi->jenis_rawat,
                'kelas_rawat' => $transaksi->kelas_rawat,
                'upgrade_class_ind' => $transaksi->status_naik_kelas,
                'tarif_rs' => $settingBpjs->tarif_rs,
                'kode_tarif' => $settingBpjs->kd_tarif_rs,
                'nama_dokter' => 'RUDY, DR',
                'payor_id' => 3,
                'payor_cd' => 'JKN'
            );
            $setClaimResponse = $bpjs->setClaimData($requestSet);
            $setClaimResponse = "Set Claim";
        }

        $transaksi = Transaksi::findOrFail($transaksi->id);
        $code_str = strtoupper(base_convert($transaksi->id, 10, 36));
        $code_str = str_pad($code_str, 8, '0', STR_PAD_LEFT);
        $transaksi->no_transaksi = 'INV' . $code_str;
        $transaksi->save();

        return response()->json([
            'transaksi' => $transaksi,
            'new_claim' => $newClaimResponse,
            'set_claim' => $setClaimResponse
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $field = null)
    {
        return response()->json([
          'transaksi' => $this->getTransaksi($id, $field)
        ]);
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
        $payload = $request->input('transaksi');
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update($payload);

        if ($transaksi->status == 'closed' && isset($transaksi->no_sep)) {
            $coder_nik = SettingBpjs::first()->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
            $bpjs->finalizeClaim();
        }

        return response()->json([
            'transaksi' => $transaksi
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
        Transaksi::destroy($id);
    }

    public function searchByPasien(Request $request)
    {
        $transaksi = Transaksi::where('id_pasien', $request->input('id_pasien'))
                                ->get();
        return response ($transaksi, 200)
                -> header('Content-Type', 'application/json');
    }

    public function getLatestOpenTransaksi($id_pasien)
    {
        $transaksi = Transaksi::where('id_pasien', $id_pasien)
                            ->where('status', '=', 'open')
                            ->orderBy('transaksi.waktu_masuk_pasien', 'desc')
                            ->firstOrFail();
        return response ($transaksi, 200)
                -> header('Content-Type', 'application/json');
    }

    public function getStatusBpjs($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $status_bpjs = null;
        if ($transaksi->no_sep != null) {
            $coder_nik = SettingBpjs::first()->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
            $currentData = json_decode($bpjs->getClaimData()->getBody(), true);
            $status_bpjs = $currentData['response']['data'];
        }
        return response()->json([
            'status_bpjs' => $status_bpjs
        ], 200);
    }
}
