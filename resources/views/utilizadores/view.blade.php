@extends('layout_admin')
@section('title','Perfil de Utilizador' )
@section('content')

    @if($user->foto==null)
        <img class="img-profile rounded-circle" src="/img/default_img.png" width="250px" height="250px" >
    @else
        <img class="img-profile rounded-circle" src="{{asset('storage/fotos/'.$user->foto)}}" width="250px" height="250px" >
    @endif

    <h2>{{$user->id}}</h2>
    <h2>{{$user->name}}</h2>
    <h2>{{$user->email}}</h2>

@endsection
