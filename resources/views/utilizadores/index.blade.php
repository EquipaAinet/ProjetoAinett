@extends('layout_admin')
@section('title','Lista de Utilizadores' )
@section('content')

    

   
    <table class="table">
    <tr>
        
        <th>Nome</th>
        <th>Email</th>
        
        
    </tr>
        @foreach ($listaUtilizadores as $user)
            <tr>
            <td><img class="img-profile rounded-circle" src="{{ asset('storage/fotos/'.$user->foto)}}" width="50px" height="50px" ></td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td> 
            </tr>
        @endforeach
    </table>
    {{ $listaUtilizadores->withQueryString()->links() }}

@endsection
