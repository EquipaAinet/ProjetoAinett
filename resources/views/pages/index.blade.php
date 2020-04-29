@extends('layout')
@section('content')

<h2>Apresentação</h2>
<p>
    Permitir gerir suas contas Pessoais
</p>
<h3>Informações</h3>
<form action="PageController.php" method="get">
        <div>
            <p>Numero de Utilizadores: <?php echo $users ?></p>
            <p>Numero de Contas: <?php echo $contas ?></p>
            <p>Numero de Movimnentos: <?php echo $movimentos ?></p>
        </div>
</form>

@endsection
