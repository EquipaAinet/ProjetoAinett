<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'nome', 'saldo_abertura', 'saldo_atual', ];
}
