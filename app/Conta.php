<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'nome', 'descricao', 'saldo_abertura', 'saldo_atual'];

    public function movimentos()
    {
        return $this->hasMany('App\Movimento', 'Conta', 'nome');
    }
}
