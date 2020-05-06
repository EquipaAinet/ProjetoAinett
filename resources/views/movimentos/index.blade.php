@extends('layout_admin')
@section('content')

<h2>Movimentos</h2>


<table class="table">
    <tr>
        <th>Data</th>
        <th>Valor</th>
        <th>Saldo Inicial</th>
        <th>Saldo Final</th>
        <th>Tipo</th>

    </tr>
        @foreach ($movimentos as $mov)
            <tr>
                <td>{{$mov->data}}</td>
                <td>{{$mov->valor}}€</td>
                <td>{{$mov->saldo_inicial}}€</td>
                <td>{{$mov->saldo_final}}€</td>
                <td>{{$mov->tipo}}</td>
            </tr>
        @endforeach
        

</table>
{{$movimentos->links()}}    
       
       


@endsection
