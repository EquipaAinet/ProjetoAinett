<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Hash;
use App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->filtro ?? '';

        $listaUtilizadores = User::where('name','LIKE','%'.$filtro.'%')->orWhere('email','LIKE','%'.$filtro.'%')->paginate(10);

        return view('utilizadores.index')->withListaUtilizadores($listaUtilizadores);
    }

    public function viewProfile($id)
    {
        $user = User::findOrFail($id);

        return view('utilizadores.view')->withUser($user);
    }


   
    public function update(Request $request,User $user) 
    {
        
        //Validar
        if (!(\Hash::check($request->current_password,$user->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($user->id),
            ],
            'NIF' => 'nullable|digits:9',
            'telefone' => 'nullable|max:12|min:9',
            'foto' =>'nullable|image|max:8192',
            'current_password' => 'required',
            'new-password' => 'required|string|confirmed',

            
        ]);
        //Foto
        $urlFoto = null;
        if($request->hasFile('foto')){
            
            $path = $request->foto->store('public/fotos');
            $urlFoto = basename($path);
        }

       
        
        //Atualizar dados
        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'NIF' => $validatedData['NIF'],
            'telefone'=>$validatedData['telefone'],
            'foto'=>$urlFoto,
            'password' => Hash::make($validatedData['new-password']),
        ]);
        $user->save();
        return redirect()->route('definicoes.edit')
            ->with('alert-msg', 'User "' . $user->name . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
       
    }
    


    

    public function guardarTipo(Request $request, $id){
        $user = User::findOrFail($id);
        $adm = $request->adm ?? 0;
        $bloqueado = $request->bloqueado ?? 0;

        $user->adm = $adm;
        $user->bloqueado = $bloqueado;
        $user->save();

        return redirect()->back()
            ->with('alert-msg', 'Utilizador alterado com sucesso!')
            ->with('alert-type', 'success');
    }

}
/*'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'NIF'=>['nullable','digits:9'],
            'telefone'=>['nullable','digits:9'],
            'foto'=>['nullable','image','max:8192'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],*/