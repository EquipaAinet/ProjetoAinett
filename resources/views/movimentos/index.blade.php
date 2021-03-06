@extends('layout_admin')
@section('content')

<h4>Conta:{{$conta->nome}}</h4>
<h4>Saldo atual: {{$conta->saldo_atual}} €</h4>

<div class="row mb-3">
    @if($tipoLeitura->first()==0)
    <div class="col-3">
        <a  href="{{route('movimentos.create', ['conta' => $conta])}}" class="btn btn-success" role="button" aria-pressed="true">Novo Movimento</a>
    </div>
    @endif
</div>

<form method="GET" action="http://projetoainett.test/filtro/{{$conta->id}}" class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="filtro" placeholder="Pesquisar movimentos por Tipo(R ou D) ">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Procurar <i class="fas fa-fw fa-search"></i></button>
        </div>
    </div>
</form>


<table class="table">
    <tr>
        <th>Data</th>
        <th>Valor</th>
        <th>Saldo Inicial</th>
        <th>Saldo Final</th>
        <th>Tipo</th>
        <th>Categoria</th>
        <th>Imagem</th>

    </tr>
        @foreach ($movimentos as $mov)
            <tr>
                <td>{{$mov->data}}</td>
                <td>{{$mov->valor}}€</td>
                <td>{{$mov->saldo_inicial}}€</td>
                <td>{{$mov->saldo_final}}€</td>
                <td>
                    @if ($mov->tipo == 'R')
                        Receita
                    @endif
                    @if ($mov->tipo == 'D')
                        Despesa
                    @endif
                </td>
                <td>
                    @foreach($categorias as $cat)
                        @if ($mov->categoria_id == $cat->id)
                            {{$cat->nome}}
                        @endif

                    
                    @endforeach

                </td>

                @if($mov->imagem_doc==null)
                <td>
                    <p>Não Disponível</p>
                </td>
                 @else
                <td>
                    <a href="http://projetoainett.test/movimento/{{$mov->id}}/foto">
                        <img class="img-profile rounded-circle" src="{{route('movimento.foto',['movimento'=>$mov])}}" width="50px" height="50px" >
                    </a>
                </td>
               
                @endif
                <td><a href="{{route('movimentos.edit', ['movimento' => $mov])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('movimentos.destroy',['movimento' => $mov])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar" />
                        </form>
                    </td>
            </tr>
        @endforeach


</table>


{{$movimentos->links()}}




@endsection
