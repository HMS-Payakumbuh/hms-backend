<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poliklinik extends Model
{
  protected $table = 'poliklinik';
  protected $primaryKey = 'nama';
  public $incrementing = false;
}
