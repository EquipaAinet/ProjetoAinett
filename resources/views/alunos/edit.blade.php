@extends('layout_admin')
@section('title','Alterar Aluno' )
@section('content')
    <form method="POST" action="{{route('admin.alunos.update', ['aluno' => $aluno]) }}" class="form-group">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{$aluno->user_id}}">
        @include('alunos.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.alunos.edit', ['aluno' => $aluno]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
