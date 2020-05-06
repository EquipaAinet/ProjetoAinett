<?php

namespace App\Http\Controllers;
use App\Movimento;
use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Conta $conta) {
       $movimentos = Movimento::where('conta_id',$conta->id)->get();
       return view('movimentos.index', compact('movimentos'));
    }
}
