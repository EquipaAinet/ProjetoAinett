@extends('layout_admin')
@section('content')

<h2>Recuperar Contas</h2>


<table class="table">
        <tr>
            
            <th>Contas</th>
            <th>Descricao</th>
            <th>Saldo Abertura</th>
            <th>Saldo Atual(€)</th>
            
        </tr>
        @foreach ($contas as $cont)
            <tr>
                <td>{{$cont->nome}}</td>
                <td>{{$cont->descricao}}</td>
                <td>{{$cont->saldo_abertura}}</td>
                <td>{{$cont->saldo_atual}}€</td>
                <td>
                    <form method="POST" action="{{route('conta.recuperar',['id' => $cont])}}">
                        {{csrf_field()}}
                        {{ method_field('PATCH') }}
                        <input type="submit" class="btn btn-danger btn-sm" value="Recuperar" />
                    </form>
                </td>
               
            </tr>
        @endforeach
</table>
@endsection
