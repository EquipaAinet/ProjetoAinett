@extends('layout_admin')
@section('content')


    <form method="POST" action="{{route('conta.update', ['conta' => $conta]) }}" class="form-group">
        @csrf
        @method('PUT')
        @include('conta.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('conta.index', ['conta' => $conta]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    @if($conta->users()->count() > 0)
    <br/>
    <h3>Utilizadores com os quais esta conta foi partilhada</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Email</th>
            </tr>
        </thead>

        @foreach($conta->users as $user)
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
                <td><a href="{{route('conta.unshare', ['conta' => $conta,'id' => $user->id])}}" class="btn btn-danger btn-sm" role="button" aria-pressed="true">Remover</a></td>
                <td>Tipo Leitura:
                    <a href="{{route('conta.readonly', ['conta' => $conta,'id' => $user->id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true" title="Somente leitura"><i class="fas fa-fw fa-eye"></i></a>
                    <a href="{{route('conta.readwrite', ['conta' => $conta,'id' => $user->id])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true" title="Escrita e leitura"><i class="fas fa-fw fa-edit"></i></a>
                </td>

            </tr>
        @endforeach
    </table>
    @endif

    <br/>
    <h2>Partilhar Conta</h2>
    @include('utilizadores.partials.list')

@endsection
