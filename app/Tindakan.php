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
    return $this->has('App\HasilLab', 'id_tindakan', 'id');
  }
}
