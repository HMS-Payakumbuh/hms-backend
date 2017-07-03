<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarDiagnosis extends Model
{
    protected $table = 'daftar_diagnosis';
    protected $primaryKey = 'kode';
    public $incrementing = false;
}
