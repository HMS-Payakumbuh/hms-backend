<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntrianFrontOffice extends Model
{
    protected $table = 'antrian_front_office';
    protected $primaryKey = 'id';
    const CREATED_AT = 'waktu_masuk_antrian';
    const UPDATED_AT = 'waktu_perubahan_antrian';
}