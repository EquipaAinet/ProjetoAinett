<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    public $timestamps = false;

    protected $fillable = ['conta_id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo', ];
}
