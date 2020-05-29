<?php

namespace App\Http\Controllers;

use App\Definicao;
use App\User;
use App\Conta;

use App\Movimento;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class DefinicaoController extends Controller
{
    public function index() 
    {
        $user = Auth::user();
        return view('definicoes.index')->withUser($user);
    }
    public function edit() 
    {
        return view('definicoes.edit')->with('user',Auth::User());
    }

    

    public function update(Request $request,User $user) 
    {
        $user->fill($request->all());
        $user->save();
        return redirect()->route('definicoes.edit')
            ->with('alert-msg', 'Conta "' . $user->nome . '"  foi alterada com sucesso!')
            ->with('alert-type', 'success');
       
    }

    public function apagar(User $user)
    {
        return view('definicoes.apagar')->withUser($user);
    }

    public function destroy(User $user, Request $request)
    {
        $pass = $request->input('password');
        $hashedPassword = $user->password;
        

        //$movimentos=Movimento::where('user_id',$user->id)->get();
        $contas = Conta::where('user_id', $user->id)->get();

        if (Hash::check($pass, $hashedPassword)) // Password correta
        {
            // Password correta
            
           
           // $contas = Conta::where('user_id', $user->id)->get();
            
            //movimetnos
            $contas = Conta::where('user_id', $user->id)->get();
            if($contas!=null){
                foreach($contas as $conta){


                Movimento::where('conta_id',$conta->id)->forceDelete();
                    //autorizacoes das contas(onde user id e o proprio)
                    DB::table('autorizacoes_contas')->where('conta_id',$conta->id)->delete();
                }
            }
            
            
            //autorizacoes das contas(onde conta id in lista da contas)
            DB::table('autorizacoes_contas')->where('user_id',$user->id)->delete();
            
            //apagar contas
            Conta::where('user_id',$user->id)->forceDelete();

           
            //apagar foto
            if($user->foto!=0){
            Storage::delete('/public/fotos/'.$user->foto);
            }

           
           //apagar user
            $user->forceDelete();
            Auth::logout(); 
            return redirect()->route('pages.index')
                ->with('alert-msg', 'User "' . $user->name . '" foi removido com sucesso!')
                ->with('alert-type', 'success');
        }
        else
        {
            return redirect()->route('definicoes.apagar',compact('user'))
                ->with('alert-msg', 'Password não está correta!')
                ->with('alert-type', 'danger');
        }
    }

   
}

