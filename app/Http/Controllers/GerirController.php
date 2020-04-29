<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerirController extends Controller
{
    public function index() 
    {
        return view('gerir.index');
    }
}