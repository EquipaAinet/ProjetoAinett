<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;



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
        
        //validar password
        if($request->current_password!=0){
            if (!(\Hash::check($request->current_password,$user->password))) {
                // The passwords matches
                //return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
                return redirect()->route('definicoes.edit')
                    ->with('alert-msg', 'Password não está correta!')
                    ->with('alert-type', 'danger');
                }
        }
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($user->id),
            ],
            'NIF' => 'nullable|digits:9',
            'telefone' => 'nullable',
            'foto' =>'nullable|image|max:8192',
            'current_password' => 'nullable|string|required_with:new_password,new_password_confirmation',
            'new_password' => 'nullable|required_with:current_password,new_password_confirmation|string|different:current_password',
            'new_password_confirmation' => 'same:new_password',

        ]);
        //Foto
        $urlFoto = null;
        if($request->hasFile('foto')){
            
            Storage::delete('/public/fotos/'.$user->foto);
            
            $path = $request->foto->store('public/fotos');
            $urlFoto = basename($path);
        }

       
        
        //Atualizar dados
        if ($request->filled('new_password')) {
            $user->fill([
                'password' => Hash::make($validatedData['new_password']),
            ]);
        }
        

        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'NIF' => $validatedData['NIF'],
            'telefone'=>$validatedData['telefone'],
            'foto'=>$urlFoto,
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