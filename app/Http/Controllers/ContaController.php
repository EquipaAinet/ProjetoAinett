<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Conta;


class ContaController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $contas=Conta::where('user_id',$userId)->get();
        return view('conta.index', compact('contas'));
    } 
}


//$movimentos = Movimento::where('conta_id',$conta->id)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
       // return view('movimentos.index', compact('movimentos'));