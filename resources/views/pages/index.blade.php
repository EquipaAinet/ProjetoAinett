@extends('layout')
@section('content')

<h2>Apresentação</h2>
<p>
    Permitir gerir suas contas Pessoais
</p>
<h3>Informações</h3>
<form action="PageController.php" method="get">
        <div>
            <p>Numero de Utilizadores:  {{ $users }}</p>
            <p>Numero de Contas:  {{ $contas }}</p>
            <p>Numero de Movimentos:  {{ $movimentos}}</p>
        </div>
</form>

@endsection
