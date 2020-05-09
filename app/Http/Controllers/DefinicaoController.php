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
        $user = Auth::id();
       
        return view('definicoes.edit')->withUser($user);
    }
    public function update(Request $request,User $user) 
    {
        
        return view('definicoes.edit');
    }
   
}