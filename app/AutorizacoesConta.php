<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutorizacoesConta extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'conta_id', 'so_leitura', ];
}
