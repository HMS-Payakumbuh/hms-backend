<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AntrianFrontOffice;
use App\Pasien;
use App\RekamMedis;
use App\Poliklinik;
use App\Laboratorium;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Textmagic\Services\TextmagicRestClient;

class AntrianSMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return AntrianFrontOffice::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function parseMessage(Request $request)
    {
        $pieces = explode("_", $request->input('message'));

        $antrian_front_office = new AntrianFrontOffice;
        $antrian_front_office->jenis = 0;
        $antrian_front_office->kesempatan = 3;

        try {
            $pasien = Pasien::where('kode_pasien', '=', $pieces[0])->first();
            if ($pasien) 
                $antrian_front_office->nama_pasien = $pasien->nama_pasien;    
            else
                $antrian_front_office->nama_pasien = $pieces[0];

            if (substr($pieces[1], 0, 4) === 'Poli')
                $antrian_front_office->nama_layanan_poli = $pieces[1];
            else
                $antrian_front_office->nama_layanan_lab = $pieces[1];

            if ($antrian_front_office->nama_layanan_poli) {
                $layanan = Poliklinik::where('nama', '=', $antrian_front_office->nama_layanan_poli)->first();
                $antrian_front_office->kategori_antrian = $layanan->kategori_antrian;
            } else if ($antrian_front_office->nama_layanan_lab) {
                $layanan = Laboratorium::where('nama', '=', $antrian_front_office->nama_layanan_lab)->first();
                $antrian_front_office->kategori_antrian = $layanan->kategori_antrian;
            }

            if (count($pieces) > 2) {
                $rekam_medis = RekamMedis::where('id_pasien', '=', $pasien->id)->first();
                $tanggal_kontrol = Carbon::parse(json_decode($rekam_medis->rencana_penatalaksanaan)->tanggal);
                var_dump('Tanggal Kontrol : '.$tanggal_kontrol);
                var_dump('Tanggal Sekarang : '.Carbon::now());
                if (Carbon::parse(json_decode($rekam_medis->rencana_penatalaksanaan)->tanggal)->gt(Carbon::now()))
                    return response('Pendaftaran gagal. Maaf Anda belum dapat melakukan kontrol.', 500);
            }

            $antrian_front_office->save();
            Redis::publish('antrian', json_encode(['kategori_antrian' => $antrian_front_office->kategori_antrian]));

            if ($layanan) {
                $panjang_antrian = count(AntrianFrontOffice::where('kategori_antrian', '=', $layanan->kategori_antrian)->get());
                $minutes = $panjang_antrian * 5;
                $now = Carbon::now();
                $waktu_datang = 'Pendaftaran berhasil. Anda mendapat nomor antrian '.$antrian_front_office->kategori_antrian.$antrian_front_office->no_antrian.'. Datanglah sebelum Pukul '.$now->copy()->addMinutes($minutes)->toTimeString().'.';
            }
            
            return response($waktu_datang, 201);
        } catch (\Exception $e) {
            if ($e instanceof RestException) {
                print '[ERROR] ' . $e->getMessage() . "\n";
                foreach ($e->getErrors() as $key => $value) {
                    print '[' . $key . '] ' . implode(',', $value) . "\n";
                }
            } else {
                print '[ERROR] ' . $e->getMessage() . "\n";
            }
            return response($e, 500);
        } 
    }

    public function sendMessage($text, $phone) {
        //send message to user
        $client = new TextmagicRestClient('jessicaandjani', 'Z1HuSc1UIKQMgOfmGeFmtmAMMRH7GK');
        $result = ' ';
        try {
            $result = $client->messages->create(
                array(
                    'text' => $text,
                    'phones' => implode(', ', array($phone))
                )
            );
        } catch (\Exception $e) {
            if ($e instanceof RestException) {
                print '[ERROR] ' . $e->getMessage() . "\n";
                foreach ($e->getErrors() as $key => $value) {
                    print '[' . $key . '] ' . implode(',', $value) . "\n";
                }
            } else {
                print '[ERROR] ' . $e->getMessage() . "\n";
            }
            return;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $kategori_antrian
     * @return \Illuminate\Http\Response
     */
    public function show($kategori_antrian)
    {
        return AntrianFrontOffice::where('kategori_antrian', '=', $kategori_antrian)
          ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function update($nama_layanan, $no_antrian)
    {
        $antrian_front_office = AntrianFrontOffice::
            where([['no_antrian', '=', $no_antrian], ['nama_layanan_poli', '=', $nama_layanan]])
            ->orWhere([['no_antrian', '=', $no_antrian], ['nama_layanan_lab', '=', $nama_layanan]])
            ->first();
        $antrian_front_office->waktu_perubahan_antrian = Carbon::now();
        $antrian_front_office->kesempatan = $antrian_front_office->kesempatan - 1;
        $antrian_front_office->save();
        if ($antrian_front_office->kesempatan <= 0) {
            $antrian_front_office->delete();
        }
		return response($antrian_front_office, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $nama_layanan
     * @param  string  $no_antrian
     * @return \Illuminate\Http\Response
     */
    public function destroy($nama_layanan, $no_antrian)
    {
        $deletedRows = AntrianFrontOffice::
            where([['no_antrian', '=', $no_antrian], ['nama_layanan_poli', '=', $nama_layanan]])
            ->orWhere([['no_antrian', '=', $no_antrian], ['nama_layanan_lab', '=', $nama_layanan]])
              ->first()
              ->delete();
        return response('', 204);
    }
}
