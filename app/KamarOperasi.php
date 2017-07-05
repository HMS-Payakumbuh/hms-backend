<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KamarOperasi extends Model
{
  protected $table = 'kamar_operasi';
  protected $primaryKey = 'no_kamar';
  public $incrementing = false;
}
