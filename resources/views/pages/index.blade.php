@extends('layout_admin')
@section('content')

<h2>Apresentação</h2>
<p>
    Permitir gerir suas contas Pessoais
</p>
<h3>Informações</h3>
<form action="PageController.php" method="get">
        <div>
            <p>Número de Utilizadores:  {{ $users }}</p>
            <p>Número de Contas:  {{ $contas }}</p>
            <p>Número de Movimentos:  {{ $movimentos}}</p>
        </div>
</form>

@endsection
