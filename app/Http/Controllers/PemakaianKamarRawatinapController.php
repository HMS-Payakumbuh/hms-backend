<?php

namespace App\Http\Controllers;

use App\PemakaianKamarRawatinap;
use App\KamarRawatinap;
use App\TempatTidur;
use App\Transaksi;
use App\SettingBpjs;
use App\BpjsManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemakaianKamarRawatinapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, kamar_rawatinap.jenis_kamar, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, kamar_rawatinap.kelas, pemakaian_kamar_rawatinap.harga, pasien.nama_pasien, pemakaian_kamar_rawatinap.no_pegawai, tenaga_medis.nama, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function indexForDokterDashboard()
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.no_kamar, kamar_rawatinap.jenis_kamar, pemakaian_kamar_rawatinap.waktu_keluar, pemakaian_kamar_rawatinap.no_pegawai'))
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->groupBy('pemakaian_kamar_rawatinap.no_kamar', 'kamar_rawatinap.jenis_kamar', 'pemakaian_kamar_rawatinap.waktu_keluar' , 'pemakaian_kamar_rawatinap.no_pegawai')
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function getAllPemakaianKamarByNoPegawai($no_pegawai)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, pasien.nama_pasien, tenaga_medis.nama, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->where('tenaga_medis.no_pegawai', '=', $no_pegawai)
                            ->orderBy('pemakaian_kamar_rawatinap.no_kamar', 'asc')
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function getAllPemakaianKamarByNoKamar($no_kamar)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                             ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, kamar_rawatinap.jenis_kamar, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, pasien.nama_pasien, pemakaian_kamar_rawatinap.no_pegawai, tenaga_medis.nama, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '!=', null)
                            ->where('pemakaian_kamar_rawatinap.no_kamar', '=', $no_kamar)
                            ->orderBy('pemakaian_kamar_rawatinap.no_tempat_tidur', 'asc')
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function getAllPemakaianKamarBooked()
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.harga, pemakaian_kamar_rawatinap.tanggal_booking, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, kamar_rawatinap.kelas, pemakaian_kamar_rawatinap.nama_booking, pemakaian_kamar_rawatinap.kontak_booking, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '=', null)
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function getAllPemakaianKamarBookedByNoKamar($no_kamar)
    {
        date_default_timezone_set('Asia/Jakarta');
        $today = date("Y-m-d");
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, pemakaian_kamar_rawatinap.tanggal_booking, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.tanggal_booking', '=', $today)
                            ->where('pemakaian_kamar_rawatinap.no_kamar', '=', $no_kamar)
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    public function getAllPemakaianKamarBookedWithTanggal($tanggal, $no_kamar)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, pemakaian_kamar_rawatinap.tanggal_booking, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.tanggal_booking', '=', $tanggal)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '=', null)
                            ->where('pemakaian_kamar_rawatinap.no_kamar', '=', $no_kamar)
                            ->get();

        return $pemakaianKamarRawatinap;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pemakaianKamarRawatinap = new PemakaianKamarRawatinap;
        $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        $pemakaianKamarRawatinap->id_transaksi = $request->input('id_transaksi');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_masuk = date("Y-m-d H:i:s");
        $pemakaianKamarRawatinap->waktu_keluar = null;
        $pemakaianKamarRawatinap->harga = $request->input('harga');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->tanggal_booking = null;
        $pemakaianKamarRawatinap->save();

        $kamar = KamarRawatinap::findOrFail($pemakaianKamarRawatinap->no_kamar);
        $transaksi = Transaksi::findOrFail($pemakaianKamarRawatinap->id_transaksi);
        $transaksi->jenis_rawat = 1;
        $transaksi->kelas_rawat = $kamar->kelas;
        $transaksi->save();
        if ($transaksi->no_sep != null && $kamar->jenis_kamar != "ICU") {
            $settingBpjs = SettingBpjs::first();
            $coder_nik = $settingBpjs->coder_nik;
            $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
            $requestSet = array(
                'jenis_rawat' => $transaksi->jenis_rawat,
                'kelas_rawat' => $transaksi->kelas_rawat
            );
            $bpjs->setClaimData($requestSet);
        }

        return response($pemakaianKamarRawatinap, 201);
    }

    public function storeBooked(Request $request, $tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);

        $pemakaianKamarRawatinap = new PemakaianKamarRawatinap;
        $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        $pemakaianKamarRawatinap->id_transaksi = $request->input('id_transaksi');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_masuk = null;
        $pemakaianKamarRawatinap->waktu_keluar = null;
        $pemakaianKamarRawatinap->harga = $request->input('harga');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->nama_booking= $request->input('nama_booking');
        $pemakaianKamarRawatinap->kontak_booking= $request->input('kontak_booking');
        $pemakaianKamarRawatinap->tanggal_booking = $tanggal;
        $pemakaianKamarRawatinap->save();

        return response($pemakaianKamarRawatinap, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('transaksi', 'pemakaian_kamar_rawatinap.id_transaksi', '=', 'transaksi.id')
                            ->join('pasien', 'transaksi.id_pasien', '=', 'pasien.id')
                            ->join('tenaga_medis', 'pemakaian_kamar_rawatinap.no_pegawai', '=', 'tenaga_medis.no_pegawai')
                            ->join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('pemakaian_kamar_rawatinap.id, pemakaian_kamar_rawatinap.id_transaksi, kamar_rawatinap.jenis_kamar, pemakaian_kamar_rawatinap.no_pegawai, pemakaian_kamar_rawatinap.no_kamar, pemakaian_kamar_rawatinap.no_tempat_tidur, kamar_rawatinap.kelas, pasien.nama_pasien, tenaga_medis.nama, pemakaian_kamar_rawatinap.waktu_masuk, pemakaian_kamar_rawatinap.waktu_keluar'))
                            ->where('pemakaian_kamar_rawatinap.id', '=', $id)
                            ->first();

        return $pemakaianKamarRawatinap;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @param  integer $no_tempat_tidur
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $no_kamar, $no_tempat_tidur)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::with('kamar_rawatinap')->findOrFail($id);

        // $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        // $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        // $pemakaianKamarRawatinap->no_transaksi = $request->input('no_transaksi');
        // $pemakaianKamarRawatinap->no_pembayaran = $request->input('no_pembayaran');
        // $pemakaianKamarRawatinap->waktu_masuk = $request->input('waktu_masuk');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_keluar = date("Y-m-d H:i:s");
        // $pemakaianKamarRawatinap->harga = $request->input('harga');
        // $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        // $pemakaianKamarRawatinap->status = $request->input('status');

        $waktuMasuk = Carbon::parse($pemakaianKamarRawatinap->waktu_masuk);
        $waktuKeluar = Carbon::parse($pemakaianKamarRawatinap->waktu_keluar);

        if ($waktuMasuk->diffInHours($waktuKeluar) <= 2) {
            $pemakaianKamarRawatinap->delete();
        }
        else {
            $pemakaianKamarRawatinap->save();
        }

        $tempatTidur = TempatTidur::where('no_kamar', '=', $no_kamar)
        ->where('no_tempat_tidur', '=', $no_tempat_tidur)
        ->first();

        $tempatTidur->status = 1;
        $tempatTidur->save();

        $transaksi = Transaksi::with(['pasien', 'tindakan.daftarTindakan', 'obatTebus.obatTebusItem.jenisObat', 'obatTebus.resep', 'pemakaianKamarRawatInap.kamar_rawatinap', 'pembayaran'])
            ->findOrFail($pemakaianKamarRawatinap->id_transaksi);
        $transaksi->status = 'closed';
        $transaksi->save();

        if ($transaksi->status == 'closed' && isset($transaksi->no_sep)) {
            try {
                $coder_nik = SettingBpjs::first()->coder_nik;
                $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
                $response = json_decode($bpjs->group(1)->getBody(), true);

                $special_cmg = '';
                if ($response['metadata']['code'] == 200) {
                    if (isset($response['special_cmg_option'])) {
                        foreach ($response['special_cmg_option'] as $key => $value) {
                            if (substr($value['code'], 1) != 'D') {
                                $special_cmg = $special_cmg . "#" . $value['code'];
                            }
                            else {
                                $name = explode(" ", $value['description']);
                                foreach ($transaksi['obat_tebus']['obat_tebus_item'] as $key_obat => $obat) {
                                    if (strtolower($obat['jenis_obat']['nama_generik']) == strtolower($name[0])) {
                                        $special_cmg = $special_cmg . "#" . $value['code'];
                                    }
                                }
                            }
                        }
                    }
                    $bpjs->group(2, $special_cmg);
                    $bpjs->finalizeClaim();
                }
            }
            catch(Exception $e) {
                $transaksi->status = 'open';
                $transaksi->save();
            }
        }

        return response($pemakaianKamarRawatinap, 200);
    }

    public function masuk(Request $request, $id)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);

        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_masuk = date("Y-m-d H:i:s");
        $pemakaianKamarRawatinap->id_transaksi = $request->input('id_transaksi');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->save();

        return response($pemakaianKamarRawatinap, 200);
    }

    public function updatePerkiraanWaktuKeluar(Request $request, $id)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);


        if( $request->input('perkiraan_waktu_keluar') != null) {
            $pemakaianKamarRawatinap->perkiraan_waktu_keluar = $request->input('perkiraan_waktu_keluar');
            $pemakaianKamarRawatinap->save();
        }

        return response($pemakaianKamarRawatinap, 200);
    }

    public function tambahDurasiPemakaianVentilator(Request $request, $id)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);

        if($pemakaianKamarRawatinap->durasi_pemakaian_ventilator == null)
            $pemakaianKamarRawatinap->durasi_pemakaian_ventilator = (int)$request->input('durasi_pemakaian_ventilator');
        else
            $pemakaianKamarRawatinap->durasi_pemakaian_ventilator = (int)$pemakaianKamarRawatinap->durasi_pemakaian_ventilator + (int)$request->input('durasi_pemakaian_ventilator');
        $pemakaianKamarRawatinap->save();

        return response($pemakaianKamarRawatinap, 200);
    }

    public function pindahKamar(Request $request, $id)
    {
        $pindah = false;
        $pemakaianKamarSebelumnya = PemakaianKamarRawatinap::with('kamar_rawatinap')->findOrFail($id);
        date_default_timezone_set('Asia/Jakarta');

        $waktuMasuk = Carbon::parse($pemakaianKamarSebelumnya->waktu_masuk);
        $now = Carbon::now('Asia/Jakarta');

        if($waktuMasuk->diffInHours($now) > 2) {
            $pemakaianKamarSebelumnya->waktu_keluar = date("Y-m-d H:i:s");
            $pemakaianKamarSebelumnya->save();
            if ($pemakaianKamarSebelumnya->waktu_keluar != null) {
                $transaksi = Transaksi::findOrFail($pemakaianKamarSebelumnya->id_transaksi);
                $transaksi->harga_total += $pemakaianKamarSebelumnya->harga;
                $transaksi->save();

                $los = 1;
                if ($waktuMasuk->diffInDays($now) > 0) {
                    $los = $waktuMasuk->diffInDays($now);
                }

                $kamar = $pemakaianKamarSebelumnya->kamar_rawatinap;
                if ($transaksi->no_sep != null) {
                    $settingBpjs = SettingBpjs::first();
                    $coder_nik = $settingBpjs->coder_nik;
                    $bpjs =  new BpjsManager($transaksi->no_sep, $coder_nik);
                }

                if ($kamar->jenis_kamar == "ICU") {
                    if ($transaksi->no_sep != null) {
                        $currentData = json_decode($bpjs->getClaimData()->getBody(), true);
                        $currentIcuLos = $currentData['response']['data']['icu_los'];
                        $carbon = Carbon::parse($transaksi->waktu_masuk_pasien);

                        $requestSet = array(
                            'tgl_masuk' => $carbon->toDateTimeString(),
                            'tgl_pulang' => $now->toDateTimeString(),
                            'icu_indikator' => 1,
                            'icu_los' => $los + $currentIcuLos
                        );
                        $bpjs->setClaimData($requestSet);
                        $bpjs->group(1);
                    }
                }
                else {
                    if ($transaksi->status_naik_kelas == 1) {
                        if ($transaksi->no_sep != null) {
                            $kelas = "kelas_";
                            if ($kamar->kelas == "vip") {
                                $kelas = "vip";
                            }
                            else {
                                $kelas = $kelas . $kamar->kelas;
                            }

                            $currentData = json_decode($bpjs->getClaimData()->getBody(), true);
                            $currentUpgradeLos = $currentData['response']['data']['upgrade_class_los'];

                            $requestSet = array(
                                'tgl_pulang' => $now->toDateTimeString(),
                                'upgrade_class_ind' => $transaksi->status_naik_kelas,
                                'upgrade_class_class' => $kelas,
                                'upgrade_class_los' => $los + $currentUpgradeLos,
                                'add_payment_pct' => $settingBpjs->add_payment_pct
                            );
                            $bpjs->setClaimData($requestSet);
                            $bpjs->group(1);
                        }
                    }
                    else {
                        $pindah = true;
                    }
                }
            }
        }
        else {
            $pemakaianKamarSebelumnya->delete();
        }


         $tempatTidur = TempatTidur::where('no_kamar', '=', $pemakaianKamarSebelumnya->no_kamar)
         ->where('no_tempat_tidur', '=', $pemakaianKamarSebelumnya->no_tempat_tidur)
         ->first();
         $tempatTidur->status = 1;
         $tempatTidur->save();


        $pemakaianKamarRawatinap = new PemakaianKamarRawatinap;
        $pemakaianKamarRawatinap->no_kamar = $request->input('no_kamar');
        $pemakaianKamarRawatinap->no_tempat_tidur = $request->input('no_tempat_tidur');
        $pemakaianKamarRawatinap->id_transaksi = $request->input('id_transaksi');
        date_default_timezone_set('Asia/Jakarta');
        $pemakaianKamarRawatinap->waktu_masuk = date("Y-m-d H:i:s");
        $pemakaianKamarRawatinap->waktu_keluar = null;
        $pemakaianKamarRawatinap->harga = $request->input('harga');
        $pemakaianKamarRawatinap->no_pegawai= $request->input('no_pegawai');
        $pemakaianKamarRawatinap->save();

        if ($pindah) {
                $transaksi = Transaksi::findOrFail($pemakaianKamarRawatinap->id_transaksi);
                if ($transaksi->status_naik_kelas == 0) {
                    $transaksi->status_naik_kelas = 1;
                    $transaksi->save();
                }
        }

        return response('', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @param  integer $no_tempat_tidur
     * @param  integer  $no_transaksi
     * @param  datetime  $waktu_masuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $no_kamar, $no_tempat_tidur)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);

        if($pemakaianKamarRawatinap->waktu_keluar == null) {
            $tempatTidur = TempatTidur::where('no_kamar', '=', $no_kamar)
            ->where('no_tempat_tidur', '=', $no_tempat_tidur)
            ->first();

            $tempatTidur->status = 1;
            $tempatTidur->save();
        }

        $pemakaianKamarRawatinap->delete();

        return response('', 204);

    }

    public function destroyBooking($id)
    {
        $pemakaianKamarRawatinap = PemakaianKamarRawatinap::findOrFail($id);
        $pemakaianKamarRawatinap->delete();

        return response('', 204);
    }
}
