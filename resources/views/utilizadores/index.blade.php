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

                @if($user->foto==null)
                   <td>
                       <img class="img-profile rounded-circle" src="/img/default_img.png" width="50px" height="50px" >
                   </td>
                @else
                   <td>
                       <img class="img-profile rounded-circle" src="{{asset('storage/fotos/'.$user->foto)}}" width="50px" height="50px" >
                   </td>
                @endif

                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><a href="{{route('utilizadores.view', ['id' => $user->id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Visualizar</a></td>

                </tr>
        @endforeach
    </table>
    {{ $listaUtilizadores->withQueryString()->links() }}

@endsection
