<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $table = 'diagnosis';

    public function daftarDiagnosis() {
      return $this->belongsTo('App\DaftarDiagnosis', 'kode_diagnosis', 'kode');
    }
}
