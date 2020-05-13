<?php

namespace App\Http\Controllers;

use App\Definicao;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
<<<<<<< HEAD
    
=======
    public function update(Request $request,User $user) 
    {
        $user->fill($request->all());
        $user->save();
        return redirect()->route('definicoes.edit')
            ->with('alert-msg', 'Conta "' . $user->nome . '" foi alterada com sucesso!')
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

        if (Hash::check($pass, $hashedPassword)) 
        {
            // Password correta
            User::destroy($user);
            Auth::logout(); 
            return redirect()->route('pages.index')
                ->with('alert-msg', 'User "' . $user->name . '" foi removido com sucesso!')
                ->with('alert-type', 'success');
        }
        else
        {
            return redirect()->route('pages.index')
                ->with('alert-msg', 'Password não está correta!')
                ->with('alert-type', 'danger');
        }
    }
>>>>>>> 654924f1a93421959999c92ca92cf1b585ccec7c
   
}