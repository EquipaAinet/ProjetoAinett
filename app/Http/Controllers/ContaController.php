<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Movimento;
use App\Conta;
use App\User;
use App\AutorizacoesConta;

class ContaController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $contas=Conta::where('user_id',$userId)->get();

        return view('conta.index')->withContas($contas);
    }

    public function edit(Request $request, Conta $conta)
    {
        $filtro = $request->filtro ?? '';

        $listaUtilizadores = User::where('name','LIKE','%'.$filtro.'%')->orWhere('email','LIKE','%'.$filtro.'%')->paginate(10); //->get()
        //$contaPartilhadas = Conta::where('id')

        return view('conta.edit')->withConta($conta)->withListaUtilizadores($listaUtilizadores);
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
            'nome' => [
                'required','string','max:20',
                Rule::unique('contas')->where('user_id',$userId),
            ],
            'descricao' =>              'nullable|string|max:255',
            'saldo_abertura' =>         'required|numeric',
        ], [
            //error messages
            'nome.required' => '"Nome" is required.',
            'saldo_abertura.required' => '"Saldo Abertura" is required.',
        ]);
        $conta=Conta::create([
            'user_id' => Auth::id(),
            'nome' => $validated_data['nome'],
            'descricao' => $validated_data['descricao'],
            'saldo_abertura' => $validated_data['saldo_abertura'],
            'saldo_atual' => $validated_data['saldo_abertura'],
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

            ], [
                //error messages
                //'nome.required' => '"Nome" is required.',
                'saldo_abertura.required' => '"Saldo Abertura" is required.',

            ]);
        }
        //$conta->fill($request->all());
        else {
        $validated_data = $request->validate([
            'nome' => ['required','string','max:20',
                Rule::unique('contas')->where('user_id',$userId),
            ],
            'descricao' =>              'nullable|string|max:255',
            'saldo_abertura' =>         'required|numeric',

        ], [
            //error messages
            'nome.required' => '"Nome" is required.',
            'saldo_abertura.required' => '"Saldo Abertura" is required.',

        ]);
        }

        $saldo_abertura_antigo=$conta->saldo_abertura;

        $conta->fill($validated_data);
        $conta->save();

        if($request->saldo_abertura!=$saldo_abertura_antigo){

            $this->calculaSaldosUpdate($conta);
        }

         return redirect()->route('conta.index')
            ->with('alert-msg', 'Conta "' . $conta->nome . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
    }
    //soft dete da conta
    public function destroy(Conta $conta)
    {
        $movimentos = Movimento::where('conta_id',$conta->id)->delete();

        $conta->delete();
        return redirect()->route('conta.index')
            ->with('alert-msg','Conta "' . $conta->nome . '" foi removida com sucesso!')
            ->with('alert-type', 'success');
    }
    //contas que podem ser recuperadas
    public function recover()
    {
        $userId=Auth::id();
        $contas=Conta::onlyTrashed()
        ->where('user_id',$userId)
        ->get();

        return view('conta.recover')
            ->withContas($contas);

    }
    //conta a recuperar
    public function recuperar($id)
    {
        Conta::onlyTrashed()
        ->where('id',$id)
        ->restore();

        Movimento::withTrashed()
        ->where('conta_id',$id)
        ->restore();

        $conta=Conta::findOrfail($id);


       return redirect()->route('conta.index')
        ->with('alert-msg','Conta '.$conta->nome.' foi recuperada com sucesso!')
        ->with('alert-type', 'success');


    }
    //contar a eliminar
    public function delete($id){

        $conta=Conta::onlyTrashed()
        ->findOrfail($id);



        DB::table('autorizacoes_contas')->where('conta_id',$id)->delete();
        Movimento::where('conta_id',$id)->forceDelete();
        Conta::where('id',$id)->forceDelete();


        return redirect()->route('conta.index')
        ->with('alert-msg','Conta ' .$conta->nome . ' foi removida com sucesso!')
        ->with('alert-type', 'success');

    }

    public function share(Conta $conta, $id)
    {
        $conta->users()->attach($id);
        $userName=User::where('id',$id)->pluck('name')->first();

        return redirect()->route('conta.index')
            ->with('alert-msg','Conta '.$conta->nome.' foi partilhada com '.$userName)
            ->with('alert-type', 'success');
    }

    public function unshare(Conta $conta, $id)
    {
        $conta->users()->detach($id);

        $userName=User::where('id',$id)->pluck('name')->first();

        return redirect()->route('conta.index')
            ->with('alert-msg','Conta '.$conta->nome.' teve a partilha com '.$userName.'removida com sucesso!')
            ->with('alert-type', 'success');
    }


    private function calculaSaldosUpdate($conta)
    {
        //vai buscar os movimentos todos por data ascendente
        $movimentos = Movimento::where('conta_id', $conta->id)
        ->orderby('data','ASC')
        ->get();


        $count=0;


        foreach($movimentos as $mov){
            if($count==0){//primeiro movimento
                $mov->saldo_inicial=$conta->saldo_abertura;
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

    public function readonly(Conta $conta, $id)
    {
        AutorizacoesConta::where(['conta_id'=>$conta->id, 'user_id'=>$id])->update(['so_leitura' => 1]);

        $userName=User::where('id',$id)->pluck('name')->first();

        return redirect()->route('conta.index')
            ->with('alert-msg','Conta '.$conta->nome.' partilhada com '.$userName.' foi alterada para somente leitura.')
            ->with('alert-type', 'success');
    }

    public function readwrite(Conta $conta, $id)
    {
        AutorizacoesConta::where(['conta_id'=>$conta->id, 'user_id'=>$id])->update(['so_leitura' => 0]);

        $userName=User::where('id',$id)->pluck('name')->first();

        return redirect()->route('conta.index')
            ->with('alert-msg','Conta '.$conta->nome.' partilhada com '.$userName.' foi alterada para leitura e escrita.')
            ->with('alert-type', 'success');
    }
}

//$movimentos = Movimento::where('conta_id',$conta->id)->get(['id', 'data', 'valor', 'saldo_inicial', 'saldo_final', 'tipo']);
       // return view('movimentos.index', compact('movimentos'));
