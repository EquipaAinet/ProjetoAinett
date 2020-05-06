@extends('layout')
@section('content')

<h2>movimentos</h2>
<h2>{{$movimentos}}</h2>
<table>
    <tr>
        
        <th>Data</th>
        <th>Saldo inicial</th>
        
        
    </tr>
        @foreach ($movimentos as $mov)
            <tr>
            
                
                <td>{{$mov->data}}</td>
                <td>{{$mov->saldo_inicial}}€</td>
            </tr>
        @endforeach
</table>
       


@endsection
