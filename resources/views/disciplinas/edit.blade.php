@extends('layout_admin')
@section('title','Alterar Disciplina' )
@section('content')
    <form method="POST" action="{{route('admin.disciplinas.update', ['disciplina' => $disciplina]) }}" class="form-group">
        @csrf
        @method('PUT')
        @include('disciplinas.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.disciplinas.edit', ['disciplina' => $disciplina]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
