<?php

namespace App\Http\Controllers;
use App\Movimento;
use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index(Conta $conta) 
    {
        //dd($conta);
        $movimentos = Movimento::where('conta_id',$conta->id)->orderBy('data', 'DESC')->paginate(5);
       return view('movimentos.index')->withMovimentos($movimentos)->withConta($conta);
    }

    public function edit(Movimento $movimento)
    {
        return view('movimentos.edit')
            ->withMovimento($movimento);
    }

    public function update(Request $request, Movimento $movimento)
    {
        $movimento->fill($request->all());
        $movimento->save();
        return redirect()->route('conta.index')
            ->with('alert-msg', 'O Movimento "' . $movimento->id . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function create(Conta $conta)
    {
        $movimento = new Movimento;
        $contaId = $conta->id;
        //dd($newMovimento);
        return view('movimentos.create', compact('conta'))
            ->withMovimento($movimento);
    }

    public function store(Request $request, Conta $conta)
    {
        //dd($conta);
        $movimento =  Movimento::create([
            'conta_id' => $conta->id,
            'data' => $request->data,
            'valor' => $request->valor,
            'saldo_inicial' => $conta->saldo_abertura,
            'saldo_final' => $conta->saldo_atual,
            'tipo' => $request->tipo,
        ]);
        //dd($movimento);
        return redirect()->route('conta.index')
            ->with('alert-msg', 'O Movimento "' . $movimento->id . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Movimento $movimento)
    {
        Movimento::destroy($movimento);
        return redirect()->route('conta.index')
            ->with('alert-msg', 'O Movimento "' . $movimento->id . '" foi removido com sucesso!')
            ->with('alert-type', 'success');
    }
}
