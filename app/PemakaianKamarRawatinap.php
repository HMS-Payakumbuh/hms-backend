<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PemakaianKamarRawatinap extends Model
{
  protected $table = 'pemakaian_kamar_rawatinap';
  public $incrementing = false;

  public function kamar_rawatinap()
	{
		return $this->belongsTo('App\KamarRawatInap', 'no_kamar', 'no_kamar');
	}
}
