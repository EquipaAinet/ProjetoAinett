@extends('layout_admin')
@section('content')

<h2>Contas</h2>

<div class="row mb-3">
    <a  href="{{route('conta.create')}}" class="btn btn-success mr-4 ml-2" role="button" aria-pressed="true">Nova Conta</a>
    <a  href="{{route('conta.recover')}}" class="btn btn-success mr-4" role="button" aria-pressed="true">Recuperar Conta</a>
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

           {{-- @foreach($cont->users as $user)
                @dd($user)
            @endforeach--}}
        @endforeach
</table>

<hr/>
<br/>

@if(Auth::user()->contas != null)
    <h2>Contas Partilhadas Consigo</h2>

    <table class="table">
        <tr>
            <th>Contas</th>
            <th>Descricao</th>
            <th>Saldo Abertura</th>
            <th>Saldo Atual(€)</th>
        </tr>

        @foreach(Auth::user()->contas as $conta)
            <td>
                <a href="{{route('movimento.index',['conta' => $conta])}}">{{$conta->nome}}</a>
            </td>
            <td>{{$conta->descricao}}</td>
            <td>{{$conta->saldo_abertura}}</td>
            <td>{{$conta->saldo_atual}}€</td>
        @endforeach
    </table>
@endif

@endsection
