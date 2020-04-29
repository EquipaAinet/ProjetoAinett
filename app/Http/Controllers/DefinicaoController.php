<?php

namespace App\Http\Controllers;

use App\Definicao;
use Illuminate\Http\Request;

class DefinicaoController extends Controller
{
    public function index() 
    {
       
        return view('definicaos.index');
    }
}