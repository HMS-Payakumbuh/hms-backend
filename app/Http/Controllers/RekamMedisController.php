<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Diagnosis;
use App\Pasien;
use App\RekamMedis;
use App\Resep;
use App\Rujukan;
use App\Transaksi;
use Carbon\Carbon;

class RekamMedisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RekamMedis::all();
    }

    public function getForExternal($no_rujukan, $asal_rujukan)
    {
        $rujukan = Rujukan::where('no_rujukan', '=', $no_rujukan)->where('asal_rujukan', '=', $asal_rujukan)->first();
        if ($rujukan) {
            $transaksi = Transaksi::where('id', '=', $rujukan->id_transaksi)->first();
            if ($transaksi) {
                $pasien = Pasien::where('id', '=', $transaksi->id_pasien)->first();
                //var_dump($transaksi->waktu_masuk_pasien);
                if ($pasien) {
                    $rekam_medis = RekamMedis::with('tenaga_medis', 'diagnosis.daftarDiagnosis', 'tindakan.daftarTindakan')
                                            ->where('id_pasien', '=', $pasien->id)
                                            ->where('tanggal_waktu', '=', $transaksi->waktu_masuk_pasien)
                                            ->first();
                    if ($rekam_medis) {
                        //anamnesis
                        $anamnesis = json_decode($rekam_medis->anamnesis);
                        $all_alergi = explode(",", $anamnesis->alergi);
                        $all_riwayat = explode(",", $anamnesis->riwayat_penyakit);
                        $alergi = array();
                        foreach ($all_alergi as $part) {
                            $arr = array(
                                    'td' => array($part, 'Aktif')
                                );
                            array_push($alergi , $arr);
                        }
                        
                        //diagnosis
                        $all_diagnosis = $rekam_medis->diagnosis;
                        $diagnosis = array();
                        foreach ($all_diagnosis as $part) {
                            $complete_diagnosis = $part->daftarDiagnosis->kode.' - '.$part->daftarDiagnosis->nama;
                            array_push($diagnosis , $complete_diagnosis);
                        }

                        //tindakan
                        $all_tindakan = $rekam_medis->tindakan;
                        $tindakan = array();
                        foreach ($all_tindakan as $part) {
                            $arr = array(
                                    'td' => array(
                                        array(
                                           'content' => array(
                                                '@value' => $part->daftarTindakan->kode.' - '.$part->daftarTindakan->nama
                                            )
                                        ),
                                        $rekam_medis->tanggal_waktu
                                    ) 
                                );
                            array_push($tindakan , $arr);
                        }
                        
                        //resep
                        $all_resep = Resep::with('resepItem', 'resepItem.racikanItem', 'resepItem.racikanItem.jenisObat')
                                        ->where('id_transaksi', '=', $transaksi->id)
                                        ->get();;
                        $resep = array();
                        foreach ($all_resep as $all_resep_item) {
                            foreach ($all_resep_item->resepItem as $resep_item) {
                                $racikan = array();
                                foreach ($resep_item->racikanItem as $racikan_item) {
                                    array_push($racikan , 
                                        $racikan_item->jenisObat->nama_generik.' '.
                                        $racikan_item->jumlah.' '.
                                        $racikan_item->jenisObat->satuan
                                    );
                                }
                                $arr = array(
                                        'td' => array(
                                            array(
                                               'content' => $racikan
                                            ),
                                            $resep_item->aturan_pemakaian,
                                            $rekam_medis->tanggal_waktu,
                                            'Aktif',
                                            $resep_item->petunjuk_peracikan
                                        ) 
                                    );
                                array_push($resep , $arr);
                            }
                        }

                        //hasil_pemeriksaan
                        $hasil_pemeriksaan = json_decode($rekam_medis->hasil_pemeriksaan);
                        $hasil = array();
                        foreach ($hasil_pemeriksaan as $key => $value) {
                            $arr = array(
                                        'th' => array(
                                            '@attributes' => array(
                                                'align' => 'left'
                                            ),
                                            '@value' => $key
                                        ),
                                        'td' => array(
                                            'content' => $value
                                        )
                                    );
                            array_push($hasil , $arr);
                        }
                        $hasil_header = array(
                            'th' => array(
                                        array(
                                            '@attributes' => array(
                                            'align' => 'right'
                                            ),
                                            '@value' => 'Date / Time:'
                                        ),
                                    $rekam_medis->tanggal_waktu    
                            )
                        );

                        //tenaga medis
                        $dokter_nama = explode(' ', $rekam_medis->tenaga_medis->nama);
                        $author = array(
                            'assignedAuthor' => array(
                                'assignedPerson' => array(
                                    'name' => array(
                                        'given' => $dokter_nama[0],
                                        'family' => $dokter_nama[1]
                                    )
                                )
                            )
                        );
                        $dataEnterer = array(
                            'assignedEntity' => array(
                                'assignedPerson' => array(
                                    'name' => array(
                                        'given' => $dokter_nama[0],
                                        'family' => $dokter_nama[1]
                                    )
                                )
                            )
                        );

                        //pasien
                        $pasien_nama = explode(' ', $pasien->nama_pasien);
                        $pasien_jender = 'Male';
                        if ($pasien->jender != 1)
                            $pasien_jender = 'Female';
                        $patient = array(
                            'patientRole' => array(
                                'addr' => array(
                                    'streetAddressLine' => $pasien->alamat,
                                    'city' => 'Payakumbuh',
                                    'state' => 'Sumatra Barat',
                                    'country' => 'INA'
                                ),
                                'telecom' => array(
                                    '@attributes' => array(
                                        'value' => $pasien->kontak
                                    )
                                ),
                                'patient' => array(
                                    'name' => array(
                                        'given' => $pasien_nama[0],
                                        'family' => $pasien_nama[1]
                                    ),
                                    'administrativeGenderCode' => array(
                                        '@attributes' => array(
                                            'displayName' => $pasien_jender
                                        )
                                    ),
                                    'birthTime' => array(
                                        '@attributes' => array(
                                            'value' => $pasien->tanggal_lahir
                                        )
                                    ) 
                                ),
                                'providerOrganization' => array(
                                    'name' => 'Rumah Sakit Umum Payakumbuh',
                                    'telecom' => array(
                                        '@attributes' =>array(
                                            'value' => 'tel:(+62)555-1212'
                                        )
                                    ),
                                    'addr' => array(
                                        'streetAddressLine' => 'Jln. Sudirman No 5',
                                        'city' => 'Payakumbuh',
                                        'state' => 'Sumatra Barat',
                                        'country' => 'INA'
                                    )
                                )
                            )
                        );

                        $document =
                        array(
                            'title' => 'Consultation Note',
                            'recordTarget' => $patient,
                            'author' => $author,
                            'dataEnterer' => $dataEnterer,
                            'component' => array(
                                'structuredBody' => array(
                                    'component' => array(
                                        array(
                                          'section' => array(
                                            'title' => 'Allergies, Adverse Reactions, Alerts',
                                            'text' => array(
                                              'table' => array(
                                                    '@attributes' => array(
                                                        'border' => '1',
                                                        'width' => '100%'
                                                    ),
                                                    'thead' => array(
                                                        'tr' => array(
                                                            'th' => array('Substance', 'Status')
                                                        )
                                                    ),
                                                    'tbody' => array(
                                                        'tr' => $alergi
                                                    )
                                                )
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'ASSESSMENT',
                                            'text' => array(
                                              'list' => array(
                                                '@attributes' => array(
                                                    'listType' => 'ordered'
                                                ),
                                                'item' => $diagnosis
                                              )
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'REASON FOR VISIT/CHIEF COMPLAINT',
                                            'text' => array(
                                              'paragraph' => $anamnesis->keluhan
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'HISTORY OF PRESENT ILLNESS',
                                            'text' => array(
                                              'paragraph' => $all_riwayat
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'MEDICATIONS',
                                            'text' => array(
                                              'table' => array(
                                                    '@attributes' => array(
                                                        'border' => '1',
                                                        'width' => '100%'
                                                    ),
                                                    'thead' => array(
                                                        'tr' => array(
                                                            'th' => array('Medication', 'Directions', 'Start Date', 'Status', 'Fill Instructions')
                                                        )
                                                    ),
                                                    'tbody' => array(
                                                        'tr' => $resep
                                                    )
                                                )
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'Procedures',
                                            'text' => array(
                                              'table' => array(
                                                    '@attributes' => array(
                                                        'border' => '1',
                                                        'width' => '100%'
                                                    ),
                                                    'thead' => array(
                                                        'tr' => array(
                                                            'th' => array('Procedure', 'Date')
                                                        )
                                                    ),
                                                    'tbody' => array(
                                                        'tr' => $tindakan
                                                    )
                                                )
                                            )
                                          )
                                        ),
                                        array(
                                          'section' => array(
                                            'title' => 'Vital Signs',
                                            'text' => array(
                                              'table' => array(
                                                    '@attributes' => array(
                                                        'border' => '1',
                                                        'width' => '100%'
                                                    ),
                                                    'thead' => array(
                                                        'tr' => $hasil_header
                                                    ),
                                                    'tbody' => array(
                                                        'tr' => $hasil
                                                    )
                                                )
                                            )
                                          )
                                        ),
                                    )
                                )
                            )
                        );

                        /*$client = new Client();
                        $response = $client->request(
                            'POST', 
                            'http://127.0.0.1:8001/api/rekam_medis/'.$pasien->nama_pasien.'/'.$pasien->kode_pasien.'/'.$no_rujukan, 
                            ['form_params' => ['body' => $document]]
                        )->getBody();*/
                        return response([
                            'nama_pasien' => $pasien->nama_pasien,
                            'kode_pasien' => $pasien->kode_pasien,
                            'no_rujukan' => $no_rujukan,
                            'body' => $document
                        ]);
                    }                        
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rekam_medis = new RekamMedis;
        $rekam_medis->id_pasien = $request->input('id_pasien');
        $rekam_medis->tanggal_waktu = $request->input('tanggal_waktu');
        $rekam_medis->np_dokter = $request->input('np_dokter');
        $rekam_medis->hasil_pemeriksaan = $request->input('hasil_pemeriksaan');
        $rekam_medis->anamnesis = $request->input('anamnesis');
        $rekam_medis->rencana_penatalaksanaan = $request->input('rencana_penatalaksanaan');
        $rekam_medis->pelayanan_lain = $request->input('pelayanan_lain');
        $rekam_medis->save();

        return response($rekam_medis, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id_pasien
     * @return \Illuminate\Http\Response
     */
    public function show($id_pasien)
    {
        $rekam_medis = RekamMedis
                            ::with('pasien', 'tenaga_medis', 'diagnosis.daftarDiagnosis')
                            ->orderBy('tanggal_waktu', 'desc')
                            ->where('id_pasien', '=', $id_pasien)
                            ->get();
        return $rekam_medis;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id_pasien
     * @param  string  $tanggal_waktu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_pasien, $tanggal_waktu)
    {
        $rekam_medis = RekamMedis::where('id_pasien', '=', $id_pasien)
                                ->where('tanggal_waktu', '=', $tanggal_waktu)
                                ->first();
        $rekam_medis->id_pasien = $request->input('id_pasien');
        $rekam_medis->np_dokter = $request->input('np_dokter');
        $rekam_medis->hasil_pemeriksaan = $request->input('hasil_pemeriksaan');
        $rekam_medis->anamnesis = $request->input('anamnesis');
        $rekam_medis->rencana_penatalaksanaan = $request->input('rencana_penatalaksanaan');
        $rekam_medis->pelayanan_lain = $request->input('pelayanan_lain');
        $rekam_medis->perkembangan_pasien = $request->input('perkembangan_pasien');
        $rekam_medis->save();
        return response($rekam_medis, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RekamMedis::destroy($id);
        return response('', 204);
    }
}
