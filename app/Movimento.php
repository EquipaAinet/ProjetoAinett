<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Conta;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimento extends Model
{
    public $timestamps = false;

    use SoftDeletes;

    protected $fillable = ['conta_id','data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo', 'categoria_id', 'descricao','imagem_doc'];

    protected $dates = ['deleted_at'];

    public function conta()
    {
        return $this->belongsTo('App\Conta');
    }

    
}
