<?php

namespace App\Http\Controllers;
use App\Movimento;
use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Conta $contas) {
        //$movimentos = Movimento::where('conta_id',$contas->id)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
        return view('movimentos.index', compact('contas'));
    }
}
