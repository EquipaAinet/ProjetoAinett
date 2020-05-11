<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conta;

class Movimento extends Model
{
    public $timestamps = false;

    protected $fillable = ['conta_id','data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo', ];

    public function conta()
    {
        return $this->belongsTo('App\Conta');
    }

}
