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
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td> 
            </tr>
        @endforeach
    </table>
    {{ $listaUtilizadores->withQueryString()->links() }}

@endsection
