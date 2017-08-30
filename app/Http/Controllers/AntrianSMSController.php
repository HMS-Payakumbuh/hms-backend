<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AntrianFrontOffice;
use App\Pasien;
use App\RekamMedis;
use App\Poliklinik;
use App\Laboratorium;
use App\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Log;

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

    public function sendMessage($text, $phone) {
        //send message to user
       Redis::publish('sms', json_encode(['text' => $text, 'sender_phone' => $phone]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function parseMessage(Request $request)
    {
        $inbound_id = $request->id;
        $sender_phone = $request->sender;
        $receiver_phone = $request->receiver;
        $message_time = $request->messageTime;
        $message = $request->text;

        Log::info("Receive Message");
        Log::info($sender_phone);
        Log::info($receiver_phone);
        Log::info($message_time);
        Log::info($message);
        try {
            $pieces = explode("_", $message);

            if (count($pieces) > 1) {
              $all_antrian = AntrianFrontOffice::all();
              if (!empty($all_antrian[0])) {
                  if ($all_antrian[0]->waktu_masuk_antrian < Carbon::today()->toDateTimeString()) {
                      AntrianFrontOffice::truncate();
                  }
              }

              $antrian_front_office = new AntrianFrontOffice;
              $antrian_front_office->jenis = 0;
              $antrian_front_office->status = 0;
              $antrian_front_office->kesempatan = 5;
              $antrian_front_office->via_sms = true;

              $pasien = Pasien::with('catatan_kematian')->where('kode_pasien', '=', $pieces[0])->first();
              if ($pasien) {
                if ($pasien->catatan_kematian) {
                  $text = '[PAYAKUMBUH] Pendaftaran gagal. Pasien yang didaftarkan sudah meninggal.';
                  Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                  self::sendMessage($text, $sender_phone);
                  return response($text, 500);
                }

                $antrian_front_office->nama_pasien = $pasien->nama_pasien;
                $antrian_front_office->kode_pasien = $pieces[0];
                $antrian_exist = AntrianFrontOffice::where('kode_pasien', '=', $pieces[0])
                                                  ->first();
                if ($antrian_exist) {
                  $text = '[PAYAKUMBUH] Pendaftaran gagal. Kode pasien yang dimasukkan sudah dipakai.';
                  Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                  self::sendMessage($text, $sender_phone);
                  return response($text, 500);
                }

                $transaksi_exist = Transaksi::where('id_pasien', '=', $pasien->id)
                                            ->where('status', '=', 'open')
                                            ->first();
                if ($transaksi_exist) {
                  $text = '[PAYAKUMBUH] Pendaftaran gagal. Anda masih memiliki transaksi yang belum selesai. Tuntaskan pembayaran sebelum Anda dapat mendaftar.';
                  Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                  self::sendMessage($text, $sender_phone);
                  return response($text, 500);
                }                            
              }
              else {
                $text = '[PAYAKUMBUH] Pendaftaran gagal. Kode pasien yang dimasukkan tidak terdaftar.';
                Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                self::sendMessage($text, $sender_phone);
                return response($text, 500);
              }

              $all_antrian = AntrianFrontOffice::where('kategori_antrian', '=', $request->input('kategori_antrian'))
                                                ->get();
              if (!empty($all_antrian[0])) {
                  $antrian_front_office->no_antrian = $all_antrian[count($all_antrian) - 1]->no_antrian + 1;
              } else {
                  $antrian_front_office->no_antrian = 1;
              }

              if (substr($pieces[1], 0, 4) === 'Poli')
                  $antrian_front_office->nama_layanan_poli = $pieces[1];
              else
                  $antrian_front_office->nama_layanan_lab = $pieces[1];

              if ($antrian_front_office->nama_layanan_poli) {
                  $layanan = Poliklinik::where('nama', '=', $antrian_front_office->nama_layanan_poli)->first();
                  if ($layanan) {
                    $antrian_front_office->kategori_antrian = $layanan->kategori_antrian;
                    if ($layanan->sisa_pelayanan <= 0) {
                      $text = '[PAYAKUMBUH] Pendaftaran gagal. Maaf, layanan yang Anda tuju sudah habis.';
                      Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                      self::sendMessage($text, $sender_phone);
                      return response($text, 500);
                    }
                  }
              } else if ($antrian_front_office->nama_layanan_lab) {
                  $layanan = Laboratorium::where('nama', '=', $antrian_front_office->nama_layanan_lab)->first();
                  $antrian_front_office->kategori_antrian = $layanan->kategori_antrian;
              }

              if ($layanan == null) {
                $text = '[PAYAKUMBUH] Pendaftaran gagal. Maaf, layanan yang Anda pilih tidak terdaftar.';
                Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                self::sendMessage($text, $sender_phone);
                return response($text, 500);
              }

              if (count($pieces) > 2) {
                  $pieces[2] = strtolower($pieces[2]);
                  $rekam_medis = RekamMedis::where('id_pasien', '=', $pasien->id)->first();
                  if ($rekam_medis && ($pieces[2] === 'kontrol' || $pieces[2] === 'k')) {
                    $tanggal_kontrol = Carbon::parse(json_decode($rekam_medis->rencana_penatalaksanaan)->tanggal);
                    if (Carbon::parse(json_decode($rekam_medis->rencana_penatalaksanaan)->tanggal)->gt(Carbon::now())) {
                      $text = '[PAYAKUMBUH] Pendaftaran gagal. Maaf, Anda belum dapat melakukan kontrol.';
                      Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
                      self::sendMessage($text, $sender_phone);
                      return response($text, 500);
                    }
                  }
              }

              $antrian_front_office->save();
              Redis::publish('antrian', json_encode(['kategori_antrian' => $antrian_front_office->kategori_antrian]));

              $panjang_antrian = count(AntrianFrontOffice::where('kategori_antrian', '=', $layanan->kategori_antrian)->get());
              $minutes = $panjang_antrian * 5;
              $text = '[PAYAKUMBUH] Pendaftaran berhasil. Anda mendapat nomor antrian '.$antrian_front_office->kategori_antrian.$antrian_front_office->no_antrian.'. Datanglah antara Pukul '.Carbon::parse($antrian_front_office->waktu_masuk_antrian->addMinutes($minutes - 15)->toTimeString())->format('H:i').' - '.Carbon::parse($antrian_front_office->waktu_masuk_antrian->addMinutes($minutes)->toTimeString())->format('H:i').'.';
              $antrian_front_office->waktu_perjanjian = Carbon::parse($antrian_front_office->waktu_masuk_antrian->addMinutes($minutes - 15)->toTimeString());
              $antrian_front_office->save();

              Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
              self::sendMessage($text, $sender_phone);
              return response($text, 201);
            } else {
              $text = '[PAYAKUMBUH] Pendaftaran gagal. Format SMS Anda salah. Silakan kirim ulang SMS Anda dengan format yang benar.';
              Log::info('Mengirim SMS ke nomor '.$sender_phone.' dengan pesan : '.$text);
              self::sendMessage($text, $sender_phone);
              return response($text, 500);
            }
        } catch (\Exception $e) {
            if ($e instanceof RestException) {
                print '[ERROR] ' . $e->getMessage() . "\n";
                foreach ($e->getErrors() as $key => $value) {
                    print '[' . $key . '] ' . implode(',', $value) . "\n";
                }
            } else {
                print '[ERROR] ' . $e->getMessage() . "\n";
            }
            self::sendMessage('[PAYAKUMBUH] Pendaftaran gagal. Format SMS Anda salah. Silakan kirim ulang SMS Anda dengan format yang benar.', $sender_phone);
            return response($e, 500);
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
