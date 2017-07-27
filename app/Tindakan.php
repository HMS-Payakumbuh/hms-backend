<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
  protected $table = 'tindakan';

  public function daftarTindakan() {
    return $this->belongsTo('App\DaftarTindakan', 'kode_tindakan', 'kode');
  }

  public function hasilLab() {
    return $this->hasOne('App\HasilLab', 'id_tindakan', 'id');
  }

  public function tenagaMedis() {
    return $this->hasOne('App\TenagaMedis', 'no_pegawai', 'np_tenaga_medis');
  }

  /**
  *	Get the Pasien of the Tindakan.
  */
  public function pasien()
  {
      return $this->belongsTo('App\Pasien', 'id_pasien');
  }

  /**
  * Get the Transaksi of the Tindakan.
  */
  public function transaksi()
  {
      return $this->belongsTo('App\Transaksi', 'id_transaksi');
  }
}
