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

        /*
        $conta = Conta::find($movimento->conta_id);
        $movimentos = Movimento::where('conta_id', $conta->id)
            ->where('data','>=',$movimento->data)
            ->where('id', '>=', $movimento->id)
            ->get();

        //dd($movimentos);

        
        
        $count=0;
        

        foreach($movimentos as $mov){
            if($count==0){//primeira posicoa do valor atualizado
                if($validated_data['tipo']=="R"){
                    $mov->valor=$validated_data["valor"];
                    $mov->saldo_final=$mov->saldo_inicial+$validated_data['valor'];

                   $mov->fill([
                                'data' => $validated_data['data'],
                                'tipo' => $validated_data['tipo'],
                                'descricao' => $validated_data['descricao'],
                                'categoria_id'=>$validated_data['categoria_id'],
                            ]);
                    $mov->save();
                }else{
                    $mov->valor=$validated_data["valor"];
                    $mov->saldo_final=$mov->saldo_inicial-$validated_data['valor']; 
                    $mov->fill([
                        'data' => $validated_data['data'],
                        'tipo' => $validated_data['tipo'],
                        'descricao' => $validated_data['descricao'],
                        'categoria_id'=>$validated_data['categoria_id'],
                    ]);
                
                    $mov->save();
                }
            }else{//alterar os movimentos para cima do valor atualizado
                $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;
               
                if($mov->tipo=="R"){
                    $mov->saldo_final=$mov->saldo_inicial+$mov->valor;
                    $mov->save();
                }else{
                    $mov->saldo_final=$mov->saldo_inicial-$mov->valor;
                    $mov->save();
                }


            }   
            $valor_saldo_atual=$mov->saldo_final;
            $count++;
        }*/
        $conta = Conta::find($movimento->conta_id);
        $movimento->fill([
            'valor'=> $validated_data['valor'],
            'data' => $validated_data['data'],
            'tipo' => $validated_data['tipo'],
            'descricao' => $validated_data['descricao'],
            'categoria_id'=>$validated_data['categoria_id'],
        ]);
        $movimento->save();



        $movimentoAntesDoAlterar = Movimento::where('conta_id', $conta->id)
        ->where('data','<=',$movimento->data)
        ->where('id','!=',$movimento->id)
        ->orderBy('data','DESC')
        ->first();
       
        
        //se tiver algum movimento antes do criado
        if($movimentoAntesDoAlterar!=null){
            $movimento->saldo_inicial=$movimentoAntesDoAlterar->saldo_final;
            $movimento->save();
           
            $this->calculaSaldos($conta, $movimento);
        }else{//se nao tiver movimento anterior ao criado
            $movimento->saldo_inicial=$conta->saldo_abertura;
            $movimento->save();
            $this->calculaSaldos($conta, $movimento);
        }





       /* $conta->saldo_atual =$valor_saldo_atual;
        $conta->save();*/
    
        return redirect()->route('movimento.index', compact('conta'))
            ->with('alert-msg', 'O Movimento com a data "' . $movimento->data . '" foi alterado com sucesso!')
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

        $movimentoAntesDoAlterar = Movimento::where('conta_id', $conta->id)
        ->where('data','<',$movimento->data)
        ->where('id', '<', $movimento->id)
        ->orderBy('id','DESC')
        ->first();
        
        //se tiver algum movimento antes do criado
        if($movimentoAntesDoAlterar!=null){
            $movimento->saldo_inicial=$movimentoAntesDoAlterar->saldo_final;
            $movimento->save();
           
            $this->calculaSaldos($conta, $movimento);
        }else{//se nao tiver movimento anterior ao criado
            $movimento->saldo_inicial=$conta->saldo_abertura;
            $movimento->save();
            $this->calculaSaldos($conta, $movimento);
        }
        
       
        return redirect()->route('movimento.index', compact('conta'))
            ->with('alert-msg', 'O Movimento com data "' . $movimento->data . '" foi criado com sucesso!')
            ->with('alert-type', 'success');
    }

    public function destroy(Movimento $movimento)
    {
        $conta=Conta::findOrfail($movimento->conta_id);
        Movimento::where('id',$movimento->id)->forceDelete();
        
       
        return redirect()->route('movimento.index', compact('conta'))
            ->with('alert-msg', 'O Movimento foi removido com sucesso!')
            ->with('alert-type', 'success');
    }


    private function calculaSaldos(Conta $conta, Movimento $movimento)
    {
        
        //buscar valores acima por ordem de id e data em tabela
        $movimentos = Movimento::where('conta_id', $conta->id)
        ->where('data','>=',$movimento->data)
        ->where('id', '<=', $movimento->id)
        ->get();
        


      
       $count=0;
        
        
        foreach($movimentos as $mov){
            if($count==0){//primeira posicoa do valor atualizado
                if($mov->tipo=="R"){
                    
                    $mov->saldo_final=$mov->saldo_inicial+$mov->valor;
                    $mov->save();
                    
                    
                }else{
                    
                    $mov->saldo_final=$mov->saldo_inicial-$mov->valor;
                    $mov->save();
                   
                   
                }
            }else{//alterar os movimentos para cima do valor atualizado
                $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;
               
                if($mov->tipo=="R"){
                    $mov->saldo_final=$movimentos[$count-1]->saldo_final+$mov->valor;
                    $mov->save();
                }else{
                    $mov->saldo_final=$movimentos[$count-1]->saldo_final-$mov->valor;
                    $mov->save();
                }
                
                

            }   
            $valor_saldo_atual=$mov->saldo_final;
            
            $count++;
        }
        $conta->saldo_atual=$valor_saldo_atual;
        $conta->save();
        

        
    }


}
