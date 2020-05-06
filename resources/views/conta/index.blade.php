@extends('layout')
@section('content')

<h2>Contas</h2>


       

<table>
    <tr>
        
        <th>Contas</th>
        <th>Descricao</th>
        <th>Saldo Atual(€)</th>
        
    </tr>
        @foreach ($contas as $cont)
            <tr>
            
                <td>
                    <a href="{{route('movimento.index',['conta' => $cont])}}">{{$cont->nome}}</a>
                </td>
                <td>{{$cont->descricao}}</td>
                <td>{{$cont->saldo_atual}}€</td>
            </tr>
        @endforeach
</table>
@endsection
