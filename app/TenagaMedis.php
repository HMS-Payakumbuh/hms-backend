<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenagaMedis extends Model
{
  protected $table = 'tenaga_medis';
  protected $primaryKey = 'no_pegawai';
  public $incrementing = false;
}
