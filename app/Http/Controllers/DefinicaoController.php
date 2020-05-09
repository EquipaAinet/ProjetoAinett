<?php

namespace App\Http\Controllers;

use App\Definicao;
use App\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class DefinicaoController extends Controller
{
    public function index() 
    {
       
        return view('definicoes.index');
    }
    public function edit() 
    {
       
       
        return view('definicoes.edit')->with('user',Auth::User());
    }
    public function update(Request $request,User $user) 
    {
        $user->fill($request->all());
        $user->save();
        return redirect()->route('definicoes.edit')
            ->with('alert-msg', 'Conta "' . $user->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
       
    }
   
}