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
        Conta::create($request->all()); 
        return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $validated_data['nome'] . '" foi criada com sucesso!')
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
        $oldName = $conta->nome;
        try {
            $conta->delete();
            return redirect()->route('conta.index')
                ->with('alert-msg', 'Conta "' . $conta->nome . '" foi apagada com sucesso!')
                ->with('alert-type', 'success');
        } catch (\Throwable $th) {
            // $th é a exceção lançada pelo sistema - por norma, erro ocorre no servidor BD MySQL
            // Descomentar a próxima linha para verificar qual a informação que a exceção tem
            //dd($th, $th->errorInfo);

            if ($th->errorInfo[1] == 1451) {   // 1451 - MySQL Error number for "Cannot delete or update a parent row: a foreign key constraint fails (%s)"
                return redirect()->route('conta.index')
                    ->with('alert-msg', 'Não foi possível apagar a Conta "' . $oldName . '", porque esta conta já está em uso!')
                    ->with('alert-type', 'danger');
            } else {
                return redirect()->route('conta.index')
                    ->with('alert-msg', 'Não foi possível apagar a Conta "' . $oldName . '". Erro: ' . $th->errorInfo[2])
                    ->with('alert-type', 'danger');
            }
        }
    }

}


//$movimentos = Movimento::where('conta_id',$conta->id)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
       // return view('movimentos.index', compact('movimentos'));