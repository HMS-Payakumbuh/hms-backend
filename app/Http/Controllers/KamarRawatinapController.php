<?php

namespace App\Http\Controllers;

use App\KamarRawatinap;
use App\PemakaianKamarRawatinap;
use App\BookingKamar;
use App\TempatTidur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KamarRawatinapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $temp = KamarRawatinap
                ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                ->select(DB::raw('kamar_rawatinap.no_kamar, count(*) as kapasitas_kamar'))
                ->groupBy('kamar_rawatinap.no_kamar')
                ->orderBy('kamar_rawatinap.no_kamar')
                ->get();

        $kamarRawatinap = KamarRawatinap
                            ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.no_kamar, kamar_rawatinap.kelas, kamar_rawatinap.jenis_kamar, kamar_rawatinap.harga_per_hari, count(*) as available_kamar'))
                            ->where('status', '=', 1)
                            ->groupBy('kamar_rawatinap.no_kamar')
                            ->orderBy('kamar_rawatinap.no_kamar')
                            ->get();     

        
        $i = 0;
        foreach ($temp as $element) {
            if($kamarRawatinap[$i]->no_kamar === $element->no_kamar) {
                $kamarRawatinap[$i]->kapasitas_kamar = $element->kapasitas_kamar;
                $i++;
            }
        }

        return $kamarRawatinap;
    }

    public function getAll()
    {
        return KamarRawatinap::all();
    }

    public function getAvailableKamarMinusBooked($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);

        $kamarRawatinap = KamarRawatinap
                    ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                    ->select(DB::raw('kamar_rawatinap.kelas, count(*) as kapasitas_kamar'))
                    ->where('kamar_rawatinap.jenis_kamar', '=', 'Rawat Inap') 
                    ->groupBy('kamar_rawatinap.kelas')
                    ->orderBy('kamar_rawatinap.kelas', 'desc')
                    ->get();

        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.kelas, count(*) as occupied_kamar'))       
                            ->where('pemakaian_kamar_rawatinap.tanggal_booking', '=', $tanggal)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '=', null) 
                            ->groupBy('kamar_rawatinap.kelas')   
                            ->orderBy('kamar_rawatinap.kelas', 'desc')      
                            ->get(); 

        $i = 0;
        foreach ($kamarRawatinap as $element) {
            $element->occupied_kamar = 0;
            if(count($pemakaianKamarRawatinap) > $i) {
                if($pemakaianKamarRawatinap[$i]->kelas == $element->kelas) {
                    $element->occupied_kamar = $pemakaianKamarRawatinap[$i]->occupied_kamar;
                    $i++;
                }
            }
        }

        return $kamarRawatinap;
    }

    public function getAvailableKamarMinusNow($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);

        $kamarRawatinap = KamarRawatinap
                    ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                    ->select(DB::raw('kamar_rawatinap.kelas, count(*) as kapasitas_kamar'))
                    ->where('kamar_rawatinap.jenis_kamar', '=', 'Rawat Inap') 
                    ->groupBy('kamar_rawatinap.kelas')
                    ->orderBy('kamar_rawatinap.kelas', 'desc')
                    ->get();

        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.kelas, count(*) as occupied_kamar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '<', $tanggal)
                            ->where('pemakaian_kamar_rawatinap.perkiraan_waktu_keluar', '>', $tanggal) 
                            ->groupBy('kamar_rawatinap.kelas')   
                            ->orderBy('kamar_rawatinap.kelas', 'desc')      
                            ->get(); 

        $i = 0;
        foreach ($kamarRawatinap as $element) {
            $element->occupied_kamar = 0;
            if(count($pemakaianKamarRawatinap) > $i) {
                if($pemakaianKamarRawatinap[$i]->kelas == $element->kelas) {
                    $element->occupied_kamar = $pemakaianKamarRawatinap[$i]->occupied_kamar;
                    $i++;
                }
            }
        }

        return $kamarRawatinap;
    }

    public function getAvailableKamarMinusBookedByNamaKamar($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);

        $kamarRawatinap = KamarRawatinap
                    ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                    ->select(DB::raw('kamar_rawatinap.no_kamar, kamar_rawatinap.kelas, kamar_rawatinap.harga_per_hari, count(*) as kapasitas_kamar'))
                    ->where('kamar_rawatinap.jenis_kamar', '=', 'Rawat Inap') 
                    ->groupBy('kamar_rawatinap.no_kamar')
                    ->orderBy('kamar_rawatinap.no_kamar', 'desc')
                    ->get();

        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.no_kamar, count(*) as occupied_kamar'))       
                            ->where('pemakaian_kamar_rawatinap.tanggal_booking', '=', $tanggal)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '=', null) 
                            ->groupBy('kamar_rawatinap.no_kamar')   
                            ->orderBy('kamar_rawatinap.no_kamar', 'desc')      
                            ->get(); 

        $i = 0;
        foreach ($kamarRawatinap as $element) {
            $element->occupied_kamar = 0;
            if(count($pemakaianKamarRawatinap) > $i) {
                if($pemakaianKamarRawatinap[$i]->no_kamar == $element->no_kamar) {
                    $element->occupied_kamar = $pemakaianKamarRawatinap[$i]->occupied_kamar;
                    $i++;
                }
            }
        }

        return $kamarRawatinap;
    }

    public function getAvailableKamarMinusNowByNamaKamar($tanggal)
    {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d', $tanggal);

        $kamarRawatinap = KamarRawatinap
                    ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                    ->select(DB::raw('kamar_rawatinap.no_kamar, kamar_rawatinap.kelas, kamar_rawatinap.harga_per_hari, count(*) as kapasitas_kamar'))
                    ->where('kamar_rawatinap.jenis_kamar', '=', 'Rawat Inap') 
                    ->groupBy('kamar_rawatinap.no_kamar')
                    ->orderBy('kamar_rawatinap.no_kamar', 'desc')
                    ->get();

        $pemakaianKamarRawatinap = PemakaianKamarRawatinap
                            ::join('kamar_rawatinap', 'pemakaian_kamar_rawatinap.no_kamar', '=', 'kamar_rawatinap.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.kelas, count(*) as occupied_kamar'))
                            ->where('pemakaian_kamar_rawatinap.waktu_keluar', '=', null)
                            ->where('pemakaian_kamar_rawatinap.waktu_masuk', '<', $tanggal)
                            ->where('pemakaian_kamar_rawatinap.perkiraan_waktu_keluar', '>', $tanggal) 
                            ->groupBy('kamar_rawatinap.kelas')   
                            ->orderBy('kamar_rawatinap.kelas', 'desc')      
                            ->get(); 

        $i = 0;
        foreach ($kamarRawatinap as $element) {
            $element->occupied_kamar = 0;
            if(count($pemakaianKamarRawatinap) > $i) {
                if($pemakaianKamarRawatinap[$i]->no_kamar == $element->no_kamar) {
                    $element->occupied_kamar = $pemakaianKamarRawatinap[$i]->occupied_kamar;
                    $i++;
                }
            }
        }

        return $kamarRawatinap;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kamarRawatinap = new KamarRawatinap;
        $kamarRawatinap->no_kamar = $request->input('no_kamar');
        $kamarRawatinap->jenis_kamar = $request->input('jenis_kamar');
        $kamarRawatinap->kelas = $request->input('kelas');
        $kamarRawatinap->harga_per_hari = $request->input('harga_per_hari');
        $kamarRawatinap->save();

        
        if($kamarRawatinap->kelas == 1) {
            for ($i = 1; $i < 3; $i++) {
                $tempatTidur = new TempatTidur;
                $tempatTidur->no_kamar = $kamarRawatinap->no_kamar;
                $tempatTidur->no_tempat_tidur = $i;
                $tempatTidur->status = 1;
                $tempatTidur->save();
            }
        } else if($kamarRawatinap->kelas == 2) {
            for ($i = 1; $i < 5; $i++) {
                $tempatTidur = new TempatTidur;
                $tempatTidur->no_kamar = $kamarRawatinap->no_kamar;
                $tempatTidur->no_tempat_tidur = $i;
                $tempatTidur->status = 1;
                $tempatTidur->save();
            }
        } else if($kamarRawatinap->kelas == 3) {
            for ($i = 1; $i < 7; $i++) {
                $tempatTidur = new TempatTidur;
                $tempatTidur->no_kamar = $kamarRawatinap->no_kamar;
                $tempatTidur->no_tempat_tidur = $i;
                $tempatTidur->status = 1;
                $tempatTidur->save();
            }
        } else if($kamarRawatinap->kelas == "VIP") {
                $tempatTidur = new TempatTidur;
                $tempatTidur->no_kamar = $kamarRawatinap->no_kamar;
                $tempatTidur->no_tempat_tidur = 1;
                $tempatTidur->status = 1;
                $tempatTidur->save();
        }

        return response($kamarRawatinap, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function show($no_kamar)
    {
        $kamarRawatinap = KamarRawatinap
                            ::join('tempat_tidur', 'kamar_rawatinap.no_kamar', '=', 'tempat_tidur.no_kamar')
                            ->select(DB::raw('kamar_rawatinap.no_kamar, tempat_tidur.no_tempat_tidur, tempat_tidur.status'))
                            ->where('tempat_tidur.no_kamar', '=', $no_kamar)
                            ->orderBy('tempat_tidur.no_tempat_tidur', 'asc')
                            ->get();
        return $kamarRawatinap;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $no_kamar)
    {
        $kamarRawatinap = KamarRawatinap::findOrFail($no_kamar);
        $kamarRawatinap->no_kamar = $request->input('no_kamar');
        $kamarRawatinap->jenis_kamar = $request->input('jenis_kamar');
        $kamarRawatinap->kelas = $request->input('kelas');
        $kamarRawatinap->harga_per_hari = $request->input('harga_per_hari');
        $kamarRawatinap->save();

        return response($kamarRawatinap, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $no_kamar
     * @return \Illuminate\Http\Response
     */
    public function destroy($no_kamar)
    {
        KamarRawatinap::destroy($no_kamar);
        return response('', 204);
    }
}
