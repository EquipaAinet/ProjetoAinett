@extends('layout_admin')
@section('title','Lista de Utilizadores' )
@section('content')

    @foreach ($listaUtilizadores as $user)
        <span>Utilizador: <b>{{ $user->name }}</b>, Email: <b>{{ $user->email }}</b></span>
        <br />
    @endforeach

    {{ $listaUtilizadores->withQueryString()->links() }}
@endsection
