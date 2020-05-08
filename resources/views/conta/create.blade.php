@extends('layout_admin')
@section('content')
    <form method="POST" action="{{route('conta.store', ['conta' => $conta]) }}" class="form-group">
        @csrf
        @method('POST')
        @include('conta.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <button type="reset" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection