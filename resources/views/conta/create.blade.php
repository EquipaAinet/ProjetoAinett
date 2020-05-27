@extends('layout_admin')
@section('content')
    <form method="POST" action="{{route('conta.store', ['conta' => $conta]) }}" class="form-group">
        @csrf
        @method('POST')
        @include('conta.partials.create-edit')
        
        <div class="form-group">
            <label for="inputSaldoAt">Saldo Atual</label>
            <input type="text" class="form-control" name="saldo_atual" id="inputSaldoAt" value="{{old('saldo_atual', $conta->saldo_atual)}}">
            @error('SaldoAt')
                <div class="small text-danger">{{$message}}</div>
            @enderror
        </div>

        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('conta.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection