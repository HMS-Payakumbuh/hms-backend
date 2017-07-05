<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
	const CREATED_AT = 'waktu_masuk_pasien';
	const UPDATED_AT = 'waktu_perubahan_terakhir';

	public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien');
	}

	public function tindakan()
	{
		return $this->hasMany('App\Tindakan', 'no_transaksi');
	}

	public function obat()
	{
		return $this->hasMany('App\ObatTebus', 'id_transaksi');
	}
}
