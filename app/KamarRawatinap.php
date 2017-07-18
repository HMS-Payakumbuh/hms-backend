<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KamarRawatinap extends Model
{
  protected $table = 'kamar_rawatinap';
  protected $primaryKey = 'no_kamar';
  public $incrementing = false;
}
