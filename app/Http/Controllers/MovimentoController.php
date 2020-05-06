<?php

namespace App\Http\Controllers;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index() {
        $userId = Auth::id();
        $movimentos = Movimento::where('conta_id', $userId)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
        return view('movimentos.index', compact('movimentos'));
    }
}
