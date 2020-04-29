@extends('layout_admin')
@section('title','Cursos' )
@section('content')
<div class="row mb-3">
    <a  href="{{route('admin.cursos.create')}}" class="btn btn-success" role="button" aria-pressed="true">Novo Curso</a>
</div>
    <table class="table">
        <thead>
            <tr>
                <th>Abreviatura</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Semestres</th>
                <th>ECTS</th>
                <th>Vagas</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
                <tr>
                    <td>{{$curso->abreviatura}}</td>
                    <td>{{$curso->nome}}</td>
                    <td>{{$curso->tipo}}</td>
                    <td>{{$curso->semestres}}</td>
                    <td>{{$curso->ECTS}}</td>
                    <td>{{$curso->vagas}}</td>
                    <td><a href="{{route('admin.cursos.edit', ['curso' => $curso]) }}" class="btn btn-primary btn-sm" role="button" aria-pressed="true">Alterar</a></td>
                    <td>
                        <form action="{{route('admin.cursos.destroy', ['curso' => $curso]) }}"" method="POST">
                            @csrf
                            @method("DELETE")
                            <input type="submit" class="btn btn-danger btn-sm" value="Apagar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

