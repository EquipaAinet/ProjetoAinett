@extends('layout_admin')
@section('content')

<h2>Contas</h2>

<div class="row mb-3">
    <div class="col-3">
        <a  href="{{route('conta.create')}}" class="btn btn-success" role="button" aria-pressed="true">Nova Conta</a>
    </div>
    <div class="col-3">
        <a  href="{{route('conta.recover')}}" class="btn btn-success" role="button" aria-pressed="true">Recuperar Conta</a>
    </div>
</div>

       

<table class="table">
    <tr>
        
        <th>Contas</th>
        <th>Descricao</th>
        <th>Saldo Abertura</th>
        <th>Saldo Atual(€)</th>
        
    </tr>
        @foreach ($contas as $cont)
            <tr>
            
                <td>
                    <a href="{{route('movimento.index',['conta' => $cont])}}">{{$cont->nome}}</a>
                </td>
                <td>{{$cont->descricao}}</td>
                <td>{{$cont->saldo_abertura}}</td>
                <td>{{$cont->saldo_atual}}€</td>
                <td><a href="{{route('conta.edit', ['conta' => $cont])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('conta.destroy',['conta' => $cont])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar" />
                        </form>
                    </td>
            </tr>
        @endforeach
</table>
@endsection
