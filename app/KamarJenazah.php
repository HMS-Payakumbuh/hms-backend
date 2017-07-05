<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KamarJenazah extends Model
{
  protected $table = 'kamar_jenazah';
  protected $primaryKey = 'no_kamar';
  public $incrementing = false;
}
