@extends('layout_admin')
@section('title','Alterar Docente' )
@section('content')
    <form method="POST" action="{{route('admin.docentes.update', ['docente' => $docente]) }}" class="form-group">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{$docente->user_id}}">
        @include('docentes.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('admin.docentes.edit', ['docente' => $docente]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
