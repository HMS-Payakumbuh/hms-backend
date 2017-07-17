<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
  protected $table = 'dokter';
  protected $primaryKey = 'no_pegawai';
  public $incrementing = false;

  public function tenagaMedis() {
    return $this->hasOne('App\TenagaMedis', 'no_pegawai');
  }
}
