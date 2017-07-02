<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorium extends Model
{
  protected $table = 'laboratorium';
  protected $primaryKey = 'nama';
  public $incrementing = false;
}
