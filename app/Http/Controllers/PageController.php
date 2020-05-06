<?php

namespace App\Http\Controllers;

use App\User;
use App\Conta;
use App\Movimento;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index() 
    {
        $users = User::count();
        $contas = Conta::count();
        $movimentos = Movimento::count();
        return view('pages.index', compact('users', 'contas', 'movimentos'));
    }

}
