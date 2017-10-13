<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Klaim;
use Excel;
use DateTime;
use DateInterval;

class KlaimController extends Controller
{
    private function getKlaim($id = null)
    {
        if (isset($id)) {
            return Klaim::with(['pembayaran.transaksi', 'asuransi.pasien'])->findOrFail($id);
        } else {
            return Klaim::with(['pembayaran', 'asuransi.pasien'])->get();
        }
    }

    public function export(Request $request)
    {
        if ($request->input('tanggal_awal') !== null && $request->input('tanggal_akhir') !== null) {
            $tanggal_awal = new DateTime($request->input('tanggal_awal'));
            $tanggal_akhir = new DateTime($request->input('tanggal_akhir'));
            $tanggal_akhir->add(new DateInterval("P1D")); // Plus 1 day

            $all_klaim = Klaim::with(['pembayaran', 'asuransi.pasien'])
                ->whereBetween('created_at', array($tanggal_awal, $tanggal_akhir))
                ->get();

            $data = array(
                array('Waktu Klaim', 'Nama Pasien', 'Kode Pasien', 'Nomor Pembayaran', 'Total Pembayaran', 'Tarif Klaim', 'Surplus Klaim')
            );

            $total_pembayaran = 0;
            $total_tarif = 0;
            $total_surplus = 0;

            foreach ($all_klaim as $klaim) {
                $surplus = 0;
                $surplus = $klaim->tarif - $klaim->pembayaran->harga_bayar;
                $total_pembayaran += $klaim->pembayaran->harga_bayar;
                $total_tarif += $klaim->tarif;
                $total_surplus += $surplus;

                $klaim_array = array(
                    $klaim->created_at,
                    $klaim->asuransi->pasien->nama_pasien,
                    $klaim->asuransi->pasien->kode_pasien,
                    $klaim->pembayaran->no_pembayaran,
                    $klaim->pembayaran->harga_bayar,
                    $klaim->tarif,
                    $surplus
                );
                array_push($data, $klaim_array);
            }

            $total_array = array('Total', '', '', '', $total_pembayaran, $total_tarif, $total_surplus);
            array_push($data, $total_array);

            $tanggal_awal = $tanggal_awal->format('Y/m/d');
            $tanggal_akhir = $tanggal_akhir->format('Y/m/d');
            $title = "Data Klaim ".$tanggal_awal." - ".$tanggal_akhir;
            return Excel::create($title, function($excel) use ($data) {
                $excel->setTitle('Data Klaim')
                        ->setCreator('user')
                        ->setCompany('RSUD Payakumbuh')
                        ->setDescription('Data Klaim');
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
            'allKlaim' => $this->getKlaim()
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
        $payload = $request->input('klaim');
        $klaim = new Klaim;
        $klaim->id_pembayaran = $payload['id_pembayaran'];
        $klaim->id_asuransi = $payload['id_asuransi'];
        $klaim->status = 'processing';
        $klaim->save();

        if ($klaim->save) {
            return response()->json([
                'klaim' => $klaim
            ], 201);
        }
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
            'klaim' => $this->getKlaim($id)
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
        $payload = $request->input('klaim');
        $klaim = Klaim::findOrFail($id);
        $klaim->status = $payload['status'];
        $klaim->tarif = $payload['tarif'];

        if ($klaim->save()) {
            return response()->json([
                'klaim' => $klaim
            ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Klaim::destroy($id);
    }
}
