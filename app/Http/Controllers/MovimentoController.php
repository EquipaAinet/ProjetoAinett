<?php

namespace App\Http\Controllers;
use App\Movimento;
use App\Conta;
use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        $categoria_tipoR = Categoria::where('tipo','R')->get();
        //dd($categoria_tipoR);
        $categoria_tipoD = Categoria::where('tipo', 'D')->get();

        //$categorias = Categoria::all();
        return view('movimentos.edit', compact('categoria_tipoR', 'categoria_tipoD'))
            ->withMovimento($movimento);
            //->withCategorias($categorias);
    }

    public function update(Request $request, Movimento $movimento)
    {
        if($request->tipo == 'R')
        {
            $validated_data = $request->validate([
                'data' =>                   'required',
                'valor' =>                  'required|numeric|min:0',
                'tipo' =>                   'required|in:R,D',
                'categoria_id' =>           'nullable|numeric',
                'descricao' =>              'nullable|string',
            ]);
        }


    else
    {
        $validated_data = $request->validate([
            'data' =>                   'required',
            'valor' =>                  'required|numeric|min:0',
            'tipo' =>                   'required|in:R,D',
            'categoria_id' =>           'nullable|numeric',
            'descricao' =>              'nullable|string',
        ], [
    
            //error messages
            'data.required' => '"Data" is required.',
            'valor.required' => '"Valor" is required.',
            'tipo.required' => '"Tipo" is required.',
        ]);
    }
        //dd($validated_data);

        //Atualiza automaticamente saldo final e inicial


        $conta = Conta::find($movimento->conta_id);
        $movimentos = Movimento::where('conta_id', $conta->id)
            ->where('data','>=',$movimento->data)
            ->where('id', '>=', $movimento->id)
            ->get();

        //dd($movimentos);

        //$this->calculaSaldos($conta, $movimento);

    
        if($movimento->tipo == 'R')
        {
            if($validated_data['tipo'] == 'R')
            {
            $valorAntigo = $movimento->valor;   
            $valorAdicionar = $validated_data['valor'] - $valorAntigo;
            
            
            $movimento->saldo_inicial = $movimento->saldo_inicial;
            $movimento->saldo_final = $movimento->saldo_final + $valorAdicionar;
            $movimento->fill($validated_data);
            $movimento->save();

 

            foreach($movimentos as $mov)
            {

                $mov->saldo_inicial = $mov->saldo_inicial + $valorAdicionar;
                $mov->saldo_final = $mov->saldo_final + $valorAdicionar;
                $mov->save();
            }
            }
            else
            {
                $valorAdicionar = -$validated_data['valor'];
                $movimento->saldo_inicial = $movimento->saldo_inicial;
                $movimento->saldo_final = $movimento->saldo_inicial - $validated_data['valor'];
                $movimento->fill($validated_data);
                $movimento->save();

                $movimentos[0]->saldo_inicial = $movimentos[0]->saldo_inicial;
                $movimentos[0]->saldo_final = $movimentos[0]->saldo_inicial - $validated_data['valor'];
                foreach($movimentos as $mov)
                {
                    $mov->saldo_inicial = $mov->saldo_inicial - $validated_data['valor'];
                    $mov->saldo_final = $mov->saldo_final - $validated_data['valor'];
                    $mov->save();
                }
            }

        }
        
        else
        {
            $valorAntigo = $movimento->valor;   
            $valorAdicionar = $validated_data['valor'] - $valorAntigo;
            //dd($valorAdicionar);
            
            
            $movimento->saldo_inicial = $movimento->saldo_inicial;
            $movimento->saldo_final = $movimento->saldo_final - $valorAdicionar;
            $movimento->fill($validated_data);
            $movimento->save();

 

            foreach($movimentos as $mov)
            {

                $mov->saldo_inicial = $movimento->saldo_inicial - $valorAdicionar;
                $mov->saldo_final = $mov->saldo_final - $valorAdicionar;
                $mov->save();
            }

        }





        $conta->saldo_atual = $conta->saldo_atual + $valorAdicionar;
        $conta->save();
    
        return redirect()->route('movimento.index', compact('conta'))
            ->with('alert-msg', 'O Movimento "' . $movimento->id . '" foi alterado com sucesso!')
            ->with('alert-type', 'success');

    }

    public function create(Conta $conta)
    {
        $movimento = new Movimento;
        $contaId = $conta->id;
        $categoria_tipoR = Categoria::where('tipo','R')->get();
        //dd($categoria_tipoR);
        $categoria_tipoD = Categoria::where('tipo', 'D')->get();

        //$categorias = Categoria::all();
        //dd($newMovimento);
        return view('movimentos.create', compact('conta', 'categoria_tipoR', 'categoria_tipoD'))
            ->withMovimento($movimento);
            //->withCategorias($categorias);
    }

    public function store(Request $request, Conta $conta)
    {
        if($request->tipo == 'R')
        {
            $validated_data = $request->validate([
                'data' =>                   'required',
                'valor' =>                  'required|numeric|min:0',
                'tipo' =>                   'required|in:R,D',
                'categoria_id' =>           'nullable|numeric',
                'descricao' =>              'nullable|string',
            ]);
        }


    else
    {
        $validated_data = $request->validate([
            'data' =>                   'required',
            'valor' =>                  'required|numeric|min:0',
            'tipo' =>                   'required|in:R,D',
            'categoria_id' =>           'nullable|numeric',
            'descricao' =>              'nullable|string',
        ], [
    
            //error messages
            'data.required' => '"Data" is required.',
            'valor.required' => '"Valor" is required.',
            'tipo.required' => '"Tipo" is required.',
        ]);
    }

        //dd($validated_data);

        //Atualiza automaticamente saldo final e inicial
        if($validated_data['tipo'] == 'R')
        {
            $saldo_inicial=$conta->saldo_atual;
            $conta->saldo_atual = $conta->saldo_atual + $validated_data['valor'];
            $conta->save();
        }
        else
        {
            $saldo_inicial=$conta->saldo_atual;
            $conta->saldo_atual = $conta->saldo_atual - $validated_data['valor'];
            $conta->save();
        }

        $movimento =  Movimento::create([
            'conta_id' => $conta->id,
            'data' => $validated_data['data'],
            'valor' => $validated_data['valor'],
            'saldo_inicial' => $saldo_inicial,
            'saldo_final' => $conta->saldo_atual,
            'tipo' => $validated_data['tipo'],
            'categoria_id' => $validated_data['categoria_id'],
            'descricao' => $validated_data['descricao'],
        ]);
        //dd($movimento);7
        //$this->calculaSaldos($conta->id, $movimento);
        return redirect()->route('movimento.index', compact('conta'))
            ->with('alert-msg', 'O Movimento "' . $movimento->id . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Movimento $movimento)
    {
       
        DB::table('movimentos')->where('id',$movimento->id)->delete();
        
       
        return redirect()->route('conta.index')
            ->with('alert-msg', 'O Movimento foi removido com sucesso!')
            ->with('alert-type', 'success');
    }


    private function calculaSaldos(Conta $conta, Movimento $movimento)
    {
        //$ultimoMoviventoValido = query movimentos, conta_id == x, where('data', '<', $movimento->data)
            //->orderBy('data', 'desc')
            //orderBy('id', 'desc')
            //->first() 
        
        //$movimentosAlterar = query movimentos, conta_id == x, where('data' , '>', $movimento->data)
            //->orderBy('data', 'asc')
            //->orderBy('id', 'asc')
            //->get()

        //se o ultimo valor valido for nulo, o saldo de referencia é o saldo inicial da conta
        
        
        
    }


}
