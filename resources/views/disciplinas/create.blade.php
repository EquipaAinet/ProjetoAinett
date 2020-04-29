@extends('layout_admin')
@section('title', 'Nova Disciplina' )
@section('content')
    <form method="POST" action="{{route('admin.disciplinas.store')}}" class="form-group">
        @csrf
        @include('disciplinas.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.disciplinas.create')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
