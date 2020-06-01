<?php

namespace App\Http\Controllers;
use App\Movimento;
use App\Conta;
use App\Categoria;
use App\AutorizacoesConta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MovimentoController extends Controller
{
    public function index(Conta $conta)
    {
        //dd($conta);
        $movimentos = Movimento::where('conta_id',$conta->id)->orderBy('data', 'DESC')->paginate(5);
        $tipoLeitura = AutorizacoesConta::where('conta_id',$conta->id)->pluck('so_leitura') ?? 0;
       return view('movimentos.index')->withMovimentos($movimentos)->withConta($conta)->withTipoLeitura($tipoLeitura);
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
                'foto'=>              'nullable|image|max:8192',
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
            'foto'=>              'nullable|image|max:8192',
        ], [

            //error messages
            'data.required' => '"Data" is required.',
            'valor.required' => '"Valor" is required.',
            'tipo.required' => '"Tipo" is required.',
        ]);
    }

        //Alterar foto
        $urlFoto = null;

        if(request()->hasFile('foto')){
            
            $path = request()->foto->store('docs');
            $urlFoto = basename($path);
            Storage::delete('docs'.$movimento->imagem_doc);
        }


       //alterar informacoes do movimento
        $conta = Conta::find($movimento->conta_id);
        $movimento->fill([
            'valor'=> $validated_data['valor'],
            'data' => $validated_data['data'],
            'tipo' => $validated_data['tipo'],
            'descricao' => $validated_data['descricao'],
            'categoria_id'=>$validated_data['categoria_id'],
            'imagem_doc'=>$urlFoto,
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
           
            $this->calculaSaldosUpdate($conta, $movimento);
        }else{//se nao tiver movimento anterior ao criado
            $movimento->saldo_inicial=$conta->saldo_abertura;
            $movimento->save();
            $this->calculaSaldosUpdate($conta, $movimento);
        }

    
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
                'data' =>                   'required|date',
                'valor' =>                  'required|numeric|min:0',
                'tipo' =>                   'required|in:R,D',
                'categoria_id' =>           'nullable|numeric',
                'descricao' =>              'nullable|string',
                'foto'=>              'nullable|image|max:8192',
            ]);

            
        } else
        {
        $validated_data = $request->validate([
            'data' =>                   'required|date',
            'valor' =>                  'required|numeric|min:0',
            'tipo' =>                   'required|in:R,D',
            'categoria_id' =>           'nullable|numeric',
            'descricao' =>              'nullable|string',
            'foto'=>              'nullable|image|max:8192',
        ], [

            //error messages
            'data.required' => '"Data" is required.',
            'valor.required' => '"Valor" is required.',
            'tipo.required' => '"Tipo" is required.',
        ]);
         }

   
        
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

        $urlFoto = null;

        if(request()->hasFile('foto')){
            
            $path = request()->foto->store('docs');
            $urlFoto = basename($path);
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
            'imagem_doc'=>$urlFoto,
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
        $movimentoAntesDoAlterado = Movimento::where('conta_id', $conta->id)
        ->where('data','<=',$movimento->data)
        ->where('id', '!=', $movimento->id)
        ->orderBy('data','DESC')
        ->first();

        if($movimento->imagem_doc!=null){
            Storage::delete('docs/'.$movimento->imagem_doc);
        }
       

        if($movimentoAntesDoAlterado==null){
            Movimento::where('id',$movimento->id)->forceDelete();
            $this->calculaSaldosApagar($conta,null);
        }else{
            Movimento::where('id',$movimento->id)->forceDelete();
            $this->calculaSaldosApagar($conta,$movimentoAntesDoAlterado);
        }
        
        
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

    private function calculaSaldosUpdate($conta, $movimento)
    {
        //vai buscar o movimento que esta a ser alterado e todos acima dele
        $movimentos = Movimento::where('conta_id', $conta->id)
        ->where('data','>=',$movimento->data)
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


    private function calculaSaldosApagar($conta,$movimentoAntesDoAlterado)
    {
        
        //recebe o movimento antes do apagado ou null se nao tiver movimento anterior
        $count=0;
        if($movimentoAntesDoAlterado==null){//nao tem movimento anterior
            $movimentos=Movimento::where('conta_id',$conta->id)
            ->orderby('data','ASC')
            ->get();

            $Null=null;
                foreach($movimentos as $movi){

                    $Null=1;
                }
            
            if( $Null!=null){ //tem movimentos pra cima
                foreach($movimentos as $mov){
                    if($count==0){
                        if($mov->tipo == 'R')
                        {
                            $mov->saldo_inicial=$conta->saldo_abertura;    
                            $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                            $mov->save();
                        }
                        else
                        {
                            $mov->saldo_inicial=$conta->saldo_abertura;
                            $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                            $mov->save();
                        }
                    }else{
                        
                        
                        if($mov->tipo == 'R')
                        {
                            $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;   
                            $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                            $mov->save();
                        }
                        else
                        {
                            $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;
                            $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                            $mov->save();
                        }
                    }
                    $count++;
                    $conta->saldo_atual=$mov->saldo_final;
                    $conta->save();
                 }

            }else{//nao tem movimentos pra cima
                $conta->saldo_atual=$conta->saldo_abertura;
                $conta->save();

            }
        }
        if($movimentoAntesDoAlterado!=null){

                //vai buscar movimentos depois do movimentoAntesDoAlterado
                $movimentos = Movimento::where('conta_id', $conta->id)
                ->where('data','>=',$movimentoAntesDoAlterado->data)
                ->where('id','!=',$movimentoAntesDoAlterado->id)
                ->orderBy('data','ASC')
                ->get();

                $Null=null;
                foreach($movimentos as $movi){

                    $Null=1;
                }

                

                if($Null==1){//Ouver movimentos a seguir ao alterado
                    foreach($movimentos as $mov)
                    {
                                if($count==0){
                                   
                                   
                                    if($mov->tipo == 'R')
                                    {
                                        $mov->saldo_inicial = $movimentoAntesDoAlterado->saldo_final;
                                        $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                                        $mov->save();
                                    }
                                    else
                                    {
                                        $mov->saldo_inicial = $movimentoAntesDoAlterado->saldo_final;
                                        $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                                        $mov->save();
                                    }

                                }else{
                                
                                    if($mov->tipo == 'R')
                                    {
                                        $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;    
                                        $mov->saldo_final = $mov->saldo_inicial + $mov->valor;
                                        $mov->save();
                                    }
                                    else
                                    {
                                        $mov->saldo_inicial=$movimentos[$count-1]->saldo_final;
                                        $mov->saldo_final = $mov->saldo_inicial - $mov->valor;
                                        $mov->save();
                                    }
                                }

                                $conta->saldo_atual=$mov->saldo_final;
                                $conta->save();
                                $count++;
                        }
                }else{//se nao ouver movimentos a seguir ao alterado

                   
                    
                    $conta->saldo_atual=$movimentoAntesDoAlterado->saldo_final;
                    $conta->save();
                    
                }
        }
       
    }

    public function show_foto(Movimento $movimento){
        if(!Auth::check()){
           abort(401);
        }

        $user = Auth::user();
        $conta = Conta::findOrFail($movimento->conta_id);

        if($movimento->imagem_doc!=null && $user->id==$conta->user_id){
            return response()->file(storage_path('app/docs/'.$movimento->imagem_doc));
        }
        abort(401);
    }

}
