@extends('layout_admin')
@section('content')
<form method="POST" action="{{route('movimentos.store', ['conta' => $conta]) }}" class="form-group" enctype="multipart/form-data">
        @csrf
        @method('POST')
        @include('movimentos.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('conta.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection