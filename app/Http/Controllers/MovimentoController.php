<?php

namespace App\Http\Controllers;
use App\Movimento;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    public function index() {
        return view('movimentos.index');
    }
}
