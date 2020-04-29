<?php

namespace App\Http\Controllers;


use App\Estatistica;
use Illuminate\Http\Request;

class EstatisticaController extends Controller
{
    public function index() 
    {
       
        return view('estatisticas.index');
    }
}