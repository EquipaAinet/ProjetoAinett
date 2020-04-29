@extends('layout_admin')
@section('title','Alunos' )
@section('content')
<div class="row mb-3">
    <div class="col-3">
        <a  href="{{route('admin.alunos.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Aluno</a>
    </div>
    <div class="col-9">
        <form method="GET" action="{{route('admin.alunos')}}" class="form-group">
            <div class="input-group">
            <select class="custom-select" name="curso" id="inputCurso" aria-label="Curso">
                <option value="" {{'' == old('curso', $selectedCurso) ? 'selected' : ''}}>Todos Cursos</option>
                @foreach ($cursos as $abr => $nome)
                <option value={{$abr}} {{$abr == old('curso', $selectedCurso) ? 'selected' : ''}}>{{$nome}}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">Filtrar</button>
            </div>
            </div>
        </form>
    </div>
</div>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Nº</th>
                <th>Nome</th>
                <th>Curso</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alunos as $aluno)
                <tr>
                    <td>
                        <img src="{{$aluno->user->url_foto ? asset('storage/fotos/' . $aluno->user->url_foto) : asset('img/default_img.png') }}" alt="Foto do aluno"  class="img-profile rounded-circle" style="width:40px;height:40px">
                    </td>
                    <td>{{$aluno->numero}}</td>
                    <td>{{$aluno->user->name}}</td>
                    <td>{{$aluno->cursoRef->nome}}</td>
                    <td><a href="{{route('admin.alunos.edit', ['aluno' => $aluno])}}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('admin.alunos.destroy', ['aluno' => $aluno])}}"" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $alunos->withQueryString()->links() }}
@endsection

