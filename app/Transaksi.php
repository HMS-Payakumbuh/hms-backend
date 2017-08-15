<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
	const CREATED_AT = 'waktu_masuk_pasien';
	const UPDATED_AT = 'waktu_perubahan_terakhir';

	protected $fillable = ['harga_total', 'status_naik_kelas', 'status'];

	public function pasien()
	{
		return $this->belongsTo('App\Pasien', 'id_pasien');
	}

  public function rujukan_pasien()
	{
		return $this->hasOne('App\Rujukan', 'id_transaksi');
	}

	public function tindakan()
	{
		return $this->hasMany('App\Tindakan', 'id_transaksi');
	}

	public function pembayaran()
	{
		return $this->hasMany('App\Pembayaran', 'id_transaksi');
	}

	public function obatTebus()
	{
		return $this->hasMany('App\ObatTebus', 'id_transaksi');
	}

	public function obatEceran()
	{
		return $this->hasMany('App\ObatEceran', 'id_transaksi');
	}

	public function pemakaianKamarRawatInap()
	{
		return $this->hasMany('App\PemakaianKamarRawatInap', 'id_transaksi');
	}
}
