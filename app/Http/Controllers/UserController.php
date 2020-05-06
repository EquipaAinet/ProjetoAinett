<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //$userId = Auth::id();
        //$listaUtilizadores = Movimento::where('conta_id', $userId)->get();

        $listaUtilizadores = User::paginate(10);

        return view('utilizadores.index')->withListaUtilizadores($listaUtilizadores);
    }
}
