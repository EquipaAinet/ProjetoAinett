<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


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
        $userId = Auth::id();
        //$contas=Conta::where('user_id',$userId)->get();
        $validated_data = $request->validate([
            //'nome' => [
                //'required','string','max:20',
              //   Rule::unique('')->ignore($user->id),
            //],
            //'nome' =>                  'required|unique:contas,nome|string|max:20' .$user->id,
            'nome' => Rule::unique('contas')->where('user_id',$userId),
            'descricao' =>              'nullable|string|max:255',
            'saldo_abertura' =>         'required|numeric',
            'saldo_atual' =>            'required|numeric',
            'deleted_at' =>             'nullable|timestamp',
        ], [
            //error messages
            'nome.required' => '"Nome" is required.',
            'saldo_abertura' => '"Saldo Abertura" is required.',
            'saldo_atual' => '"Saldo atual" is required.',
        ]);
        $conta=Conta::create([
            'user_id' => Auth::id(),
            'nome' => $validated_data['nome'],
            'descricao' => $validated_data['descricao'],
            'saldo_abertura' => $validated_data['saldo_abertura'],
            'saldo_atual' => $validated_data['saldo_atual'],
        ]);
        //dd($conta); 
        return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $conta->nome . '" foi criada com sucesso!')
            ->with('alert-type', 'success');
    }

    public function update(Request $request, Conta $conta)
    {
        $userId=Auth::id();
        if($request->nome == $conta->nome)
        {
            $validated_data = $request->validate([
                'descricao' =>              'nullable|string|max:255',
                'saldo_abertura' =>         'required|numeric',
                'saldo_atual' =>            'required|numeric',
                'deleted_at' =>             'nullable|timestamp',
            ], [
                //error messages
                'nome.required' => '"Nome" is required.',
                'saldo_abertura' => '"Saldo Abertura" is required.',
                'saldo_atual' => '"Saldo atual" is required.',
            ]);
        }
        //$conta->fill($request->all());
        else {
        $validated_data = $request->validate([
            'nome' => Rule::unique('contas')->where('user_id',$userId),
            'descricao' =>              'nullable|string|max:255',
            'saldo_abertura' =>         'required|numeric',
            'saldo_atual' =>            'required|numeric',
            'deleted_at' =>             'nullable|timestamp',
        ], [
            //error messages
            'nome.required' => '"Nome" is required.',
            'saldo_abertura' => '"Saldo Abertura" is required.',
            'saldo_atual' => '"Saldo atual" is required.',
        ]);
        }
        $conta->fill($validated_data);
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