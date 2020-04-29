@extends('layout_admin')
@section('title', 'Novo Aluno' )
@section('content')
    <form method="POST" action="{{route('admin.alunos.store')}}" class="form-group">
        @csrf
        @include('alunos.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.alunos.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
