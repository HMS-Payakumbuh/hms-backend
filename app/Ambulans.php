<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambulans extends Model
{
  protected $table = 'ambulans';
  protected $primaryKey = 'nama';
  public $incrementing = false;
}
