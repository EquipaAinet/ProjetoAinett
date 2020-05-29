@extends('layout_admin')
@section('content')
<form action="{{route('definicoes.destroy', ['user' => $user])}}" method="POST">
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $user->email)}}" >
    @error('email')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputPass">Password</label>
    <input type="password" class="form-control" name="password" id="inputPass">
    @error('password')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group text-right">
    @csrf
    @method("DELETE")
    <input type="submit" class="btn btn-danger btn-sm" value="Eliminar Perfil" />
    <a href="http://projetoainett.test/home" class="btn btn-secondary">Cancel</a>
</div>

        
</form>

@endsection


