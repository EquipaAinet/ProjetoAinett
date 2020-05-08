@extends('layout_admin')
@section('content')
    <form method="POST" action="{{route('conta.update', ['conta' => $conta]) }}" class="form-group">
        @csrf
        @method('PUT')
        @include('conta.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('conta.edit', ['conta' => $conta]) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection