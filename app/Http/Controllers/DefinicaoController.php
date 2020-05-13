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
    
   
}