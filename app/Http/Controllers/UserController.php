<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $listaUtilizadores = User::paginate(10);

        return view('utilizadores.index')->withListaUtilizadores($listaUtilizadores);
    }

    public function viewProfile($id)
    {
        $user = User::findOrFail($id);

        return view('utilizadores.view')->withUser($user);
    }

    public function guardarTipo(Request $request, $id){
        $user = User::findOrFail($id);
        $adm = $request->adm ?? 0;

        $user->adm = $adm;
        $user->save();

        return view('utilizadores.view')
            ->withUser($user)
            ->with('alert-msg', 'Utilizador alterado com sucesso!')
            ->with('alert-type', 'success');
    }
}
