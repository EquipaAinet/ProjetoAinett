<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Conta;


class ContaController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $contas=Conta::where('user_id',$userId)->get();
        return view('conta.index', compact('contas'));
    } 

    public function edit(Conta $conta)
    {
        return view('conta.edit')
            ->withConta($conta);
    }

    public function create()
    {
        $newConta = new Conta;
        return view('conta.create')
            ->withConta($newConta);
    }

    public function store(Request $request)
    {
        $conta=Conta::create($request->all());
        return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $conta->nome . '" foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(Request $request, Conta $conta)
    {
        $conta->fill($request->all());
        $conta->save();
        return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $conta->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Conta $conta)
    {
        Conta::destroy($conta);
        return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $conta->nome . '" foi removida com sucesso!')
            ->with('alert-type', 'success');
    }

}


//$movimentos = Movimento::where('conta_id',$conta->id)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
       // return view('movimentos.index', compact('movimentos'));