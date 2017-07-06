<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
  protected $table = 'tindakan';

  public function daftarTindakan() {
    return $this->belongsTo('App\DaftarTindakan');
  }
}
