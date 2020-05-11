@extends('layout_admin')
@section('content')
    <form method="POST" action="{{route('movimentos.update', ['movimento' => $movimento]) }}" class="form-group">
        @csrf
        @method('PUT')
        @include('movimentos.partials.create-edit')
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('conta.index')}}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection