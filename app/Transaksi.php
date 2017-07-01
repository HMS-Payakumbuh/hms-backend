<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
	const CREATED_AT = 'waktu_masuk_pasien';
	const UPDATED_AT = 'waktu_perubahan_terakhir';
}
