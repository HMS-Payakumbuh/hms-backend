<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarTindakan extends Model
{
  protected $table = 'daftar_tindakan';
  protected $primaryKey = 'kode';
  public $incrementing = false;
}
