<form method="GET" action="{{route('utilizadores.index')}}" class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="filtro" placeholder="Pesquisar utilizadores por nome ou email">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Procurar <i class="fas fa-fw fa-search"></i></button>
        </div>
    </div>
</form>

<table class="table">
    <tr>
        <th>Nome</th>
        <th>Email</th>
    </tr>

    @foreach ($listaUtilizadores as $user)
        <tr>

            @if($user->foto==null)
                <td>
                    <img class="img-profile rounded-circle" src="/img/default_img.png" width="50px" height="50px" >
                </td>
            @else
                <td>
                    <img class="img-profile rounded-circle" src="{{asset('storage/fotos/'.$user->foto)}}" width="50px" height="50px" >
                </td>
            @endif

            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            @if(Route::current()->getName()=='utilizadores.index')
                <td><a href="{{route('utilizadores.view', ['id' => $user->id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Visualizar</a></td>
            @elseif(Route::current()->getName()=='conta.edit')
                <td><a href="" class="btn btn-success btn-sm" role="button" aria-pressed="true">Partilhar</a></td>
            @endif

        </tr>
    @endforeach
</table>
{{ $listaUtilizadores->withQueryString()->links() }}
