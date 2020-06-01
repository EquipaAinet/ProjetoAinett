@if(Route::current()->getName()=='utilizadores.index')
    <form method="GET" action="{{route('utilizadores.index')}}" class="form-group">
@elseif(Route::current()->getName()=='conta.edit')
    <form method="GET" action="{{route('conta.edit', ['conta' => $conta])}}" class="form-group">
@endif
    <div class="input-group">
        <input type="text" class="form-control" name="filtroNome" placeholder="Pesquisar utilizadores por nome ou email">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Procurar <i class="fas fa-fw fa-search"></i></button>
        </div>
    </div>
    @if(Route::current()->getName()=='utilizadores.index' && Auth::user()->adm==1)
    <div class="input-group mt-2 ml-1">
        <div class="form-check form-check-inline">
            <input type="checkbox" class="form-check-input" id="inputFiltroADM" name="filtroADM" value="1" {{old('adm', $request->filtroADM ?? '')=='1'?'checked':''}}>
            <label class="form-check-label" for="inputFiltroADM">
                Utilizador ADM
            </label>
        </div>
        <div class="form-check form-check-inline">
            <input type="checkbox" class="form-check-input" id="inputFiltroBloq" name="filtroBloq" value="1" {{old('adm', $request->filtroBloq ?? '')=='1'?'checked':''}}>
            <label class="form-check-label" for="inputFiltroBloq">
                Utilizador Bloqueado
            </label>
        </div>
    </div>
    @endif
</form>

<table class="table">
    <tr>
        <th>Foto</th>
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
                <td><a href="{{route('conta.share', ['conta' => $conta,'id' => $user->id])}}" class="btn btn-success btn-sm" role="button" aria-pressed="true">Partilhar</a></td>
            @endif

        </tr>
    @endforeach
</table>
{{ $listaUtilizadores->withQueryString()->links() }}
