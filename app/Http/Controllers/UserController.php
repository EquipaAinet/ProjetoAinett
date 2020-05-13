<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
<<<<<<< HEAD
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
=======
use Illuminate\Http\Request;
>>>>>>> 654924f1a93421959999c92ca92cf1b585ccec7c

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

<<<<<<< HEAD
   
    public function update(Request $request,User $user) 
    {
        
        
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($user->id),
            ],
            'NIF' => 'nullable|digits:9',
            'telefone' => 'nullable|max:12|min:9',
            'foto' =>'nullable|image|max:8192',
        ]);
        
        
        
        
        $urlFoto = null;

        if($request->hasFile('foto')){
            
            $path = $request->foto->store('public/fotos');
            $urlFoto = basename($path);
        }

       
        
        
        $user->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'NIF' => $validatedData['NIF'],
            'telefone'=>$validatedData['telefone'],
            'foto'=>$urlFoto,
            //'password' => Hash::make($data['password']),
        ]);
        $user->save();
        return redirect()->route('definicoes.edit')
            ->with('alert-msg', 'User "' . $user->name . '" foi alterada com sucesso!')
            ->with('alert-type', 'success');
       
    }
    


    
=======
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
>>>>>>> 654924f1a93421959999c92ca92cf1b585ccec7c
}
/*'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'NIF'=>['nullable','digits:9'],
            'telefone'=>['nullable','digits:9'],
            'foto'=>['nullable','image','max:8192'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],*/