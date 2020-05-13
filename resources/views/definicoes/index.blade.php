@extends('layout_admin')

@section('content')

<h2>Definicões</h2>

<ul>
    <li>
        <a href="{{route('definicoes.edit')}}">Editar Perfil</a>
    </li>

    <li>
        <a href="{{route('definicoes.apagar', ['user' => $user])}}">Apagar Perfil</a>
    </li>


</ul>

@endsection