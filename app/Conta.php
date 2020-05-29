<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Conta extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'nome', 'descricao', 'saldo_abertura', 'saldo_atual'];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function movimentos()
    {
        return $this->hasMany('App\Movimento', 'Conta', 'nome');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'autorizacoes_contas', 'conta_id', 'user_id');
    }
}
