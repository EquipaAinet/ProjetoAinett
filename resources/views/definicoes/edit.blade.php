@extends('layout_admin')
@section('content')
<h3>{{ __('Editar Perfil') }}</h3>
    <form method="POST" action="#" class="multipart/form-data">
        @csrf
        @method('PUT')
        <h1>{{$user->name}}</h1>
       
        
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('pages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection