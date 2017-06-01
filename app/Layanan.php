<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
	protected $table = 'layanan';
	protected $primaryKey = 'nama_layanan';
	protected $incrementing = false;
}