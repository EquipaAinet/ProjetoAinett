@extends('layout_admin')
@section('content')
<form method="POST" action="{{route('movimentos.store', ['movimento' => $movimento]) }}" class="form-group">
        @csrf
        @method('POST')
        @include('movimentos.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <button type="reset" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection